<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return UserResource::make(User::withCount('episodes')->with(['episodes' => function($q){
            $q->where('completed_at', '>', now()->subMonth())->selectRaw('COUNT(completed_at) as completed_count')->addSelect('completed_at', 'user_id')->groupBy('completed_at')->groupBy('user_id');
        }])->with('podcasts')->findOrFail(Auth::id()));
    }
}
