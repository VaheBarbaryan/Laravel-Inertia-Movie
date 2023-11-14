<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $casts = TvShow::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $casts->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('TvShows/Index', [
            'tvShows' => $casts,
            'filters' => $filters
        ]);
    }

    public function store(Request $request)
    {
        $tvShow = TvShow::where('tmdb_id', $request->tvShowTMDBId)->first();
        if ($tvShow) {
            return redirect()->back()->with('flash.banner', 'TvShow Exists!');
        }
        $tmdb_tv_show= Http::get(config('services.tmdb.endpoint') . 'tv/' . $request->tvShowTMDBId . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_tv_show->successful()) {
            TvShow::create([
                'tmdb_id' => $tmdb_tv_show['id'],
                'name' => $tmdb_tv_show['name'],
                'created_year' => $tmdb_tv_show['first_air_date'],
                'adult' => $tmdb_tv_show['adult'],
                'episode_run_time' => $tmdb_tv_show['episode_run_time'] ? $tmdb_tv_show['episode_run_time'][0] : null,
                'number_of_episodes' => $tmdb_tv_show['number_of_episodes'],
                'number_of_seasons' => $tmdb_tv_show['number_of_seasons'],
                'rating' => $tmdb_tv_show['vote_average'],
                'rate_count' => $tmdb_tv_show['vote_count'],
                'poster_path' => $tmdb_tv_show['poster_path'],
            ]);
            return redirect()->back()->with('flash.banner', 'TvShow Generated!');
        } else {
            return redirect()->back()->with('flash.banner', 'Api Error!');
        }
    }

    public function edit(TvShow $tvShow)
    {
        return Inertia::render('TvShows/Edit', [
            'tvShow' => $tvShow
        ]);
    }

    public function update(TvShow $tvShow, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'poster_path' => 'required'
        ]);
        $tvShow->name = $request->name;
        $tvShow->rating = $request->rating;
        $tvShow->rate_count = $request->rate_count;
        $tvShow->adult = $request->adult;
        $tvShow->episode_run_time = $request->episode_run_time;
        $tvShow->number_of_episodes = $request->number_of_episodes;
        $tvShow->number_of_seasons = $request->number_of_seasons;
        $tvShow->poster_path = $request->poster_path;
        $tvShow->update();
        return redirect()->route('admin.tv-shows.index')->with('flash.banner', 'Tv Show updated!');
    }

    public function destroy(TvShow $tvShow)
    {
        $tvShow->delete();
        return redirect()->back()->with('flash.banner', 'Tv Show deleted!')->with('flash.bannerStyle', 'danger');
    }
}
