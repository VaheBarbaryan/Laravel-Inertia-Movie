<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Searchable\Searchable;

class SeasonController extends Controller
{
    public function index(TvShow $tvShow, Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $seasons = Season::query()
            ->where('tv_show_id', $tvShow->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($t) use ($request) {
                    $t->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('season_number', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $seasons->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('TvShows/Seasons/Index', [
            'tvShow' => $tvShow,
            'seasons' => $seasons,
            'filters' => $filters
        ]);
    }

    public function store(TvShow $tvShow, Request $request)
    {
        $seasons_numbers = $tvShow->seasons()->get()->pluck('season_number')->toArray();
        $data = [];
        $apiSeason = Http::get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '?api_key=' . config('services.tmdb.secret') . '&language=en-US&append_to_response=episode_groups');
        if ($apiSeason->successful()) {
            $newSeason = $apiSeason->json();
            if ($newSeason['seasons']) {
                foreach ($newSeason['seasons'] as $season) {
                    if (in_array($season['season_number'], $seasons_numbers)) {
                        continue;
                    }
                    $data[] = [
                        'tv_show_id' => $tvShow->id,
                        'tmdb_id' => $season['id'],
                        'name' => $season['name'],
                        'slug' => Str::slug($season['name']),
                        'season_number' => $season['season_number'],
                        'poster_path' => $season['poster_path'] ? $season['poster_path'] : $tvShow->poster_path
                    ];
                }
            }
            if (count($data) > 0) {
                Season::insert($data);
            }
            return redirect()->back()->with('flash.banner', 'Seasons created!');
        } else {
            return redirect()->back()->with('flash.banner', 'Api error!');
        }
    }

    public function edit(TvShow $tvShow, Season $season)
    {
        return Inertia::render('TvShows/Seasons/Edit', [
            'tvShow' => $tvShow,
            'season' => $season,
        ]);
    }

    public function update(TvShow $tvShow, Season $season, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'poster_path' => 'required'
        ]);
        $season->update($validated);
        return redirect()->route('admin.seasons.index', $tvShow->id)->with('flash.banner', 'Season updated!');
    }

    public function destroy(TvShow $tvShow, Season $season)
    {
        $season->delete();
        return redirect()->back()->with('flash.banner', 'Season deleted!')->with('flash.bannerStyle', 'danger');
    }
}
