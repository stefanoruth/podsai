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
            'id'                => $this->id,
            'title'             => $this->title,
            'audio'             => $this->audio,
            'link'              => data_get($this->meta, 'link'),
            'published_at'      => optional($this->published_at)->format('d. M Y'),
            'season'            => $this->transform(data_get($this->meta, 'season'), function ($value) {
                return (int) $value;
            }),
            'number'            => $this->transform(data_get($this->meta, 'number'), function ($value) {
                return (int) $value;
            }),
            'length'            => $this->duration,
            'show_notes'        => data_get($this->meta, 'show_notes') ?? nl2br(data_get($this->meta, 'description')),
            'podcast'           => PodcastResource::make($this->whenLoaded('podcast')),
            'completion'        => EpisodeCompletionResource::make($this->whenLoaded('userCompletion')),
        ];
    }
}
