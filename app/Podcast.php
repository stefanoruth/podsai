<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Podcast extends Model
{
    use Searchable;

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
        'meta' => 'object',
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

    /** 
     * Logo url path
     * @return string
     */
    public function logo()
    {
        return url("storage/logos/{$this->logo}");
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title'       => $this->title,
            'domain'      => $this->meta->domain,
            'description' => $this->meta->description,
        ];
    }
}
