<?php

namespace App\Channel;

class Rss
{
    public static function handle($url)
    {
        $xml = simplexml_load_string(file_get_contents($url));

        // return $xml;
        return (object) [
            'domain'      => (string) $xml->channel->link,
            'title'       => (string) $xml->channel->title,
            'description' => (string) $xml->channel->description,
            'logo'        => (string) $xml->channel->image->url ?? null,
            'items'       => collect($xml->xpath('//channel//item'))->map(function($item) {
                return (object) [
                    'title'        => (string) $item->title,
                    'key'          => (string) $item->guid,
                    'description'  => (string) $item->description,
                    'link'         => (string) $item->link,
                    'published_at' => (string) $item->pubDate,
                    'audio'        => (string) $item->enclosure->attributes()['url'],
                ];
            })->all(),
        ];
    }
}