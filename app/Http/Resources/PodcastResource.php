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
            'id'             => $this->id,
            'title'          => $this->title,
            'logo'           => $this->logo(),
            'domain'         => str_replace('www.', '', parse_url($this->meta->domain, PHP_URL_HOST)),
            'domain_url'     => $this->meta->domain,
            'description'    => $this->meta->description,
            'subscribed'     => $this->when($this->relationLoaded('subscription'), function () {
                return !is_null($this->subscription);
            }),
            'episodes_count' => $this->when(isset($this->episodes_count), $this->episodes_count),
            'episodes'       => EpisodeResource::collection($this->whenLoaded('episodes')),
        ];
    }
}
