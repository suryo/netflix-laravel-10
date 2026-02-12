@extends('layouts.app')

@section('title', 'TV Online Global - Explore Channels')

@push('styles')
<style>
    .country-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .country-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(229, 9, 20, 0.4);
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5), 0 0 20px rgba(229, 9, 20, 0.1);
    }
    .country-card:hover .flag-emoji {
        transform: scale(1.2) rotate(5deg);
    }
    .flag-emoji {
        transition: transform 0.4s ease;
        display: inline-block;
    }
    .channel-panel {
        background: rgba(10, 10, 10, 0.95);
        backdrop-filter: blur(30px);
        z-index: 100;
        transform: translateX(100%);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .channel-panel.active {
        transform: translateX(0);
    }
    .search-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    .search-input:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #e50914;
        box-shadow: 0 0 15px rgba(229, 9, 20, 0.2);
        outline: none;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(229, 9, 20, 0.3); border-radius: 10px; }
    
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
@php
    $countryNames = [
        'ID' => ['name' => 'Indonesia', 'flag' => '🇮🇩'],
        'US' => ['name' => 'United States', 'flag' => '🇺🇸'],
        'GB' => ['name' => 'United Kingdom', 'flag' => '🇬🇧'],
        'JP' => ['name' => 'Japan', 'flag' => '🇯🇵'],
        'KR' => ['name' => 'South Korea', 'flag' => '🇰🇷'],
        'CN' => ['name' => 'China', 'flag' => '🇨🇳'],
        'FR' => ['name' => 'France', 'flag' => '🇫🇷'],
        'DE' => ['name' => 'Germany', 'flag' => '🇩🇪'],
        'ES' => ['name' => 'Spain', 'flag' => '🇪🇸'],
        'IT' => ['name' => 'Italy', 'flag' => '🇮🇹'],
        'BR' => ['name' => 'Brazil', 'flag' => '🇧🇷'],
        'RU' => ['name' => 'Russia', 'flag' => '🇷🇺'],
        'IN' => ['name' => 'India', 'flag' => '🇮🇳'],
        'TR' => ['name' => 'Turkey', 'flag' => '🇹🇷'],
        'AU' => ['name' => 'Australia', 'flag' => '🇦🇺'],
        'CA' => ['name' => 'Canada', 'flag' => '🇨🇦'],
        'SG' => ['name' => 'Singapore', 'flag' => '🇸🇬'],
        'MY' => ['name' => 'Malaysia', 'flag' => '🇲🇾'],
        'TH' => ['name' => 'Thailand', 'flag' => '🇹🇭'],
        'VN' => ['name' => 'Vietnam', 'flag' => '🇻🇳'],
        'PH' => ['name' => 'Philippines', 'flag' => '🇵🇭'],
    ];

    $displayCountries = [];
    foreach($countries as $code => $total) {
        $info = $countryNames[strtoupper($code)] ?? ['name' => $code, 'flag' => '🌍'];
        $displayCountries[] = [
            'id' => $code,
            'name' => $info['name'],
            'flag' => $info['flag'],
            'total' => $total
        ];
    }
    // Sort by total channels
    usort($displayCountries, fn($a, $b) => $b['total'] <=> $a['total']);
@endphp

