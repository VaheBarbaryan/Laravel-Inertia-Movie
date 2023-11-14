<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cast;
use App\Models\Download;
use App\Models\Movie;
use App\Models\Tag;
use App\Models\TrailerUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MovieAttachController extends Controller
{
    public function index(Movie $movie)
    {
        $tags = Tag::all('id', 'tag_name');
        $casts = Cast::all('id', 'name');
        $casts_arr = [];
        foreach ($casts as $cast) {
            $casts_arr[$cast->id] = $cast->name;
        }
        $tags_arr = [];
        foreach ($tags as $tag) {
            $tags_arr[$tag->id] = $tag->tag_name;
        }
        $movie_casts = $movie->casts;
        $movie_casts = collect($movie_casts)->pluck('id');
        $movie_tags = $movie->tags;
        $movie_tags = collect($movie_tags)->pluck('id');
        return Inertia::render('Movies/Attach', [
            'movie' => $movie,
            'trailers' => $movie->trailers,
            'downloads' => $movie->downloads,
            'tags' => $tags_arr,
            'casts' => $casts_arr,
            'movie_casts' => $movie_casts,
            'movie_tags' => $movie_tags
        ]);
    }

    public function addTrailer(Movie $movie, Request $request)
    {
        $movie->trailers()->create($request->validate([
            'name' => 'required',
            'embed_html' => 'required'
        ]));
        return redirect()->back()->with('flash.banner', 'Trailer added!');
    }

    public function addDownload(Movie $movie, Request $request) {
        $movie->downloads()->create($request->validate([
            'name' => 'required',
            'web_url' => 'required'
        ]));
        return redirect()->back()->with('flash.banner', 'Download added!');
    }

    public function deleteTrailer(TrailerUrl $trailerUrl)
    {
        $trailerUrl->delete();
        return redirect()->back()->with('flash.banner', 'Trailed deleted!');
    }


    public function deleteDownload(Download $download)
    {
        $download->delete();
        return redirect()->back()->with('flash.banner', 'Download deleted!');
    }

    public function addCast(Request $request, Movie $movie)
    {
        $casts = $request->casts;
        $movie->casts()->sync($casts);
        return redirect()->route('admin.movies.attach', $movie->id)->with('flash.banner', 'Casts added!');
    }

    public function addTag(Request $request, Movie $movie)
    {
        $tags = $request->tags;
        $movie->tags()->sync($tags);
        return redirect()->route('admin.movies.attach', $movie->id)->with('flash.banner', 'Tags added!');
    }
}
