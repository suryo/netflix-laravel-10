<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalCategories = Category::count();
        $featuredMovies = Movie::where('is_featured', true)->count();
        $latestMovies = Movie::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalMovies', 'totalCategories', 'featuredMovies', 'latestMovies'));
    }
}
