<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\EpisodeCompletion;

class UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::make(User::withCount('episodes')->with(['episodes' => function ($query) {
            $query->whereYear('completed_at', date('Y'))
                ->groupBy(\DB::raw('WEEK(completed_at, 3)'), 'user_id')
                ->selectRaw('COUNT(completed_at) as count, WEEK(completed_at, 3) as week, user_id');
        }])->with(['podcasts' => function ($query) {
            $query->orderBy('title', 'ASC');
        }])->findOrFail(Auth::id()));
    }
}
