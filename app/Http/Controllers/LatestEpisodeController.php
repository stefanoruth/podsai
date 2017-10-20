<?php

namespace App\Http\Controllers;

use App\Http\Resources\EpisodeResource;
use Illuminate\Support\Facades\Auth;

class LatestEpisodeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EpisodeResource::collection(Auth::user()->latestsEpisodes());
    }
}
