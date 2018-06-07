<?php

namespace App\Http\Controllers;

use App\Http\Resources\PodcastResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PodcastResource::collection(
            Auth::user()->podcasts()->withCount('episodes')->with('subscription')->orderBy('title', 'ASC')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store()
    {
        request()->validate([
            'podcast_id' => 'required',
        ]);

        Auth::user()->podcasts()->sync(request('podcast_id'), false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        Auth::user()->podcasts()->detach($id);
    }
}
