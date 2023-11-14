<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::where('is_public', 1)->orderByDesc('created_at')->paginate(12);
        return Inertia::render('Frontend/Movies/Index', [
            'movies' => $movies
        ]);
    }

    public function show(Movie $movie)
    {
        if($movie->is_public === 0) {
            abort(404);
        }
        if(auth()->user()) {
            $user = User::find(auth()->user()->id);
            $watchlist = $user->movies()->where('watchable_type', Movie::class)
                ->where('watchable_id', $movie->id)
                ->exists();
        }else {
            $watchlist = false;
        }

        $latest = Movie::where('id', '!=', $movie->id)->orderByDesc('created_at')->take(9)->get();
        return Inertia::render('Frontend/Movies/Show', [
            'movie' => $movie,
            'latests' => $latest,
            'casts' => $movie->casts,
            'movie_genres' => $movie->genres,
            'tags' => $movie->tags,
            'trailers' => $movie->trailers,
            'downloads' => $movie->downloads,
            'is_added_to_watchlist' => $watchlist
        ]);
    }

    public function watchlist(Movie $movie)
    {
        $watchlistMovie = Watchlist::where(['user_id' => auth()->user()->id, 'watchable_id' => $movie->id, 'watchable_type' => Movie::class])->first();
        if ($watchlistMovie) {
            $watchlistMovie->delete();
        } else {
            $user = User::find(auth()->user()->id);
            $watchlistMovie = new Watchlist();
            $watchlistMovie->user_id = $user->id;
            $watchlistMovie->watchable_id = $movie->id;
            $watchlistMovie->watchable_type = Movie::class;
            $watchlistMovie->save();
        }
        return redirect()->back();
    }
}
