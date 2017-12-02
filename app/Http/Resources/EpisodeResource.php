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
            'description_short' => str_limit(data_get($this->meta, 'description'), 130),
            'description'       => data_get($this->meta, 'description'),
            'published_at'      => $this->published_at->format('Y-m-d H:i:s'),
            'season'            => $this->transform(data_get($this->meta, 'season'), function ($value) {
                return (int) $value;
            }),
            'number'            => $this->transform(data_get($this->meta, 'number'), function ($value) {
                return (int) $value;
            }),
            'length'            => data_get($this->meta, 'length'),
            'show_notes'        => data_get($this->meta, 'show_notes'),
            'podcast'           => PodcastResource::make($this->whenLoaded('podcast')),
            'completion'        => EpisodeCompletionResource::make($this->whenLoaded('userCompletion')),
        ];
    }
}
