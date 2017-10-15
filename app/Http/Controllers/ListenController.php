<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Http\Resources\EpisodeResource;
use App\Http\Resources\ListenResource;
use Illuminate\Support\Facades\Auth;

class ListenController
{
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

        Auth::user()->listens()->create([
            'episode_id' => request('id'),
        ]);

        return EpisodeResource::make(
            Episode::findOrFail(request('id'))
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
        return ListenResource::make(
            Auth::user()->listens()->with('episode')->where('episode_id', $id)->firstOrFail()
        );
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

        Auth::user()->listens()->updateOrCreate(['episode_id' => $id], $update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->episodes()->where('id', $id)->delete();
    }
}
