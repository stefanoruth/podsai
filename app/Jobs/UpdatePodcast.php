<?php

namespace App\Jobs;

use App\Channel\Rss;
use App\Podcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $rss = Rss::handle($this->podcast->url);
        
        $this->podcast->fill([
            'title'       => formatInput($rss->title),
            'description' => formatInput($rss->description),
            'logo'        => formatInput($rss->logo),
            'domain'      => formatInput($rss->domain),
        ]);
        $this->podcast->save();

        foreach ($rss->items as $episode) {
            $this->podcast->episodes()->updateOrCreate([
                'key' => $episode->key,
            ], [
                'title'        => formatInput($episode->title),
                'description'  => formatInput(str_limit($episode->description, 1950)),
                'link'         => formatInput($episode->link),
                'audio'        => formatInput($episode->audio),
                'published_at' => strtotime($episode->published_at),
            ]);
        }
    }
}
