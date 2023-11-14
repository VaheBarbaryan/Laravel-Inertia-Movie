<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $casts = Genre::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $casts->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('Genres/Index', [
            'genres' => $casts,
            'filters' => $filters
        ]);
    }

    public function store()
    {
        $tmdb_genres = Http::get(config('services.tmdb.endpoint') . 'genre/movie/list?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_genres->successful()) {
            $tmdb_genres_json = $tmdb_genres->json();
            foreach ($tmdb_genres_json as $single_tmdb_genre) {
                foreach ($single_tmdb_genre as $tgenre) {
                    $genre = Genre::where('tmdb_id', $tgenre['id'])->first();
                    if (!$genre) {
                        Genre::create([
                            'tmdb_id' => $tgenre['id'],
                            'title' => $tgenre['name'],
                        ]);
                    }
                }
            }
            return redirect()->back()->with('flash.banner', 'Genres generated!');
        }
        return redirect()->back()->with('flash.banner', 'Api error!');
    }

    public function edit(Genre $genre)
    {
        return Inertia::render("Genres/Edit", [
            'genre' => $genre
        ]);
    }

    public function update(Genre $genre, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255'
        ]);
        $genre->update($validated);
        return redirect()->route('admin.genres.index')->with('flash.banner', 'Genre updated!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->back()->with('flash.banner', 'Genre deleted!')->with('flash.bannerStyle', 'danger');
    }
}
