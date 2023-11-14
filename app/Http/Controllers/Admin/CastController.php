<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CastController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 5;
        $casts = Cast::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $casts->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('Casts/Index', [
            'casts' => $casts,
            'filters' => $filters
        ]);
    }

    public function store(Request $request)
    {
        $cast = Cast::where('tmdb_id', $request->castTMDBId)->first();
        if ($cast) {
            return redirect()->back()->with('flash.banner', 'Cast Exists!');
        }
        $tmdb_cast = Http::get(config('services.tmdb.endpoint') . 'person/' . $request->castTMDBId . '?api_key=' . config('services.tmdb.secret') . '&language=en-US');
        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name' => $tmdb_cast['name'],
                'slug' => Str::slug($tmdb_cast['name']),
                'biography' => $tmdb_cast['biography'],
                'birthday' => $tmdb_cast['birthday'],
                'deathday' => $tmdb_cast['deathday'],
                'place_of_birth' => $tmdb_cast['place_of_birth'],
                'poster_path' => $tmdb_cast['profile_path']
            ]);
            return redirect()->back()->with('flash.banner', 'Cast Generated!');
        } else {
            return redirect()->back()->with('flash.banner', 'Api Error!');
        }
    }

    public function edit(Cast $cast)
    {
        return Inertia::render('Casts/Edit', [
            'cast' => $cast
        ]);
    }

    public function update(Cast $cast, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'poster_path' => 'required',
            'place_of_birth' => 'max:255',
            'biography' => 'max:1000'
        ]);
        $cast->update($validated);
        return redirect()->route('admin.casts.index')->with('flash.banner', "Cast edited!");
    }

    public function destroy(Cast $cast)
    {
        $cast->delete();
        return redirect()->back()
            ->with('flash.banner', "Cast deleted!")
            ->with('flash.bannerStyle', 'danger');;
    }
}

