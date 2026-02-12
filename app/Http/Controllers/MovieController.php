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

        // Member approval guard
        if (auth()->check() && auth()->user()->role !== 'admin' && !auth()->user()->is_approved_member) {
            return redirect()->route('home')->with('error', 'Akun Anda sedang menunggu persetujuan member dari admin.');
        }

        // Adult content guard for direct access
        if ($movie->category->is_adult) {
            if (!auth()->check() || !auth()->user()->is_approved_adult) {
                return redirect()->route('home')->with('error', 'Konten ini memerlukan verifikasi KTP dan persetujuan admin.');
            }
        }

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
        
        // Member and Adult filtering
        $isApprovedAdult = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_approved_adult);
        $isApprovedMember = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_approved_member);

        if ($category->is_adult && !$isApprovedAdult) {
            abort(403, 'Unauthorized access to restricted category.');
        }

        if (!$isApprovedMember && auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Silakan tunggu persetujuan member untuk mengakses kategori ini.');
        }

        $movies = Movie::where('category_id', $category->id)
            ->with('category')
            ->latest()
            ->paginate(24);
        $categories = Category::withCount('movies')->get();
        return view('movies.index', compact('movies', 'categories', 'category'));
    }

    public function tvSeries()
    {
        $moviesQuery = Movie::where('type', 'tv_series')->with('category');

        // Member & Adult filtering for TV Series
        $isApprovedAdult = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_approved_adult);
        $isApprovedMember = auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_approved_member);

        if (!$isApprovedAdult) {
            $moviesQuery->whereHas('category', function($q) {
                $q->where('is_adult', false);
            });
        }
        
        if (!$isApprovedMember && auth()->check() && auth()->user()->role !== 'admin') {
            $moviesQuery->where('id', 0); // Hide everything if not approved member
        }

        $movies = $moviesQuery->latest()->paginate(24);
        $categories = Category::withCount('movies')->get();
        return view('movies.index', compact('movies', 'categories'));
    }

    public function adultIndex()
    {
        // Adult access guard
        if (!auth()->check() || (auth()->user()->role !== 'admin' && !auth()->user()->is_approved_adult)) {
            return redirect()->route('home')->with('error', 'Akses ke menu ini memerlukan verifikasi 21+.');
        }

        $isAdultSection = true;
        // Fetch only adult categories
        $categories = Category::where('is_adult', true)->withCount('movies')->get();
        
        // Fetch movies from adult categories
        $movies = Movie::whereHas('category', function($q) {
                $q->where('is_adult', true);
            })
            ->with('category')
            ->latest()
            ->paginate(24);

        return view('movies.index', compact('movies', 'categories', 'isAdultSection'));
    }
}
