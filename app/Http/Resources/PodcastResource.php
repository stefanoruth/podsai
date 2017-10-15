<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PodcastResource extends Resource
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
            'id'          => $this->id,
            'title'       => $this->title,
            'logo'        => $this->logo,
            'description' => $this->meta->description,
            'episodes'    => EpisodeResource::collection($this->whenLoaded('episodes')),
        ];
    }
}
