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

        collect($feed->xpath('/rss/channel/item'))->each(function ($item) {
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

        $title = $this->formatInput($feed->channel->title);
        $avatar = $this->formatInput($itunes->image->attributes()['href'] ?? $feed->channel->image->url);
        $avatar = substr($avatar, 0, strpos($avatar, '?'));

        $filename = Str::slug($title);
        $extension = pathinfo($avatar, PATHINFO_EXTENSION);

        $this->podcast->update([
            'title' => $title,
            'logo'  => "{$filename}.{$extension}",
            'meta'  => [
                'description' => $this->formatInput($feed->channel->description),
                'avatar'      => $avatar,
                'domain'      => $this->formatInput($feed->channel->link),
            ],
        ]);

        $file = storage_path("app/public/logos/{$filename}.{$extension}");

        if (!file_exists($file)) {
            Image::make($avatar)->fit(256, 256)->save($file);
        }
    }

    /**
     * Updates a single episode.
     * @param  \SimpleXmlElement $item
     * @return void
     */
    protected function updateEpisode($item)
    {
        if (!isset($item->enclosure)) {
            return;
        }

        $itunes = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd');

        $this->podcast->episodes()->updateOrCreate([
            'key' => $this->formatInput($item->guid),
        ], [
            'title'        => $this->formatInput($item->title),
            'audio'        => $this->formatInput($item->enclosure->attributes()['url']),
            'published_at' => strtotime($item->pubDate),
            'meta'         => [
                'length'      => value(function () use ($itunes) {
                    $duration = $this->formatInput($itunes->duration);

                    if (strpos($duration, ':') === false) {
                        return gmdate('H:i:s', $duration);
                    }

                    return $duration;
                }),
                'season'      => $this->formatInput($itunes->season),
                'number'      => $this->formatInput($itunes->episode),
                'link'        => $this->formatInput($item->link),
                'description' => strip_tags($this->formatInput($item->description)),
                'show_notes'  => preg_replace("/(<a)/", '<a target="_blank" rel="noreferrer"', $this->formatInput($item->children('http://purl.org/rss/1.0/modules/content/')->encoded)),
            ],
        ]);
    }

    /**
     * Formats a value
     * @param  string $value
     * @return mixed
     */
    private function formatInput($value)
    {
        if ($value instanceof \SimpleXMLElement) {
            $value = (string) $value;
        }
        
        if (strlen(trim($value)) > 0) {
            return trim($value);
        }
    }
}
