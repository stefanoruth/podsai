<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodcastResource;
use App\Podcast;

class TopPodcastController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PodcastResource::collection(Podcast::with('subscription')->withCount('users')->has('users')->orderBy('users_count', 'DESC')->take(12)->get());
    }
}
