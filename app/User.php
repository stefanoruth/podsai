<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function podcasts()
    {
        return $this->belongsToMany(Podcast::class, 'user_podcasts')->withTimestamps();
    }

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'user_episodes')
                    ->withTimestamps()
                    ->withPivot('time', 'completed_at')
                    ->as('listen');
    }

    public function isSubscribed(Podcast $podcast)
    {
        return $this->podcasts()->where('podcast_id', $podcast->id)->exists();
    }

    public function latestsEpisodes($count = 10)
    {
        return Episode::with('podcast')
            ->whereIn('podcast_id', $this->podcasts()->pluck('id'))
            ->orderBy('published_at', 'DESC')
            ->take($count)->get();
    }
}
