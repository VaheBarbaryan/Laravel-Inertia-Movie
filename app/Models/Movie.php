<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'slug',
        'poster_path',
        'release_date',
        'runtime',
        'lang',
        'video_format',
        'is_public',
        'visits',
        'backdrop_path',
        'rating',
        'rate_count',
        'overview',
        'adult'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function trailers()
    {
        return $this->morphMany(TrailerUrl::class, 'trailerable');
    }

    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function casts()
    {
        return $this->belongsToMany(Cast::class, 'cast_movie');
    }

    public function watchlists()
    {
        return $this->morphToMany(User::class, 'watchable', 'watchlist');
    }

}
