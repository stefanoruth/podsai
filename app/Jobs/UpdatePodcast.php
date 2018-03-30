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
use App\Exceptions\PodcastLoadingException;
use Carbon\Carbon;

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
        $res = Zttp::contentType('text/xml')->get($this->podcast->url);

        if (!$res->isSuccess()) {
            throw new PodcastLoadingException(
                sprintf(
                    "%s - %s",
                    $this->podcast->title,
                    $this->podcast->url
                ),
                $res->status()
            );
        }

        $feed = simplexml_load_string($res->body());
        
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
        $url = parse_url($avatar);

        $filename = Str::slug($title);
        $extension = pathinfo($url['path'], PATHINFO_EXTENSION);
        if (strlen($extension) == 0) {
            $extension = pathinfo($url['query'], PATHINFO_EXTENSION);
        }

        $this->podcast->fill([
            'title' => $title,
            'logo'  => "{$filename}.{$extension}",
            'meta'  => [
                'description' => $this->formatInput($feed->channel->description),
                'avatar'      => $avatar,
                'domain'      => $this->formatInput($feed->channel->link),
            ],
        ])->save();

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
            'audio'        => $this->formatInput(str_replace('http://', 'https://', $item->enclosure->attributes()['url'])),
            'published_at' => strtotime($item->pubDate),
            'meta'         => [
                'length'      => value(function () use ($itunes) {
                    $time = $this->formatInput($itunes->duration);

                    if (substr_count($time, ':') == 2) {
                        $val = explode(':', $time);
                        
                        $duration = ($val[0]*60*60) + ($val[1]*60) + $val[2];
                    } elseif (substr_count($time, ':') == 1) {
                        $val = explode(':', $time);

                        $duration = ($val[0] * 60) + $val[1];
                    } else {
                        $duration = $time;
                    }

                    return Carbon::createFromFormat('H:i:s', gmdate('H:i:s', $duration))->diffInMinutes(Carbon::parse(date('Y-m-d 00:00:00'))) . ' min';
                }),
                'season'      => $this->formatInput($itunes->season),
                'number'      => $this->formatInput($itunes->episode),
                'link'        => $this->formatInput($item->link),
                'description' => strip_tags($this->formatInput($item->description)),
                'show_notes'  => preg_replace("/(<a)/", '<a target="_blank" rel="noopener"', $this->formatInput($item->children('http://purl.org/rss/1.0/modules/content/')->encoded)),
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
