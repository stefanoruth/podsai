<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodcastSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'podcast_id' => 'required',
        ]);

        auth()->user()->podcasts()->sync(request('podcast_id'), false);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->podcasts()->detach($id);

        return redirect()->back();
    }
}
