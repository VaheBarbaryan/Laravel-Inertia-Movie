<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CastController extends Controller
{
    public function index()
    {
        $casts = Cast::orderByDesc('created_at')->paginate(12);
        return Inertia::render('Frontend/Casts/Index', [
            'casts' => $casts
        ]);
    }

    public function show(Cast $cast)
    {
        $movies = $cast->movies;
        return Inertia::render('Frontend/Casts/Show', [
           'cast' => $cast,
           'movies' => $movies
        ]);
    }
}
