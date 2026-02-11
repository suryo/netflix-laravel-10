<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Movie::where('is_featured', true)->latest()->first();
        $categories = Category::with(['movies' => function ($q) {
            $q->latest()->take(12);
        }])->get();
        $latestMovies = Movie::latest()->take(12)->get();

        return view('home', compact('featured', 'categories', 'latestMovies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $movies = Movie::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('director', 'like', "%{$query}%")
            ->orWhere('cast', 'like', "%{$query}%")
            ->with('category')
            ->paginate(20);

        return view('search', compact('movies', 'query'));
    }
}
