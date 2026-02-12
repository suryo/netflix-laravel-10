@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-admin-card rounded-xl p-6 border border-admin-border hover:border-admin-accent/30 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Movies</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalMovies }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
            </div>
        </div>
        <a href="{{ route('admin.movies.index') }}" class="text-xs text-admin-accent hover:underline mt-3 inline-block">View all →</a>
    </div>
    <div class="bg-admin-card rounded-xl p-6 border border-admin-border hover:border-emerald-500/30 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Views</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ number_format($totalViews) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>
        <p class="text-xs text-emerald-500 mt-3 inline-block">Interaksi pengguna</p>
    </div>
    <div class="bg-admin-card rounded-xl p-6 border border-admin-border hover:border-purple-500/30 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Comments</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalComments }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
        <a href="{{ route('admin.comments.index') }}" class="text-xs text-purple-500 hover:underline mt-3 inline-block">Manage →</a>
    </div>
    <div class="bg-admin-card rounded-xl p-6 border border-admin-border hover:border-amber-500/30 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Featured</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ $featuredMovies }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-3">Active highlights</p>
    </div>
</div>

{{-- Latest Movies Table --}}
<div class="bg-admin-card rounded-xl border border-admin-border">
    <div class="p-6 border-b border-admin-border flex items-center justify-between">
        <h3 class="text-white font-bold">Latest Movies</h3>
        <a href="{{ route('admin.movies.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-admin-accent hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Movie
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-admin-border">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Movie</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Year</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Slider</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Featured</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border">
                @foreach($latestMovies as $movie)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-14 rounded bg-netflix-dark overflow-hidden flex-shrink-0">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-lg">🎬</div>
                                @endif
                            </div>
                            <span class="text-white font-medium text-sm">{{ $movie->title }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-white/10 text-gray-300 px-2 py-1 rounded">{{ $movie->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $movie->rating ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $movie->release_year ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($movie->is_slider)
                            <span class="text-blue-400 text-xs font-bold px-2 py-0.5 bg-blue-500/10 rounded-full italic">BANNER</span>
                        @else
                            <span class="text-gray-500 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($movie->is_featured)
                            <span class="text-amber-400">★</span>
                        @else
                            <span class="text-gray-600">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
