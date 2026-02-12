<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $showAdult = auth()->check() && auth()->user()->is_approved_adult;

        $featured = Movie::where('is_featured', true)
            ->when(!$showAdult, function($q) {
                return $q->whereHas('category', function($cq) { $cq->where('is_adult', false); });
            })
            ->latest()->first();

        $sliders = Movie::where('is_slider', true)
            ->when(!$showAdult, function($q) {
                return $q->whereHas('category', function($cq) { $cq->where('is_adult', false); });
            })
            ->latest()->get();

        $categories = Category::with(['movies' => function ($q) use ($showAdult) {
            $q->orderBy('release_year', 'desc')->take(12);
        }])
        ->when(!$showAdult, function($q) {
            return $q->where('is_adult', false);
        })
        ->get();

        $latestMovies = Movie::latest()
            ->when(!$showAdult, function($q) {
                return $q->whereHas('category', function($cq) { $cq->where('is_adult', false); });
            })
            ->take(12)->get();

        return view('home', compact('featured', 'sliders', 'categories', 'latestMovies'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $showAdult = auth()->check() && auth()->user()->is_approved_adult;

        $movies = Movie::where('title', 'LIKE', "%{$query}%")
            ->orWhere('director', 'LIKE', "%{$query}%")
            ->orWhere('cast', 'LIKE', "%{$query}%")
            ->when(!$showAdult, function($q) {
                return $q->whereHas('category', function($cq) { $cq->where('is_adult', false); });
            })
            ->with('category')
            ->latest()
            ->paginate(24);

        return view('search', compact('movies', 'query'));
    }
}
