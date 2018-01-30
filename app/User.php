<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany(EpisodeCompletion::class);
    }

    /**
     * Checks if the user is subscribe to a specefic podcast.
     * @param  Podcast $podcast
     * @return boolean
     */
    public function isSubscribed(Podcast $podcast)
    {
        return $this->podcasts()->where('podcast_id', $podcast->id)->exists();
    }

    /**
     * @return \Illuminte\Database\Query\Builder
     */
    public function scopeLatestsEpisodes()
    {
        return Episode::with('podcast', 'userCompletion')
            ->whereIn('podcast_id', $this->podcasts()->pluck('id'))
            ->orderBy('published_at', 'DESC');
    }

    /**
     * Resizes the users avatar image
     * @return string
     */
    public function getAvatarAttribute()
    {
        return sprintf('%s?sz=256', $this->image);
    }
}
