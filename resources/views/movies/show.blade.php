@extends('layouts.app')

@section('title', $movie->title . ' - Netflixku')

@section('content')
{{-- Movie Hero --}}
<section class="relative min-h-[70vh] flex items-end">
    @if($movie->backdrop)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $movie->backdrop) }}')"></div>
    @elseif($movie->poster)
        <div class="absolute inset-0 bg-cover bg-center blur-xl opacity-30" style="background-image: url('{{ asset('storage/' . $movie->poster) }}')"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-netflix-darker via-netflix-darker/80 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 pb-12 w-full">
        <div class="flex flex-col md:flex-row gap-8 items-start fade-in">
            {{-- Poster --}}
            <div class="w-56 md:w-72 flex-shrink-0 rounded-xl overflow-hidden shadow-2xl shadow-black/50 -mt-20">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full aspect-[2/3] object-cover">
                @else
                    <div class="w-full aspect-[2/3] flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark rounded-xl">
                        <span class="text-6xl">🎬</span>
                    </div>
                @endif
            </div>

            {{-- Movie Info --}}
            <div class="flex-1 pt-4">
                @if($movie->category)
                    <a href="{{ route('movies.category', $movie->category->slug) }}" class="inline-flex items-center gap-1 bg-netflix-red/20 border border-netflix-red/30 text-netflix-red text-xs font-bold px-3 py-1 rounded-full mb-3 hover:bg-netflix-red/30 transition-colors">
                        {{ $movie->category->name }}
                    </a>
                @endif

                <h1 class="text-3xl md:text-5xl font-black text-white mb-4 leading-tight">{{ $movie->title }}</h1>

                {{-- Meta Info --}}
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-300 mb-6">
                    @if($movie->rating)
                        <span class="flex items-center gap-1 text-green-400 font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ $movie->rating }}/10
                        </span>
                    @endif
                    @if($movie->release_year)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $movie->release_year }}
                        </span>
                    @endif
                    @if($movie->duration)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $movie->duration }}
                        </span>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 mb-8">
                    @if($movie->video_url)
                    <a href="{{ route('movies.watch', $movie->slug) }}" class="btn-netflix inline-flex items-center gap-2 px-8 py-4 text-white font-bold rounded-lg text-base">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                        Play Movie
                    </a>
                    @endif
                    <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-2 px-6 py-4 bg-white/10 hover:bg-white/20 text-white font-medium rounded-lg text-sm backdrop-blur-sm transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back
                    </a>
                </div>

                {{-- Description --}}
                @if($movie->description)
                <div class="mb-8">
                    <h3 class="text-white font-bold mb-3 text-lg">Synopsis</h3>
                    <p class="text-gray-300 leading-relaxed max-w-3xl">{{ $movie->description }}</p>
                </div>
                @endif

                {{-- Details Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                    @if($movie->director)
                    <div class="bg-white/5 rounded-lg p-4 border border-white/5">
                        <span class="text-gray-500 text-xs uppercase tracking-wider font-medium">Director</span>
                        <p class="text-white font-semibold mt-1">{{ $movie->director }}</p>
                    </div>
                    @endif
                    @if($movie->cast)
                    <div class="bg-white/5 rounded-lg p-4 border border-white/5">
                        <span class="text-gray-500 text-xs uppercase tracking-wider font-medium">Cast</span>
                        <p class="text-white font-semibold mt-1">{{ $movie->cast }}</p>
                    </div>
                    @endif
                    @if($movie->category)
                    <div class="bg-white/5 rounded-lg p-4 border border-white/5">
                        <span class="text-gray-500 text-xs uppercase tracking-wider font-medium">Genre</span>
                        <p class="text-white font-semibold mt-1">{{ $movie->category->name }}</p>
                    </div>
                    @endif
                    @if($movie->release_year)
                    <div class="bg-white/5 rounded-lg p-4 border border-white/5">
                        <span class="text-gray-500 text-xs uppercase tracking-wider font-medium">Year</span>
                        <p class="text-white font-semibold mt-1">{{ $movie->release_year }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Movies --}}
@if($related->count())
<section class="max-w-7xl mx-auto px-4 mt-16 mb-12">
    <h2 class="text-xl font-bold text-white mb-6">More Like This</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($related as $relatedMovie)
        <a href="{{ route('movies.show', $relatedMovie->slug) }}" class="movie-card group rounded-lg overflow-hidden shadow-lg bg-netflix-gray">
            <div class="aspect-[2/3] relative overflow-hidden">
                @if($relatedMovie->poster)
                    <img src="{{ asset('storage/' . $relatedMovie->poster) }}" alt="{{ $relatedMovie->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-netflix-red/20 to-netflix-dark">
                        <span class="text-3xl">🎬</span>
                    </div>
                @endif
            </div>
            <div class="p-3">
                <h3 class="text-white font-semibold text-sm truncate">{{ $relatedMovie->title }}</h3>
                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                    @if($relatedMovie->rating)<span class="text-green-400">⭐ {{ $relatedMovie->rating }}</span>@endif
                    @if($relatedMovie->release_year)<span>{{ $relatedMovie->release_year }}</span>@endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif
@endsection
