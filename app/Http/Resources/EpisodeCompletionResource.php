<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EpisodeCompletionResource extends Resource
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
            'duration'  => $this->time ?? 0,
            'completed' => !is_null($this->completed_at),
            'episode'   => EpisodeResource::make($this->whenLoaded('episode')),
        ];
    }
}
