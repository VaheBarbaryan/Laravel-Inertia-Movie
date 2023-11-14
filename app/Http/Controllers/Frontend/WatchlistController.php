<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchlistController extends Controller
{
    public function index()
    {
        return Inertia::render('Watchlist', [
            'movies' => auth()->user()->movies()->orderBy('watchlist.created_at', 'DESC')->get(),
            'tvShows' => auth()->user()->tvShows()->orderBy('watchlist.created_at', 'DESC')->get()
        ]);
    }
}
