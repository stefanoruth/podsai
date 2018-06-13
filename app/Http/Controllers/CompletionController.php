<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Http\Resources\EpisodeCompletionResource;
use App\Http\Resources\ListenResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EpisodeResource;

class CompletionController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $completion = Auth::user()->episodes()->with('episode.podcast')->orderBy('updated_at', 'DESC')->first();

        if (is_null($completion) || !is_null($completion->completed_at)) {
            return;
        }

        return EpisodeCompletionResource::make($completion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'id' => [
                'required',
                'exists:episodes,id',
            ],
        ]);

        Auth::user()->episodes()->create([
            'episode_id' => request('id'),
        ]);

        return EpisodeResource::make(
            Episode::with('podcast')->findOrFail(request('id'))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $completion = Auth::user()->episodes()->where('episode_id', $id)->first();

        if (is_null($completion)) {
            return;
        }

        return EpisodeCompletionResource::make($completion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        if (request('complete')) {
            $update = ['completed_at' => time(), 'time' => 0];
        } else {
            request()->validate([
                'time' => 'required',
            ]);
            
            $update = ['time' => request('time')];
        }

        return EpisodeCompletionResource::make(
            Auth::user()->episodes()->updateOrCreate(['episode_id' => $id], $update)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Auth::user()->episodes()->where('episode_id', $id)->delete();
    }
}
