<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Http\Resources\EpisodeResource;
use Illuminate\Http\Request;

class EpisodeController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return EpisodeResource::make(Episode::with('podcast')->findOrFail($id));
    }
}
