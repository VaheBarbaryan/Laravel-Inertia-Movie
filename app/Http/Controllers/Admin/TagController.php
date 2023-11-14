<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 5;
        $tags = Tag::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('tag_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $request->search . '%');
            })
            ->orderByDesc('id')
            ->paginate($perPage);
        $tags->appends($request->query());
        $filters = $request->only(['search', 'perPage']);
        return Inertia::render('Tags/Index', [
            'tags' => $tags,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render('Tags/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tagName' => 'required|unique:tags,tag_name'
        ]);
        Tag::create([
            'tag_name' => $request->tagName,
            'slug' => Str::slug($request->tagName),
        ]);
        return redirect()->route('admin.tags.index')->with('flash.banner', 'Tag Created!');
    }

    public function edit(Tag $tag)
    {
        return Inertia::render('Tags/Edit', [
            'tag' => $tag
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tagName' => 'required|unique:tags,tag_name,' . $tag->id
        ]);
        $tag->tag_name = $request->tagName;
        $tag->slug = Str::slug($request->tagName);
        $tag->update();
        return redirect()->route('admin.tags.index')->with('flash.banner', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')
            ->with('flash.banner', 'Tag deleted successfully!')
            ->with('flash.bannerStyle', 'danger');
    }
}
