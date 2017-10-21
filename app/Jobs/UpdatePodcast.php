<?php

namespace App\Jobs;

use App\Podcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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
        $feed = simplexml_load_string(Zttp::contentType('text/xml')->get($this->podcast->url)->body());
        
        $this->updatePodcast($feed);

        collect($feed->xpath('/rss/channel/item'))->each(function($item){
            $this->updateEpisode($item);
        });
    }

    /**
     * Updates the podcast it self.
     * @param  \SimpleXmlElement $feed
     * @return void
     */
    protected function updatePodcast($feed)
    {
        $itunes = $feed->channel->children('http://www.itunes.com/dtds/podcast-1.0.dtd');

        $title = formatInput($feed->channel->title);
        $avatar = formatInput($itunes->image->attributes()['href'] ?? $feed->channel->image->url);

        $filename = Str::slug($title);
        $extension = pathinfo($avatar, PATHINFO_EXTENSION);

        $this->podcast->update([
            'title' => $title,
            'logo'  => "{$filename}.{$extension}",
            'meta'  => [
                'description' => formatInput($feed->channel->description),
                'avatar'      => $avatar,
                'domain'      => formatInput($feed->channel->link),
            ],
        ]);

        $file = storage_path("app/public/logos/{$filename}.{$extension}");

        if (!file_exists($file)) {
            Image::make($avatar)->fit(128, 128)->save($file);
        }
    }

    /**
     * Updates a single episode.
     * @param  \SimpleXmlElement $item
     * @return void
     */
    protected function updateEpisode($item)
    {
        $itunes = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd');

        $this->podcast->episodes()->updateOrCreate([
            'key' => formatInput($item->guid),
        ], [
            'title'        => formatInput($item->title),
            'audio'        => formatInput($item->enclosure->attributes()['url']),
            'published_at' => strtotime($item->pubDate),
            'meta'         => [
                'length'      => value(function() use ($itunes){
                    $duration = formatInput($itunes->duration);

                    if (strpos($duration, ':') === false) {
                        return gmdate('H:i:s', $duration);
                    }

                    return $duration;
                }),
                'season'      => formatInput($itunes->season),
                'number'      => formatInput($itunes->episode),
                'link'        => formatInput($item->link),
                'description' => strip_tags(formatInput($item->description)),
                'show_notes'  => preg_replace("/(<a)/", '<a target="_blank" rel="noreferrer"', formatInput($item->children('http://purl.org/rss/1.0/modules/content/')->encoded)),
            ],
        ]);
    }
}
