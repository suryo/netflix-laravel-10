<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('category')->latest()->paginate(24);
        $categories = Category::withCount('movies')->get();
        return view('movies.index', compact('movies', 'categories'));
    }

    public function show($slug)
    {
        $movie = Movie::where('slug', $slug)->with(['category', 'comments'])->firstOrFail();

        // Increment views (session-based to avoid spamming)
        $viewedKey = 'viewed_movie_' . $movie->id;
        if (!session()->has($viewedKey)) {
            $movie->increment('views');
            session()->put($viewedKey, true);
        }

        $related = Movie::where('category_id', $movie->category_id)
            ->where('id', '!=', $movie->id)
            ->latest()
            ->take(6)
            ->get();
        return view('movies.show', compact('movie', 'related'));
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $movies = Movie::where('category_id', $category->id)
            ->with('category')
            ->latest()
            ->paginate(24);
        $categories = Category::withCount('movies')->get();
        return view('movies.index', compact('movies', 'categories', 'category'));
    }
}
