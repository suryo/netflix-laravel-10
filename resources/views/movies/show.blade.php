@extends('layouts.app')

@section('title', $movie->title . ' - Netflixku')

@push('styles')
<style>
    .content-wrapper {
        max-width: 1280px;
        margin: 0 auto;
    }
    .player-section {
        background: #000;
        padding: 20px 0;
    }
    .player-container {
        position: relative;
        width: 100%;
        aspect-ratio: 16/9;
        background: #000;
        box-shadow: 0 0 50px rgba(0,0,0,0.8);
        border-radius: 8px;
        overflow: hidden;
    }
    .player-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .meta-card {
        background: rgba(24, 24, 27, 0.5);
        border: 1px solid rgba(39, 39, 42, 1);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .meta-poster {
        width: 180px;
        flex-shrink: 0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }
    .rating-stars {
        color: #ffc107;
    }
    .quality-badge {
        background: #e50914;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 0.75rem;
    }
    .info-label {
        color: #888;
        font-size: 0.85rem;
        min-width: 100px;
        display: inline-block;
    }
    .info-value {
        color: #ccc;
        font-size: 0.85rem;
    }
    .gallery-item {
        aspect-ratio: 16/9;
        overflow: hidden;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .gallery-item:hover {
        transform: scale(1.05);
    }
    .comment-form input, .comment-form textarea {
        background: #111;
        border: 1px solid #333;
        color: #fff;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        width: 100%;
    }
    .comment-form input:focus, .comment-form textarea:focus {
        border-color: #e50914;
        outline: none;
    }
    .btn-submit {
        background: #e50914;
        color: white;
        padding: 0.5rem 2rem;
        border-radius: 4px;
        font-weight: bold;
        transition: background 0.2s;
    }
    .btn-submit:hover {
        background: #b20710;
    }
</style>
@endpush

@section('content')
<div class="pt-16 pb-12">
    <div class="content-wrapper px-4">
        
        {{-- Player Section --}}
        <section class="player-section">
            @if($movie->video_url)
                <div class="player-container">
                    <iframe 
                        src="{{ $movie->embed_url }}" 
                        allow="autoplay; encrypted-media; fullscreen" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            @else
                <div class="player-container flex items-center justify-center bg-zinc-900 border border-zinc-800">
                    <div class="text-center">
                        <div class="text-5xl mb-4">🎬</div>
                        <h3 class="text-xl font-bold text-white mb-2">Video Tidak Tersedia</h3>
                        <p class="text-gray-500">Sumber video belum ditambahkan untuk film ini.</p>
                    </div>
                </div>
            @endif
        </section>

        {{-- Main Metadata Section --}}
        <section class="meta-card">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Poster --}}
                <div class="meta-poster mx-auto md:mx-0">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full rounded shadow-xl">
                    @else
                        <div class="w-full aspect-[2/3] bg-zinc-800 rounded flex items-center justify-center text-3xl">🎬</div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                        <h1 class="text-3xl font-bold text-white">{{ $movie->title }}</h1>
                        <span class="quality-badge">HD</span>
                    </div>

                    <div class="flex items-center gap-4 mb-4 flex-wrap">
                        <div class="flex items-center gap-1 rating-stars">
                            @php $stars = floor(($movie->rating ?? 0) / 2); @endphp
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 {{ $i < $stars ? 'fill-current' : 'text-zinc-700' }}" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endfor
                            <span class="text-white font-bold ml-1">{{ $movie->rating ?? '0.0' }}</span>
                        </div>
                        <span class="text-zinc-500">|</span>
                        <span class="text-zinc-400 text-sm">{{ $movie->release_year }}</span>
                        <span class="text-zinc-500">|</span>
                        <span class="text-zinc-400 text-sm">{{ $movie->duration }}</span>
                    </div>

                    <div class="space-y-2 mb-6 text-sm">
                        <div><span class="info-label">Sutradara:</span> <span class="info-value">{{ $movie->director ?? '-' }}</span></div>
                        <div><span class="info-label">Pemain:</span> <span class="info-value">{{ $movie->cast ?? '-' }}</span></div>
                        <div><span class="info-label">Kategori:</span> <span class="info-value text-red-500">{{ $movie->category ? $movie->category->name : '-' }}</span></div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-white font-bold mb-2 uppercase text-xs tracking-widest border-l-4 border-red-600 pl-3">Sinopsis</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed">{{ $movie->description }}</p>
                    </div>

                    {{-- Gallery --}}
                    <div class="mt-8">
                        <div class="grid grid-cols-3 gap-4">
                            @if($movie->backdrop)
                                <div class="gallery-item"><img src="{{ asset('storage/' . $movie->backdrop) }}" class="w-full h-full object-cover"></div>
                                <div class="gallery-item bg-zinc-800 flex items-center justify-center text-zinc-600 text-xs">Shot #2</div>
                                <div class="gallery-item bg-zinc-800 flex items-center justify-center text-zinc-600 text-xs">Shot #3</div>
                            @else
                                <div class="gallery-item bg-zinc-800 flex items-center justify-center text-zinc-600 text-xs">Shot #1</div>
                                <div class="gallery-item bg-zinc-800 flex items-center justify-center text-zinc-600 text-xs">Shot #2</div>
                                <div class="gallery-item bg-zinc-800 flex items-center justify-center text-zinc-600 text-xs">Shot #3</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Comment Section --}}
        <section class="mt-12 bg-zinc-900/30 p-8 rounded-lg border border-zinc-800/50">
            <h2 class="text-xl font-bold text-white mb-8 flex items-center gap-2">
                <span class="w-1 h-6 bg-red-600"></span>
                DISKUSI / KOMENTAR
            </h2>

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/50 text-green-500 px-4 py-3 rounded mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('comments.store', $movie) }}" method="POST" class="comment-form mb-12">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <input type="text" name="name" placeholder="Nama Lengkap" required value="{{ old('name') }}">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email (Wajib)" required value="{{ old('email') }}">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <input type="text" name="whatsapp" placeholder="Nomor WhatsApp (Wajib)" required value="{{ old('whatsapp') }}">
                    @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-6">
                    <textarea name="content" rows="4" placeholder="Tulis komentar Anda..." required>{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-submit">KIRIM KOMENTAR</button>
                </div>
            </form>

            {{-- Display Comments --}}
            <div class="space-y-6">
                @forelse($movie->comments as $comment)
                    <div class="flex gap-4 p-4 rounded bg-zinc-800/20 border border-zinc-800 text-sm">
                        <div class="w-10 h-10 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-400 font-bold">
                            {{ substr($comment->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-white font-bold">{{ $comment->name }}</h4>
                                <span class="text-zinc-500 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-zinc-400 leading-relaxed">{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-zinc-600 text-center py-8">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </section>

        {{-- Similar Movies --}}
        @if($related->count())
        <section class="py-12">
            <h2 class="text-white font-bold mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-red-600"></span>
                SIMILAR
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($related as $rel)
                <a href="{{ route('movies.show', $rel->slug) }}" class="group block">
                    <div class="aspect-[2/3] rounded overflow-hidden relative mb-2 shadow-lg group-hover:ring-2 group-hover:ring-red-600 transition-all">
                        @if($rel->poster)
                            <img src="{{ asset('storage/' . $rel->poster) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-zinc-800 flex items-center justify-center text-2xl">🎬</div>
                        @endif
                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                            @if($rel->rating)
                                <div class="bg-black/80 text-[10px] text-white font-bold px-1 rounded flex items-center gap-0.5">
                                    ⭐ {{ $rel->rating }}
                                </div>
                            @endif
                            <div class="bg-red-600 text-[10px] text-white font-bold px-1 rounded">HD</div>
                        </div>
                    </div>
                    <h4 class="text-zinc-200 text-xs font-bold line-clamp-2 text-center group-hover:text-red-500 transition-colors uppercase">{{ $rel->title }}</h4>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection
