<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $movies = Movie::select('id', 'title', 'slug', DB::raw("'Movie' as type"))
            ->where('title', 'like', '%' . $request->search . '%');

        $tvShows = TvShow::select('id', 'name', 'slug', DB::raw("'Tv Show' as type"))
            ->where('name', 'like', '%' . $request->search . '%');

        $cast = Cast::select('id', 'name', 'slug', DB::raw("'Cast' as type"))
            ->where('name', 'like', '%' . $request->search . '%');

        $results = $movies
            ->union($tvShows)
            ->union($cast)
            ->orderByRaw("CASE WHEN title LIKE ? THEN 0 ELSE 1 END", [$request->search . '%'])
            ->get();
        $results = $results->map(function ($item) {
            switch ($item->type) {
                case 'Movie':
                    $item->url = route('movies.show', $item->slug);
                    break;
                case 'Tv Show':
                    $item->url = route('tv-shows.show', $item->slug);
                    break;
                case 'Episode':
                    $item->url = route('episodes.show', $item->slug);
                    break;
                case 'Cast':
                    $item->url = route('casts.show', $item->slug);
                    break;
                default:
                    $item->url = '';
                    break;
            }
            return $item;
        });

        return response()->json($results);
    }
}
