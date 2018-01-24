<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Podcast;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'   => $this->name,
            'email'  => $this->email,
            'avatar' => $this->avatar,
            'joined' => $this->created_at->diffForHumans(),
            'episodes_completed' => $this->when(isset($this->episodes_count), $this->episodes_count),
            'last_episodes' => $this->whenLoaded('episodes'),
            'subscriptions' => PodcastResource::collection($this->whenLoaded('podcasts')),
        ];
    }
}
