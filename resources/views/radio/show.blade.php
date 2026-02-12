@extends('layouts.app')

@section('title', $station->name . ' - Radio Online')

@push('styles')
<style>
    .radio-container {
        background: linear-gradient(135deg, rgba(20, 184, 166, 0.05) 0%, rgba(5, 5, 5, 1) 100%);
    }
    .player-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .visualizer-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 4px;
        height: 100px;
    }
    .bar {
        width: 8px;
        background: #14b8a6;
        border-radius: 4px;
        transition: height 0.2s ease;
    }
    .playing .bar {
        animation: dance 1s ease-in-out infinite alternate;
    }
    @keyframes dance {
        0% { height: 10px; }
        100% { height: 80px; }
    }
    /* Stagger the animation */
    .bar:nth-child(2) { animation-delay: 0.1s; }
    .bar:nth-child(3) { animation-delay: 0.2s; }
    .bar:nth-child(4) { animation-delay: 0.3s; }
    .bar:nth-child(5) { animation-delay: 0.4s; }
    .bar:nth-child(6) { animation-delay: 0.5s; }
    .bar:nth-child(7) { animation-delay: 0.6s; }
    .bar:nth-child(8) { animation-delay: 0.7s; }

    .glow-teal {
        box-shadow: 0 0 30px rgba(20, 184, 166, 0.2);
    }
</style>
@endpush

