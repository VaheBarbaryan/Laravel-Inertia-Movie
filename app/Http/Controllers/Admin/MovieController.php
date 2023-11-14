<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $column = $request->column ?: 'id';
        $direction = $request->direction ?: 'desc';
        $movies = Movie::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
            })
            ->orderBy($column, $direction)
            ->paginate($perPage);
        $movies->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('Movies/Index', [
            'movies' => $movies,
            'filters' => $filters,
            'column' => $column,
            'direction' => $direction,
        ]);
    }

    public function store(Request $request)
    {
        $movie = Movie::where('tmdb_id', $request->movieTMDBId)->exists();
        if ($movie) {
            return redirect()->back()->with('flash.banner', 'Movie Exists!');
        }
        $apiMovie = Http::get(config('services.tmdb.endpoint') . 'movie/' . $request->movieTMDBId . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($apiMovie->successful()) {
            $newMovie = $apiMovie->json();
            $created_movie = Movie::create([
                'tmdb_id' => $newMovie['id'],
                'title' => $newMovie['title'],
                'runtime' => $newMovie['runtime'],
                'rating' => $newMovie['vote_average'],
                'rate_count' => $newMovie['vote_count'],
                'release_date' => $newMovie['release_date'],
                'lang' => $newMovie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'overview' => $newMovie['overview'],
                'poster_path' => $newMovie['poster_path'],
                'backdrop_path' => $newMovie['backdrop_path'],
                'adult' => 0
            ]);
            $tmdb_genres = $newMovie['genres'];
            $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
            $created_movie->genres()->attach($genres);
            return redirect()->back()->with('flash.banner', 'Movie Generated!');
        } else {
            return redirect()->back()->with('flash.banner', 'Api Error!');
        }
    }

    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Edit', [
            'movie' => $movie
        ]);
    }

    public function update(Movie $movie, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'poster_path' => 'required',
            'runtime' => 'required',
            'lang' => 'required',
            'video_format' => 'required',
            'rating' => 'required',
            'backdrop_path' => 'required',
            'overview' => 'required',
            'is_public' => 'required',
            'adult' => 'required'
        ]);
        $movie->update($validated);
        return redirect()->route('admin.movies.index')->with('flash.banner', 'Movie updated!');
    }

    public function destroy(Movie $movie)
    {
        $movie->genres()->detach();
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('flash.banner', 'Movie deleted!')->with('flash.bannerStyle', 'danger');
    }
}
