<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
    ];

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_podcasts')->withTimestamps();
    }

    public function getLogoAttribute($value)
    {
        return url("storage/logos/{$value}");
    }
}
