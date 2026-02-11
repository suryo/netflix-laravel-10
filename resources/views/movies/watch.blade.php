@extends('layouts.app')

@section('title', 'Watch: ' . $movie->title . ' - Netflixku')

@push('styles')
<style>
    .player-container {
        position: relative;
        width: 100%;
        max-width: 100%;
        aspect-ratio: 16/9;
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
    }
    .player-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .cinema-mode {
        background: #000;
    }
    .cinema-mode .glass-nav {
        opacity: 0;
        transition: opacity 0.3s;
    }
    .cinema-mode .glass-nav:hover {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="pt-20 pb-12 min-h-screen bg-black">
    {{-- Top Bar --}}
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('movies.show', $movie->slug) }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Details
            </a>
        </div>
        <div class="flex items-center gap-3">
            <h2 class="text-white font-bold text-lg hidden md:block">{{ $movie->title }}</h2>
            @if($movie->release_year)
                <span class="text-gray-500 text-sm hidden md:block">({{ $movie->release_year }})</span>
            @endif
        </div>
        <div>
            <button onclick="toggleCinema()" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 text-sm bg-white/10 hover:bg-white/20 px-3 py-2 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                Cinema Mode
            </button>
        </div>
    </div>

    {{-- Video Player --}}
    <div class="max-w-7xl mx-auto px-4">
        @if($movie->video_url)
            <div class="player-container mb-8">
                <iframe 
                    src="{{ $movie->embed_url }}" 
                    allow="autoplay; encrypted-media; fullscreen" 
                    allowfullscreen
                    loading="lazy">
                </iframe>
            </div>
        @else
            <div class="player-container flex items-center justify-center mb-8">
                <div class="text-center">
                    <div class="text-6xl mb-4">📽️</div>
                    <h3 class="text-xl font-bold text-white mb-2">No Video Available</h3>
                    <p class="text-gray-500">Video source has not been added yet.</p>
                </div>
            </div>
        @endif

        {{-- Movie Info Below Player --}}
        <div class="bg-netflix-gray/50 rounded-xl p-6 border border-white/5">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $movie->title }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400">
                        @if($movie->rating)<span class="text-green-400 font-bold">⭐ {{ $movie->rating }}</span>@endif
                        @if($movie->release_year)<span>{{ $movie->release_year }}</span>@endif
                        @if($movie->duration)<span>{{ $movie->duration }}</span>@endif
                        @if($movie->category)
                            <a href="{{ route('movies.category', $movie->category->slug) }}" class="bg-white/10 px-2 py-0.5 rounded text-xs hover:bg-netflix-red/20 hover:text-netflix-red transition-colors">{{ $movie->category->name }}</a>
                        @endif
                    </div>
                </div>
                @if($movie->director)
                <div class="text-sm text-gray-400">
                    <span class="text-gray-600">Director:</span> <span class="text-white">{{ $movie->director }}</span>
                </div>
                @endif
            </div>
            @if($movie->description)
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $movie->description }}</p>
            @endif
            @if($movie->cast)
                <p class="text-sm text-gray-500 mt-3"><span class="text-gray-600">Cast:</span> {{ $movie->cast }}</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleCinema() {
        document.body.classList.toggle('cinema-mode');
    }
</script>
@endpush
