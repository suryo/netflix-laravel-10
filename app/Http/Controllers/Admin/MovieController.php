<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')->latest()->paginate(15);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.movies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:2048',
            'backdrop' => 'nullable|image|max:4096',
            'video_url' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'rating' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:2099',
            'duration' => 'nullable|string',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'quality' => 'nullable|string|max:10',
        ]);

        $data = $request->except(['poster', 'backdrop']);
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('movies/posters', 'public');
        }

        if ($request->hasFile('backdrop')) {
            $data['backdrop'] = $request->file('backdrop')->store('movies/backdrops', 'public');
        }

        Movie::create($data);
        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully!');
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        return view('admin.movies.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:2048',
            'backdrop' => 'nullable|image|max:4096',
            'video_url' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'rating' => 'nullable|string',
            'release_year' => 'nullable|integer|min:1900|max:2099',
            'duration' => 'nullable|string',
            'director' => 'nullable|string',
            'cast' => 'nullable|string',
            'quality' => 'nullable|string|max:10',
        ]);

        $data = $request->except(['poster', 'backdrop']);
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('poster')) {
            if ($movie->poster) Storage::disk('public')->delete($movie->poster);
            $data['poster'] = $request->file('poster')->store('movies/posters', 'public');
        }

        if ($request->hasFile('backdrop')) {
            if ($movie->backdrop) Storage::disk('public')->delete($movie->backdrop);
            $data['backdrop'] = $request->file('backdrop')->store('movies/backdrops', 'public');
        }

        $movie->update($data);
        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster) Storage::disk('public')->delete($movie->poster);
        if ($movie->backdrop) Storage::disk('public')->delete($movie->backdrop);
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
}
