<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $movies = Movie::where('is_public', 1)->orderByDesc('updated_at')->take(12)->get();
        $tvShows = TvShow::orderByDesc('updated_at')->take(12)->get();
        return Inertia::render('Welcome', [
            'movies' => $movies,
            'tvShows' => $tvShows
        ]);
    }

    public function show(Movie $movie)
    {

    }
}
