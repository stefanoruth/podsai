<?php

namespace App\Jobs;

use App\Podcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Zttp\Zttp;

class UpdatePodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $feed = simplexml_load_string(Zttp::contentType('text/feed')->get($this->podcast->url)->body());
        
        $this->podcast->update([
            'title'       => formatInput((string) $feed->channel->title),
            'description' => formatInput((string) $feed->channel->description),
            'logo'        => formatInput((string) $feed->channel->image->url ?? null),
            'domain'      => formatInput((string) $feed->channel->link),
        ]);

        collect($feed->xpath('//channel//item'))->each(function($item){
            $this->podcast->episodes()->updateOrCreate([
                'key' => (string) $item->guid,
            ], [
                'title'        => formatInput((string) $item->title),
                'description'  => formatInput(str_limit((string) $item->description, 1950)),
                'link'         => formatInput((string) $item->link),
                'audio'        => formatInput((string) $item->enclosure->attributes()['url']),
                'published_at' => strtotime((string) $item->pubDate),
            ]);
        });
    }
}
