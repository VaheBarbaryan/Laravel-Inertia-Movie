<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index()
    {
        $tvShows = TvShow::orderByDesc('created_at')->paginate(12);
        return Inertia::render('Frontend/TvShows/Index', [
            'tvShows' => $tvShows
        ]);
    }

    public function show(TvShow $tvShow)
    {
        if(auth()->user()) {
            $user = User::find(auth()->user()->id);
            $watchlist = $user->tvShows()->where('watchable_type', TvShow::class)
                ->where('watchable_id', $tvShow->id)
                ->exists();
        } else {
            $watchlist = false;
        }

        $latests = Movie::orderByDesc('created_at')->take(9)->get();
        return Inertia::render('Frontend/TvShows/Show', [
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons()->get(),
            'latests' => $latests,
            'is_added_to_watchlist' => $watchlist
        ]);
    }

    public function seasonShow(TvShow $tvShow, Season $season)
    {
        $latests = Movie::orderByDesc('created_at')->take(9)->get();
        return Inertia::render('Frontend/TvShows/Seasons/Show', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $season->episodes()->get(),
            'latests' => $latests
        ]);
    }

    public function showEpisode(Episode $episode)
    {
        $latests = Episode::where('id', "!=", $episode->id)->latest()->take(12)->get();
        return Inertia::render('Frontend/TvShows/Seasons/Episodes/Show', [
            'episode' => $episode,
            'season' => $episode->season,
            'latests' => $latests
        ]);
    }

    public function watchlist(TvShow $tvShow)
    {
        $watchlistTvShow = Watchlist::where(['user_id' => auth()->user()->id, 'watchable_id' => $tvShow->id, 'watchable_type' => TvShow::class])->first();
        if ($watchlistTvShow) {
            $watchlistTvShow->delete();
        } else {
            $user = User::find(auth()->user()->id);
            $watchlistTvShow = new Watchlist();
            $watchlistTvShow->user_id = $user->id;
            $watchlistTvShow->watchable_id = $tvShow->id;
            $watchlistTvShow->watchable_type = TvShow::class;
            $watchlistTvShow->save();
        }
        return redirect()->back();
    }

}
