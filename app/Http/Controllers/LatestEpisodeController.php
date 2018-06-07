<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EpisodeResource;
use App\Episode;

class LatestEpisodeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EpisodeResource::collection(\Auth::user()->latestsEpisodes()->take(20)->get());
    }
}
