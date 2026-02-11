@extends('layouts.admin')

@section('title', 'Movies')
@section('page-title', 'Manage Movies')

@section('content')
<div class="bg-admin-card rounded-xl border border-admin-border">
    <div class="p-6 border-b border-admin-border flex items-center justify-between">
        <h3 class="text-white font-bold">All Movies <span class="text-gray-500 font-normal text-sm">({{ $movies->total() }})</span></h3>
        <a href="{{ route('admin.movies.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-admin-accent hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Movie
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-admin-border">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Movie</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Year</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Video</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border">
                @forelse($movies as $i => $movie)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $movies->firstItem() + $i }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-14 rounded bg-netflix-dark overflow-hidden flex-shrink-0">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-lg bg-netflix-dark">🎬</div>
                                @endif
                            </div>
                            <div>
                                <span class="text-white font-medium text-sm block">{{ $movie->title }}</span>
                                <span class="text-gray-500 text-xs">{{ $movie->duration ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-white/10 text-gray-300 px-2 py-1 rounded">{{ $movie->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($movie->rating)<span class="text-green-400">⭐ {{ $movie->rating }}</span>@else <span class="text-gray-600">-</span> @endif
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $movie->release_year ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($movie->video_url)
                            <span class="text-green-400 text-xs font-medium bg-green-500/10 px-2 py-1 rounded-full">✓ Has Video</span>
                        @else
                            <span class="text-gray-600 text-xs">No video</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($movie->is_featured)
                            <span class="text-amber-400 text-lg">★</span>
                        @else
                            <span class="text-gray-600">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('movies.show', $movie->slug) }}" target="_blank" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 rounded-lg transition-colors" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="p-2 bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Delete this movie?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">No movies yet. <a href="{{ route('admin.movies.create') }}" class="text-admin-accent hover:underline">Add one</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($movies->hasPages())
    <div class="p-6 border-t border-admin-border">
        {{ $movies->links() }}
    </div>
    @endif
</div>
@endsection
