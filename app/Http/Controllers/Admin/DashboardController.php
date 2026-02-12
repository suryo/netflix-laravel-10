<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Comment;


class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalCategories = Category::count();
        $featuredMovies = Movie::where('is_featured', true)->count();
        $totalComments = Comment::count();
        $totalViews = Movie::sum('views');
        $latestMovies = Movie::with('category')->latest()->take(5)->get();
        $pendingApprovals = \App\Models\User::whereNotNull('ktp_number')->where('is_approved_adult', false)->count();

        return view('admin.dashboard', compact('totalMovies', 'totalCategories', 'featuredMovies', 'totalComments', 'totalViews', 'latestMovies', 'pendingApprovals'));
    }

    public function approvals()
    {
        $users = \App\Models\User::whereNotNull('ktp_number')
            ->where('role', 'member')
            ->orderBy('is_approved_adult', 'asc')
            ->latest()
            ->paginate(20);
            
        return view('admin.users.approvals', compact('users'));
    }

    public function approveAdult(\App\Models\User $user)
    {
        $user->update(['is_approved_adult' => true]);
        return back()->with('success', "User {$user->name} has been approved for adult content.");
    }
}
