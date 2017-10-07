<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->dispatch(new \App\Jobs\UpdatePodcast(\App\Podcast::where('title', 'LIKE', '%Percent%')->firstOrFail()));
        \Auth::loginUsingId(1);
        return view('app');
    }
}
