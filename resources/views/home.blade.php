@extends('layouts.app')

@section('title', 'Netflixku - Streaming Film Online')

@section('content')
{{-- Hero Section / Banner Slider --}}
<section class="relative h-[85vh] overflow-hidden" 
    x-data="{ 
        activeSlide: 0, 
        slides: {{ $sliders->count() > 0 ? $sliders->count() : ($featured ? 1 : 0) }},
        autoPlayInterval: null,
        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.slides;
            }, 6000);
        },
        stopAutoPlay() {
            clearInterval(this.autoPlayInterval);
        }
    }" 
    x-init="startAutoPlay()"
    @mouseenter="stopAutoPlay()"
    @mouseleave="startAutoPlay()">
    
    @php
        $sliderItems = $sliders->count() > 0 ? $sliders : ($featured ? collect([$featured]) : collect());
    @endphp

    @forelse($sliderItems as $index => $item)
        <div x-show="activeSlide === {{ $index }}" 
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform scale-105"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-1000"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 flex items-end">
            
            {{-- Background Image --}}
            @if($item->backdrop)
                <div class="absolute inset-0 bg-cover bg-top" style="background-image: url('{{ asset('storage/' . $item->backdrop) }}')"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-netflix-red/20 via-netflix-dark to-netflix-darker"></div>
            @endif
            
            <div class="gradient-overlay absolute inset-0"></div>
            <div class="gradient-overlay-right absolute inset-0"></div>

            {{-- Content --}}
            <div class="relative z-10 max-w-7xl mx-auto px-4 pb-20 w-full fade-in">
                @if($item->is_slider)
                <span class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-500/30 text-blue-400 text-xs font-bold px-3 py-1 rounded-full mb-4">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0l-1.18-4.455L6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/></svg>
                    Promotion
                </span>
                @else
                <span class="inline-flex items-center gap-2 bg-netflix-red/20 border border-netflix-red/30 text-netflix-red text-xs font-bold px-3 py-1 rounded-full mb-4">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Featured
                </span>
                @endif
                
                <h1 class="text-4xl md:text-6xl font-black text-white mb-4 leading-tight max-w-2xl">{{ $item->title }}</h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                    @if($item->rating)<span class="text-green-400 font-bold">⭐ {{ $item->rating }}</span>@endif
                    @if($item->release_year)<span>{{ $item->release_year }}</span>@endif
                    @if($item->quality)<span class="bg-white/10 px-2 py-0.5 rounded text-xs font-bold">{{ $item->quality }}</span>@endif
                </div>
                
                <p class="text-gray-300 text-sm md:text-base max-w-xl mb-6 line-clamp-3">{{ Str::limit(strip_tags($item->description), 200) }}</p>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('movies.show', $item->slug) }}" class="btn-netflix inline-flex items-center gap-2 px-6 py-3 text-white font-bold rounded-lg text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        Play Now
                    </a>
                    <a href="{{ route('movies.show', $item->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-bold rounded-lg text-sm backdrop-blur-sm transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        More Info
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="absolute inset-0 bg-gradient-to-br from-netflix-red/10 via-netflix-dark to-netflix-darker"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 pb-20 w-full text-center fade-in">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4">Welcome to <span class="text-netflix-red">NETFLIXKU</span></h1>
            <p class="text-gray-400 text-lg mb-8">Discover and stream your favorite movies</p>
            <a href="{{ route('movies.index') }}" class="btn-netflix inline-flex items-center gap-2 px-8 py-4 text-white font-bold rounded-lg">
                Browse Movies
            </a>
        </div>
    @endforelse

    {{-- Slider Controls --}}
    @if($sliderItems->count() > 1)
        {{-- Navigation Arrows --}}
        <button @click="activeSlide = (activeSlide - 1 + slides) % slides" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 p-2 rounded-full bg-black/30 text-white hover:bg-netflix-red transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="activeSlide = (activeSlide + 1) % slides" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 p-2 rounded-full bg-black/30 text-white hover:bg-netflix-red transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Indicators --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-2">
            @foreach($sliderItems as $index => $item)
                <button @click="activeSlide = {{ $index }}" 
                        :class="activeSlide === {{ $index }} ? 'w-8 bg-netflix-red' : 'w-2 bg-white/30'"
                        class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
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
