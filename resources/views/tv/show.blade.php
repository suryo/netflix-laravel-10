@extends('layouts.app')

@section('title', 'Nonton ' . $channel->name . ' - TV Online')

@push('styles')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<style>
    .video-js {
        width: 100%;
        height: 100%;
    }
    .vjs-big-play-button {
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        background-color: rgba(229, 9, 20, 0.8) !important;
        border-color: #e50914 !important;
        border-radius: 50% !important;
        width: 3em !important;
        height: 3em !important;
        line-height: 2.8em !important;
    }
    .player-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
        overflow: hidden;
    }
    .player-container iframe, 
    .player-container video,
    .player-container .video-js {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(229, 9, 20, 0.3); border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="pt-20 lg:pt-24 min-h-screen bg-netflix-darker">
    <div class="container mx-auto px-4 lg:px-12 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Main Player Section --}}
            <div class="lg:col-span-3">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/5 bg-black">
                    <div class="player-container">
                        @php
                            $isYoutube = Str::contains($channel->stream_url, ['youtube.com', 'youtu.be']);
                            $isIframe = Str::contains($channel->stream_url, '<iframe');
                            $isHls = Str::endsWith($channel->stream_url, '.m3u8') || Str::contains($channel->stream_url, '.m3u8?');
                            
                            $youtubeId = '';
                            if ($isYoutube && !$isIframe) {
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $channel->stream_url, $match)) {
                                    $youtubeId = $match[1];
                                }
                            }
                        @endphp

                        @if($isIframe)
                            {!! $channel->stream_url !!}
                        @elseif($youtubeId)
                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif($isHls)
                            <video id="hls-player" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" crossorigin="anonymous">
                                <source src="{{ $channel->stream_url }}" type="application/x-mpegURL">
                            </video>
                        @else
                            <iframe id="generic-iframe" src="{{ $channel->stream_url }}" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                        @endif

                        {{-- CORS/Error Fallback Overlay --}}
                        <div id="player-error" class="hidden absolute inset-0 z-50 bg-black/90 flex flex-col items-center justify-center p-8 text-center animate-fadeIn">
                            <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mb-6 border border-red-500/20">
                                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <h3 class="text-xl font-black text-white mb-3 uppercase italic">Siaran Tidak Dapat Dimuat</h3>
                            <p class="text-gray-400 text-sm max-w-md mb-8 leading-relaxed">Penyiar membatasi pemutaran langsung di browser (CORS Restriction). Untuk tetap menonton, silakan gunakan pemutar eksternal.</p>
                            
                            <div class="flex flex-wrap justify-center gap-4">
                                <a href="{{ $channel->stream_url }}" target="_blank" class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition-all shadow-lg active:scale-95 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Buka Link Langsung
                                </a>
                                <button onclick="reloadPlayer()" class="px-8 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full transition-all flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Coba Lagi
                                </button>
                                <button onclick="copyStreamUrl()" class="px-8 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full transition-all flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    Salin URL Stream
                                </button>
                            </div>
                            
                            <p class="mt-8 text-[10px] text-gray-600 uppercase tracking-widest font-bold">Tips: Gunakan aplikasi VLC atau MX Player di HP Anda</p>
                        </div>
                    </div>
                </div>

                {{-- Channel Info Section --}}
                <div class="mt-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/5 p-6 rounded-2xl border border-white/5">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-[#1a1a1a] p-4 rounded-xl flex items-center justify-center border border-white/10 flex-shrink-0 shadow-lg relative group">
                            @if($channel->logo)
                                <img src="{{ Str::startsWith($channel->logo, 'http') ? $channel->logo : asset('storage/' . $channel->logo) }}" alt="{{ $channel->name }}" class="max-w-full max-h-full object-contain">
                            @else
                                <div class="text-3xl">📺</div>
                            @endif
                            <div class="absolute inset-0 bg-red-500/10 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl"></div>
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="flex h-2.5 w-2.5 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                </span>
                                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight leading-none">{{ $channel->name }}</h1>
                            </div>
                            <div class="flex items-center gap-2 mt-3">
                                <span class="px-2.5 py-1 bg-red-500/10 text-red-500 text-[10px] font-black rounded uppercase border border-red-500/20 tracking-wider">{{ $channel->category ?? 'General' }}</span>
                                <span class="px-2.5 py-1 bg-white/5 text-gray-400 text-[10px] font-black rounded uppercase border border-white/10 tracking-wider">
                                    {{ $channel->country ?? 'Global' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button onclick="copyToClipboard()" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 rounded-xl transition-all font-bold text-white shadow-lg shadow-red-600/20 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            Bagikan
                        </button>
                    </div>
                </div>
                
                @if($channel->description)
                    <div class="mt-8 bg-white/5 p-8 rounded-2xl border border-white/5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 blur-[60px] rounded-full"></div>
                        <h3 class="text-white font-black text-lg mb-4 uppercase tracking-tighter italic border-l-4 border-red-600 pl-4">Tentang Channel</h3>
                        <p class="text-gray-400 leading-relaxed text-sm md:text-base">{{ $channel->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar Channels --}}
            <div class="lg:col-span-1">
                <div class="bg-white/5 rounded-2xl border border-white/5 overflow-hidden sticky top-28 shadow-2xl">
                    <div class="p-6 border-b border-white/5 bg-white/5">
                        <h2 class="text-white font-black flex items-center gap-3 uppercase tracking-tighter text-sm italic">
                            <span class="w-1.5 h-6 bg-netflix-red rounded-full shadow-[0_0_10px_#e50914]"></span>
                            Stasiun TV Populer
                        </h2>
                    </div>
                    <div class="max-h-[600px] overflow-y-auto custom-scrollbar">
                        @foreach($channels as $otherChannel)
                            <a href="{{ route('tv_online.show', $otherChannel->slug) }}" class="flex items-center gap-5 p-5 hover:bg-white/5 transition-all group border-b border-white/5 last:border-0 {{ $otherChannel->id === $channel->id ? 'bg-red-600/10' : '' }}">
                                <div class="w-14 h-14 bg-black rounded-xl p-3 flex items-center justify-center border border-white/5 flex-shrink-0 group-hover:border-red-500/30 transition-all shadow-lg scale-90 group-hover:scale-100">
                                    @if($otherChannel->logo)
                                        <img src="{{ Str::startsWith($otherChannel->logo, 'http') ? $otherChannel->logo : asset('storage/' . $otherChannel->logo) }}" alt="{{ $otherChannel->name }}" class="max-w-full max-h-full object-contain filter {{ $otherChannel->id === $channel->id ? 'grayscale-0' : 'grayscale' }} group-hover:grayscale-0 transition-all">
                                    @else
                                        <div class="text-2xl">📺</div>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-sm font-black text-gray-300 group-hover:text-white truncate transition-colors leading-tight">{{ $otherChannel->name }}</h4>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <div class="flex items-center gap-1.5 px-1.5 py-0.5 bg-red-500/10 rounded border border-red-500/20">
                                            <span class="w-1 h-1 bg-red-500 rounded-full animate-pulse"></span>
                                            <span class="text-[8px] text-red-500 font-black uppercase tracking-widest">Live Now</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script>
    const errorOverlay = document.getElementById('player-error');
    let playInitiated = false;
    let fallbackTimer = null;

    function showFallback() {
        if (!playInitiated) {
            console.log('Playback fails to start, showing fallback options.');
            errorOverlay.classList.remove('hidden');
        }
    }

    @if($isHls)
    var player = videojs('hls-player', {
        autoplay: true,
        fluid: true,
        liveui: true,
        html5: {
            vhs: {
                overrideNative: true
            }
        }
    });

    player.on('playing', function() {
        console.log('Stream is now playing.');
        playInitiated = true;
        errorOverlay.classList.add('hidden');
        if (fallbackTimer) clearTimeout(fallbackTimer);
    });

    player.on('error', function() {
        const error = player.error();
        if (error) {
            console.error('Video.js Error:', error);
            showFallback();
        }
    });

    // Start a watchdog timer (8 seconds)
    fallbackTimer = setTimeout(showFallback, 8000);
    @endif

    @if(!$isHls && !$isYoutube && !$isIframe)
    // For generic iframes, we can't easily detect load success due to CORS
    // so we set a shorter timer to just offer the external link regardless if it stays black
    fallbackTimer = setTimeout(showFallback, 10000);
    @endif

    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        });
    }

    function copyStreamUrl() {
        navigator.clipboard.writeText('{{ $channel->stream_url }}').then(() => {
            alert('URL Stream berhasil disalin! Anda bisa memutar URL ini di VLC atau Player lain.');
        });
    }

    function reloadPlayer() {
        window.location.reload();
    }
</script>
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endpush
@endsection
