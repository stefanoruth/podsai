<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodcastResource;
use App\Jobs\UpdatePodcast;
use App\Podcast;
use Illuminate\Http\Request;

class PodcastController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PodcastResource::collection(Podcast::with(['episodes' => function($query){
            $query->sortLatest();
        }])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required',
        ]);

        $podcast = Podcast::firstOrCreate([
            'url' => $request->get('url'),
        ]);

        $this->dispatch(new UpdatePodcast($podcast));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PodcastResource::make(Podcast::with(['episodes' => function($query){
            $query->sortLatest();
        }])->findOrFail($id));
    }
}
