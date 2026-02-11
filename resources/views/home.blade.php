@extends('layouts.app')

@section('title', 'Netflixku - Streaming Film Online')

@section('content')
{{-- Hero Section --}}
<section class="relative h-[85vh] flex items-end">
    @if($featured)
        @if($featured->backdrop)
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $featured->backdrop) }}')"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-netflix-red/20 via-netflix-dark to-netflix-darker"></div>
        @endif
        <div class="gradient-overlay absolute inset-0"></div>
        <div class="gradient-overlay-right absolute inset-0"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 pb-20 w-full fade-in">
            <span class="inline-flex items-center gap-2 bg-netflix-red/20 border border-netflix-red/30 text-netflix-red text-xs font-bold px-3 py-1 rounded-full mb-4">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Featured
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4 leading-tight max-w-2xl">{{ $featured->title }}</h1>
            <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                @if($featured->rating)<span class="text-green-400 font-bold">⭐ {{ $featured->rating }}</span>@endif
                @if($featured->release_year)<span>{{ $featured->release_year }}</span>@endif
                @if($featured->duration)<span>{{ $featured->duration }}</span>@endif
                @if($featured->category)<span class="bg-white/10 px-2 py-0.5 rounded text-xs">{{ $featured->category->name }}</span>@endif
            </div>
            <p class="text-gray-300 text-sm md:text-base max-w-xl mb-6 line-clamp-3">{{ $featured->description }}</p>
            <div class="flex items-center gap-3">
                <a href="{{ route('movies.watch', $featured->slug) }}" class="btn-netflix inline-flex items-center gap-2 px-6 py-3 text-white font-bold rounded-lg text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                    Play Now
                </a>
                <a href="{{ route('movies.show', $featured->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-bold rounded-lg text-sm backdrop-blur-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    More Info
                </a>
            </div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-netflix-red/10 via-netflix-dark to-netflix-darker"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 pb-20 w-full text-center fade-in">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4">Welcome to <span class="text-netflix-red">NETFLIXKU</span></h1>
            <p class="text-gray-400 text-lg mb-8">Discover and stream your favorite movies</p>
            <a href="{{ route('movies.index') }}" class="btn-netflix inline-flex items-center gap-2 px-8 py-4 text-white font-bold rounded-lg">
                Browse Movies
            </a>
        </div>
    @endif
</section>

{{-- Latest Movies Section --}}
@if($latestMovies->count())
<section class="max-w-7xl mx-auto px-4 -mt-10 relative z-20 mb-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-white">
            🔥 Trending Now
        </h2>
        <a href="{{ route('movies.index') }}" class="text-sm text-gray-400 hover:text-netflix-red transition-colors flex items-center gap-1">
            See All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-4">
        @foreach($latestMovies as $movie)
        <a href="{{ route('movies.show', $movie->slug) }}" class="movie-card flex-shrink-0 w-40 md:w-48 group relative rounded-lg overflow-hidden shadow-lg">
            <div class="aspect-[2/3] bg-netflix-gray">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark">
                        <span class="text-3xl">🎬</span>
                    </div>
                @endif
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                <h3 class="text-white font-semibold text-sm truncate">{{ $movie->title }}</h3>
                <div class="flex items-center gap-2 text-xs text-gray-300 mt-1">
                    @if($movie->rating)<span class="text-green-400">⭐ {{ $movie->rating }}</span>@endif
                    @if($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                </div>
                <span class="mt-2 inline-flex items-center gap-1 text-netflix-red text-xs font-bold">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                    Watch
                </span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Movies by Category --}}
@foreach($categories as $category)
    @if($category->movies->count())
    <section class="max-w-7xl mx-auto px-4 mb-12 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-white">{{ $category->name }}</h2>
            <a href="{{ route('movies.category', $category->slug) }}" class="text-sm text-gray-400 hover:text-netflix-red transition-colors flex items-center gap-1">
                See All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-4">
            @foreach($category->movies as $movie)
            <a href="{{ route('movies.show', $movie->slug) }}" class="movie-card flex-shrink-0 w-40 md:w-48 group relative rounded-lg overflow-hidden shadow-lg">
                <div class="aspect-[2/3] bg-netflix-gray">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark">
                            <span class="text-3xl">🎬</span>
                        </div>
                    @endif
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                    <h3 class="text-white font-semibold text-sm truncate">{{ $movie->title }}</h3>
                    <div class="flex items-center gap-2 text-xs text-gray-300 mt-1">
                        @if($movie->rating)<span class="text-green-400">⭐ {{ $movie->rating }}</span>@endif
                        @if($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
@endforeach
@endsection