<div class="pt-28 pb-20 px-4 md:px-12 min-h-screen" x-data="countryHub()" x-init="init()">
    {{-- Header --}}
    <div class="max-w-7xl mx-auto mb-16 text-center">
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tighter uppercase italic">
            TV <span class="text-netflix-red underline decoration-4 underline-offset-8">GLOBAL</span> HUB
        </h1>
        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed font-light">
            Temukan stasiun TV dari seluruh dunia. Pilih negara untuk mulai menonton siaran langsung.
        </p>

        {{-- Search Hub --}}
        <div class="max-w-xl mx-auto relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-netflix-red to-red-900 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative flex items-center">
                <input type="text" x-model="search" placeholder="Cari negara..." 
                    class="w-full search-input py-5 px-8 rounded-full text-white text-lg placeholder-gray-500 font-medium overflow-hidden shadow-2xl">
                <div class="absolute right-6 pointer-events-none">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Country Grid --}}
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <template x-for="country in filteredCountries" :key="country.id">
                <div class="country-card p-10 rounded-3xl group" @click="selectCountry(country)">
                    <div class="flex flex-col items-center text-center">
                        <span class="flag-emoji text-7xl mb-8 filter drop-shadow-2xl" x-text="country.flag"></span>
                        <h3 class="text-2xl font-black text-white mb-3 group-hover:text-netflix-red transition-colors" x-text="country.name"></h3>
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_#ef4444]"></span>
                            <span class="text-xs font-black text-gray-500 uppercase tracking-[0.2em]" x-text="country.total + ' Channels'"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Empty State --}}
        <div x-show="filteredCountries.length === 0" x-cloak class="py-32 text-center">
            <div class="text-8xl mb-8 opacity-20">📡</div>
            <h3 class="text-2xl font-bold text-gray-500 uppercase tracking-widest">Negara tidak ditemukan</h3>
            <p class="text-gray-600 mt-2">Coba kata kunci lain atau periksa koneksi Anda.</p>
        </div>
    </div>

    {{-- Side Panel (Channels) --}}
    <div id="channelPanel" class="channel-panel fixed right-0 top-0 bottom-0 w-full md:w-[450px] shadow-2xl overflow-hidden flex flex-col" :class="{ 'active': activePanel }">
        <div class="p-8 border-b border-white/5 bg-black/40 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic" x-text="selectedCountry?.name || 'Channels'"></h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black text-netflix-red uppercase tracking-[0.3em]">Live Feed</span>
                </div>
            </div>
            <button @click="activePanel = false" class="p-3 hover:bg-white/10 rounded-full transition-all hover:rotate-90">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar space-y-6">
            <template x-if="loading">
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="w-12 h-12 border-4 border-netflix-red border-t-transparent rounded-full animate-spin mb-4"></div>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Bridging Connection...</p>
                </div>
            </template>

            <template x-for="ch in channels" :key="ch.id">
                <a :href="'/tv-online/' + ch.slug" class="flex items-center gap-6 p-6 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-netflix-red/50 transition-all group scale-95 hover:scale-100 duration-300">
                    <div class="w-20 h-20 bg-black rounded-xl p-4 flex items-center justify-center border border-white/10 group-hover:border-netflix-red/30 flex-shrink-0 shadow-2xl relative overflow-hidden">
                        <template x-if="ch.logo">
                            <img :src="ch.logo.startsWith('http') ? ch.logo : '/storage/' + ch.logo" class="max-w-full max-h-full object-contain relative z-10">
                        </template>
                        <template x-if="!ch.logo">
                            <span class="text-4xl relative z-10">📺</span>
                        </template>
                        <div class="absolute inset-0 bg-gradient-to-t from-netflix-red/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-white font-black text-lg truncate group-hover:text-netflix-red transition-all" x-text="ch.name"></h4>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-3" x-text="ch.category || 'General'"></p>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="w-full h-full bg-netflix-red animate-[shimmer_2s_infinite]"></div>
                            </div>
                            <span class="text-[10px] font-black text-netflix-red uppercase tracking-widest">Watching</span>
                        </div>
                    </div>
                </a>
            </template>
        </div>
    </div>
    
    {{-- Background Decorative Elements --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden opacity-30">
        <div class="absolute -top-1/4 -left-1/4 w-1/2 h-1/2 bg-red-900/20 rounded-full blur-[150px]"></div>
        <div class="absolute -bottom-1/4 -right-1/4 w-1/2 h-1/2 bg-red-900/20 rounded-full blur-[150px]"></div>
    </div>
</div>

@push('scripts')
<script>
function countryHub() {
    return {
        search: '',
        countries: @json($displayCountries),
        filteredCountries: [],
        selectedCountry: null,
        channels: [],
        loading: false,
        activePanel: false,

        init() {
            this.filteredCountries = this.countries;
            this.$watch('search', value => {
                const term = value.toLowerCase();
                this.filteredCountries = this.countries.filter(c => 
                    c.name.toLowerCase().includes(term) || c.id.toLowerCase().includes(term)
                );
            });
        },

        selectCountry(country) {
            this.selectedCountry = country;
            this.activePanel = true;
            this.loading = true;
            this.channels = [];

            fetch(`/tv-online?country=${country.id}`)
                .then(res => res.json())
                .then(data => {
                    this.channels = data;
                    this.loading = false;
                })
                .catch(err => {
                    alert('Gagal memuat channel. Periksa koneksi Anda.');
                    this.loading = false;
                });
        }
    }
}
</script>
<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
</style>
@endpush
@endsection
