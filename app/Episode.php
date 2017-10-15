<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Episode extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'object',
    ];

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }

    /**
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function listens()
    {
        return $this->hasMany(Listen::class);
    }

    /** 
     * Relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function listen()
    {
        return $this->hasOne(Listen::class)->where('user_id', Auth::id());
    }

    /** 
     * Sort episodes by newest first
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortLatest($query)
    {
        return $query->orderBy('published_at', 'DESC');
    }

    /**
     * Filter empty values off the data.
     * @param array $value
     */
    public function setMetaAttribute($value)
    {
        $filtered = array_filter($value);

        if (count($filtered) == 0) {
            $this->attributes['meta'] = null;
        } else {
            $this->attributes['meta'] = json_encode($filtered);
        }
    }
}
