<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EpisodeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'audio'        => $this->audio,
            'link'         => data_get($this->meta, 'link'),
            'show_notes'   => data_get($this->meta, 'description'),
            'published_at' => $this->published_at->format('Y-m-d H:i:s'),
            'season'       => $this->transform(data_get($this->meta, 'season'), function($value){return (int) $value;}),
            'episode'      => $this->transform(data_get($this->meta, 'episode'), function($value){return (int) $value;}),
            'podcast'      => PodcastResource::make($this->whenLoaded('podcast')),
        ];
    }
}
