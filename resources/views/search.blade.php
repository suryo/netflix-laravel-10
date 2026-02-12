@extends('layouts.app')

@section('title', 'Search: ' . ($query ?? '') . ' - Netflixku')

@section('content')
<div class="pt-24 pb-12 max-w-7xl mx-auto px-4">
    {{-- Search Header --}}
    <div class="mb-10">
        <form action="{{ route('search') }}" method="GET" class="max-w-2xl">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search movies by title, director, cast..."
                    class="w-full bg-netflix-gray border border-white/10 rounded-xl py-4 pl-12 pr-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-netflix-red focus:border-transparent transition-all text-lg"
                    autofocus>
            </div>
        </form>
    </div>

    @if(isset($query) && $query)
        <h2 class="text-2xl font-bold text-white mb-6">
            Search results for "<span class="text-netflix-red">{{ $query }}</span>"
            <span class="text-gray-500 text-lg font-normal">({{ $movies->total() }} results)</span>
        </h2>

        @if($movies->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($movies as $movie)
                <a href="{{ route('movies.show', $movie->slug) }}" class="movie-card group rounded-lg overflow-hidden shadow-lg border border-white/5">
                    <div class="aspect-[2/3] bg-netflix-gray relative overflow-hidden">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark">
                                <span class="text-4xl">🎬</span>
                            </div>
                        @endif

                        {{-- Quality Badge --}}
                        @if($movie->quality)
                        <div class="absolute top-2 right-2 z-10">
                            <span class="bg-netflix-red text-[10px] font-black px-1.5 py-0.5 rounded shadow-lg">{{ $movie->quality }}</span>
                        </div>
                        @endif

                        {{-- Rating Badge --}}
                        @if($movie->rating)
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-black/80 backdrop-blur-sm text-amber-400 text-[10px] font-bold px-2 py-1 rounded-full border border-amber-400/30 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ $movie->rating }}
                            </span>
                        </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                            <span class="inline-flex items-center gap-1 text-netflix-red text-xs font-bold">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                Watch
                            </span>
                        </div>
                    </div>
                    <div class="p-3 bg-netflix-gray">
                        <h3 class="text-white font-semibold text-sm truncate">{{ $movie->title }}</h3>
                        <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                            @if($movie->rating)<span class="text-green-400">⭐ {{ $movie->rating }}</span>@endif
                            @if($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                            @if($movie->category)<span class="bg-white/10 px-1.5 py-0.5 rounded">{{ $movie->category->name }}</span>@endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $movies->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-white mb-2">No movies found</h3>
                <p class="text-gray-500">Try different keywords or browse our categories</p>
                <a href="{{ route('movies.index') }}" class="btn-netflix inline-flex items-center gap-2 px-6 py-3 text-white font-bold rounded-lg text-sm mt-6">
                    Browse Movies
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🎬</div>
            <h3 class="text-xl font-bold text-white mb-2">Start searching</h3>
            <p class="text-gray-500">Type a movie title, director, or actor name</p>
        </div>
    @endif
</div>
@endsection
