<?php

namespace App\Http\Controllers;

use App\Episode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EpisodeListenerController
{
    /**
     * Store a newly created resource in storage.
     *
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

        $episode = Episode::findOrFail(request('id'));

        return Auth::user()->episodes()->save($episode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return Auth::user()->episodes()->updateExistingPivot(request('id'), ['time' => request('time')]);
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
