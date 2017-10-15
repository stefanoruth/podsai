<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ListenResource extends Resource
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
            'duration'  => $this->time,
            'completed' => !is_null($this->completed_at),
            'episode'   => EpisodeResource::make($this->whenLoaded('episode')),
        ];
    }
}
