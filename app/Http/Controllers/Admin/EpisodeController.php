<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EpisodeController extends Controller
{
    public function index(TvShow $tvShow, Season $season, Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $episodes = Episode::query()
            ->where('season_id', $season->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($t) use ($request) {
                    $t->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $episodes->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('TvShows/Seasons/Episodes/Index', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $episodes,
            'filters' => $filters
        ]);
    }

    public function store(TvShow $tvShow, Season $season, Request $request)
    {
        $episodes_numbers = $season->episodes()->get()->pluck('episode_number')->toArray();
        $data = [];
        $apiEpisode = Http::get(config('services.tmdb.endpoint') . 'tv/' . $tvShow->tmdb_id . '/season/' . $season->season_number . $request->episodeNumber . '?api_key=' . config('services.tmdb.secret') . '&language=en-US&append_to_response=episode_groups');
        if ($apiEpisode->successful()) {
            $newEpisode = $apiEpisode->json();
            if($newEpisode['episodes']) {
                foreach($newEpisode['episodes'] as $episode) {
                    if(in_array($episode['episode_number'],$episodes_numbers)) {
                        continue;
                    }
                    $data[] = [
                        'season_id' => $season->id,
                        'tmdb_id' => $episode['id'],
                        'name' => $episode['name'],
                        'slug' => Str::slug($episode['name']),
                        'episode_number' => $episode['episode_number'],
                        'overview' => $episode['overview'],
                        'is_public' => false,
                        'visits' => 1
                    ];
                }
            }
            if(count($data) > 0) {
                Episode::insert($data);
            }
            return redirect()->back()->with('flash.banner', 'Episodes created!');
        } else {
            return redirect()->back()->with('flash.banner', 'Api Error!');
        }
    }

    public function edit(TvShow $tvShow, Season $season, Episode $episode)
    {
        return Inertia::render('TvShows/Seasons/Episodes/Edit', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    public function update(TvShow $tvShow, Season $season, Episode $episode, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'overview' => 'required',
            'is_public' => 'required'
        ]);
        $episode->update($validated);
        return redirect()->route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Episode updated!');
    }

    public function destroy(TvShow $tvShow, Season $season, Episode $episode)
    {
        $episode->delete();
        return redirect()->route('admin.episodes.index', [$tvShow->id, $season->id])->with('flash.banner', 'Episode deleted!')->with('flash.bannerStyle', 'danger');
    }
}
