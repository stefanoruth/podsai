<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Http\Resources\EpisodeResource;

class PodcastEpisodeController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($podcast, $episode)
    {
        return EpisodeResource::make(Episode::with('podcast', 'userCompletion')->where('podcast_id', $podcast)->findOrFail($episode));
    }
}
