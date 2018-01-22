<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
            return view('app');
        }

        return view('welcome');
    }
}