@section('content')
<div class="pt-32 pb-20 px-4 md:px-12 min-h-screen radio-container">
    <div class="max-w-6xl mx-auto">
        {{-- Back Button --}}
        <a href="{{ route('radio.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-all mb-10 group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span class="text-xs font-black uppercase tracking-[0.2em]">Kembali ke City Hub</span>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            {{-- Main Player --}}
            <div class="lg:col-span-8">
                <div class="player-card rounded-[40px] p-8 md:p-12 relative overflow-hidden">
                    {{-- Station Info --}}
                    <div class="flex flex-col md:flex-row items-center gap-10 relative z-10">
                        <div class="w-48 h-48 md:w-64 md:h-64 bg-black rounded-3xl p-8 flex items-center justify-center border border-white/10 glow-teal shadow-2xl overflow-hidden group">
                            @if($station->logo)
                                <img src="{{ $station->logo }}" alt="{{ $station->name }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-700">
                            @else
                                <span class="text-8xl">📻</span>
                            @endif
                        </div>

                        <div class="text-center md:text-left flex-1">
                            <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                                <span class="px-4 py-1.5 bg-teal-500/10 text-teal-500 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-teal-500/20">Now Streaming</span>
                                <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">{{ $station->city }}</span>
                            </div>
                            <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter leading-none italic uppercase">
                                {{ $station->name }}
                            </h1>
                            <p class="text-gray-400 text-sm md:text-md mb-8 leading-relaxed max-w-lg">
                                Mendengarkan siaran langsung dari {{ $station->city }}. Nikmati musik dan program terbaik dari stasiun radio pilihan Anda.
                            </p>

                            {{-- Visualizer --}}
                            <div id="visualizer" class="visualizer-container mb-8 hidden">
                                <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                                <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
                            </div>

                            {{-- Radio Error Fallback --}}
                            <div id="radio-error" class="hidden my-8 p-6 bg-red-500/10 border border-red-500/20 rounded-3xl text-center animate-fadeIn">
                                <div class="flex items-center justify-center gap-3 mb-4">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <h3 class="text-white font-black uppercase text-sm italic tracking-widest">Gagal Memuat Siaran</h3>
                                </div>
                                <p class="text-gray-400 text-xs mb-6">Siaran radio ini sedang dibatasi atau tidak tersedia di browser.</p>
                                <div class="flex flex-wrap justify-center gap-3">
                                    <button onclick="reloadPlayer()" class="px-6 py-2 bg-white/10 hover:bg-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Coba Lagi
                                    </button>
                                    <a href="{{ route('radio.index') }}" class="px-6 py-2 bg-teal-500 hover:bg-teal-600 text-black text-[10px] font-black uppercase tracking-widest rounded-full transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                        Pilih Radio Lain
                                    </a>
                                </div>
                                <a href="{{ $station->stream_url }}" target="_blank" class="block mt-4 text-[10px] text-gray-500 hover:text-white transition-colors underline uppercase tracking-[0.2em]">Buka Link Langsung &rarr;</a>
                            </div>

                            {{-- Audio Player Controls --}}
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-6">
                                <button id="playPauseBtn" onclick="togglePlay()" class="w-20 h-20 bg-teal-500 hover:bg-teal-600 text-black rounded-full flex items-center justify-center transition-all shadow-xl active:scale-95">
                                    <svg id="playIcon" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <svg id="pauseIcon" class="w-8 h-8 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                </button>
                                
                                <div class="flex flex-col gap-2">
                                    <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="0.7" oninput="changeVolume(this.value)" class="w-32 h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-teal-500">
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest text-center md:text-left">Volume Control</span>
                                </div>

                                <button onclick="copyToClipboard()" class="p-4 bg-white/5 hover:bg-white/10 text-white rounded-full transition-all flex items-center gap-2 border border-white/5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest px-2">Bagikan</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Audio Element --}}
                    <audio id="radioPlayer" preload="none">
                        <source src="{{ $station->stream_url }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>

                    {{-- Background Glow --}}
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/10 rounded-full blur-[100px]"></div>
                </div>

                {{-- Tags & Metadata --}}
                <div class="mt-12 flex flex-wrap gap-3">
                    @foreach(explode(',', $station->tags) as $tag)
                        <span class="px-5 py-2 bg-white/3 border border-white/5 rounded-full text-xs font-bold text-gray-400 uppercase tracking-widest hover:border-teal-500/30 hover:text-white transition-all">
                            #{{ trim($tag) }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar: Other Stations --}}
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-8">
                    <span class="w-6 h-1 bg-teal-500 rounded-full"></span>
                    <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">Lainnya di {{ $station->city }}</h2>
                </div>

                <div class="space-y-4">
                    @foreach($otherStations as $other)
                        <a href="{{ route('radio.show', $other->slug) }}" class="flex items-center gap-5 p-5 rounded-2xl bg-white/3 border border-white/5 hover:bg-white/8 hover:border-teal-500/50 transition-all group overflow-hidden relative">
                            <div class="w-16 h-16 bg-black rounded-xl p-3 flex items-center justify-center border border-white/10 group-hover:border-teal-500/30 flex-shrink-0 relative z-10">
                                @if($other->logo)
                                    <img src="{{ $other->logo }}" alt="{{ $other->name }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-2xl">📻</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 relative z-10">
                                <h4 class="text-white font-black text-sm truncate group-hover:text-teal-500 transition-colors uppercase italic tracking-tighter">{{ $other->name }}</h4>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">{{ explode(',', $other->tags)[0] }}</p>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-r from-teal-500/5 to-transparent translate-x-[-100%] group-hover:translate-x-0 transition-transform duration-500"></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const player = document.getElementById('radioPlayer');
    const playBtn = document.getElementById('playPauseBtn');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    const visualizer = document.getElementById('visualizer');
    const volumeSlider = document.getElementById('volumeSlider');
    const errorOverlay = document.getElementById('radio-error');
    
    let playInitiated = false;
    let watchdogTimer = null;

    function showFallback() {
        if (!playInitiated) {
            console.log('Radio playback failed to start.');
            errorOverlay.classList.remove('hidden');
            visualizer.classList.add('hidden');
            // Stop trying to play
            player.pause();
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        }
    }

    function togglePlay() {
        if (player.paused) {
            // Clear any old timer
            if (watchdogTimer) clearTimeout(watchdogTimer);
            
            // Start watchdog (8 seconds)
            watchdogTimer = setTimeout(showFallback, 8000);
            errorOverlay.classList.add('hidden');

            player.play().then(() => {
                // Play started successfully
            }).catch(error => {
                console.error('Play error:', error);
                showFallback();
            });

            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        } else {
            player.pause();
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
            visualizer.classList.remove('playing');
            if (watchdogTimer) clearTimeout(watchdogTimer);
        }
    }

    player.onplaying = function() {
        console.log('Radio is playing.');
        playInitiated = true;
        if (watchdogTimer) clearTimeout(watchdogTimer);
        errorOverlay.classList.add('hidden');
        visualizer.classList.remove('hidden');
        visualizer.classList.add('playing');
    };

    player.onerror = function() {
        console.error('Radio element error.');
        showFallback();
    };

    function changeVolume(val) {
        player.volume = val;
    }

    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link Radio berhasil disalin!');
        });
    }

    function reloadPlayer() {
        window.location.reload();
    }
</script>
@endpush
@endsection
