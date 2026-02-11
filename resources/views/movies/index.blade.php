@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' Movies - Netflixku' : 'All Movies - Netflixku')

@section('content')
<div class="pt-24 pb-12 max-w-7xl mx-auto px-4">
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white">
                @if(isset($category))
                    <span class="text-netflix-red">{{ $category->name }}</span> Movies
                @else
                    All Movies
                @endif
            </h1>
            <p class="text-gray-500 mt-1">{{ $movies->total() }} movies available</p>
        </div>

        {{-- Category Filter --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('movies.index') }}"
               class="px-4 py-2 text-sm rounded-full font-medium transition-all {{ !isset($category) ? 'bg-netflix-red text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20 hover:text-white' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('movies.category', $cat->slug) }}"
                   class="px-4 py-2 text-sm rounded-full font-medium transition-all {{ isset($category) && $category->id == $cat->id ? 'bg-netflix-red text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20 hover:text-white' }}">
                    {{ $cat->name }} <span class="text-xs opacity-60">({{ $cat->movies_count }})</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Movie Grid --}}
    @if($movies->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 fade-in">
        @foreach($movies as $movie)
        <a href="{{ route('movies.show', $movie->slug) }}" class="movie-card group rounded-lg overflow-hidden shadow-lg bg-netflix-gray">
            <div class="aspect-[2/3] relative overflow-hidden">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark">
                        <div class="text-center">
                            <span class="text-4xl block mb-2">🎬</span>
                            <span class="text-xs text-gray-500">{{ $movie->title }}</span>
                        </div>
                    </div>
                @endif
                {{-- Hover Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 rounded-full bg-netflix-red flex items-center justify-center pulse-glow">
                            <svg class="w-4 h-4 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                        </span>
                        <span class="text-white text-xs font-bold">Watch Now</span>
                    </div>
                    @if($movie->category)
                        <span class="text-xs text-gray-400">{{ $movie->category->name }}</span>
                    @endif
                </div>
            </div>
            <div class="p-3">
                <h3 class="text-white font-semibold text-sm truncate group-hover:text-netflix-red transition-colors">{{ $movie->title }}</h3>
                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                    @if($movie->rating)<span class="text-green-400 font-medium">⭐ {{ $movie->rating }}</span>@endif
                    @if($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                    @if($movie->duration)<span>{{ $movie->duration }}</span>@endif
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10 flex justify-center">
        {{ $movies->links() }}
    </div>
    @else
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🎬</div>
        <h3 class="text-xl font-bold text-white mb-2">No movies found</h3>
        <p class="text-gray-500">Check back soon for new content!</p>
    </div>
    @endif
</div>
@endsection
