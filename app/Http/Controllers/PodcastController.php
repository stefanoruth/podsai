<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodcastResource;
use App\Jobs\UpdatePodcast;
use App\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PodcastController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PodcastResource::collection(Podcast::with(['subscription', 'episodes' => function ($query) {
            $query->with('userCompletions', 'podcast')->sortLatest();
        }])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'url' => 'required',
        ]);

        $podcast = Podcast::firstOrCreate([
            'url' => request('url'),
        ]);

        dispatch_now(new UpdatePodcast($podcast));

        return PodcastResource::make($podcast);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PodcastResource::make(Podcast::with(['subscription', 'episodes' => function ($query) {
            $query->with('podcast')->sortLatest();
        }])->findOrFail($id));
    }
}
