<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodcastResource;
use App\Podcast;

class TrendingPodcastController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PodcastResource::collection(
            Podcast::withCount('users')->withCount('episodes')->orderBy('users_count', 'DESC')->take(20)->get()
        );
    }
}
