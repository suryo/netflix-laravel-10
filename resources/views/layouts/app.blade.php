<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Netflixku - Streaming film online terbaik">
    <title>@yield('title', 'Netflixku')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] },
                    colors: {
                        netflix: { red: '#E50914', dark: '#141414', darker: '#0a0a0a', gray: '#1a1a1a', light: '#e5e5e5' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #0a0a0a; color: #e5e5e5; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .movie-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .movie-card:hover { transform: scale(1.08); z-index: 10; }
        .gradient-overlay { background: linear-gradient(to top, #0a0a0a 0%, transparent 60%); }
        .gradient-overlay-right { background: linear-gradient(to right, #0a0a0a 0%, transparent 50%); }
        .text-glow { text-shadow: 0 0 20px rgba(229, 9, 20, 0.5); }
        .btn-netflix { background: #E50914; transition: all 0.2s; }
        .btn-netflix:hover { background: #f6121d; transform: scale(1.05); box-shadow: 0 0 20px rgba(229, 9, 20, 0.4); }
        .glass-nav { background: rgba(10, 10, 10, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .pulse-glow { animation: pulseGlow 2s infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 5px rgba(229,9,20,0.3); } 50% { box-shadow: 0 0 20px rgba(229,9,20,0.6); } }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">
    {{-- Impersonation Banner --}}
    @if(session()->has('impersonator_id'))
    <div class="bg-amber-500 text-black py-2 px-4 sticky top-0 z-[100] flex items-center justify-between shadow-xl">
        <div class="flex items-center gap-2 text-xs md:text-sm font-bold">
            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>MODE IMPERSONASI: Anda sedang melihat sebagai {{ auth()->user()->name }}</span>
        </div>
        <a href="{{ route('admin.stop_impersonating') }}" class="bg-black text-amber-500 px-3 py-1 rounded text-[10px] md:text-xs font-black hover:bg-black/80 transition-all uppercase tracking-tighter">
            Kembali ke Admin &rarr;
        </a>
    </div>
    @endif

    {{-- Navigation --}}
    <nav class="glass-nav fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ session()->has('impersonator_id') ? 'mt-9' : '' }}" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-netflix-red font-black text-2xl tracking-wider hover:text-glow transition-all">
                        NETFLIXKU
                    </a>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} transition-colors">Home</a>
                        <a href="{{ route('movies.index') }}" class="text-sm font-medium {{ request()->routeIs('movies.index') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} transition-colors">Movies</a>
                        <a href="{{ route('tv.index') }}" class="text-sm font-medium {{ request()->routeIs('tv.index') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} transition-colors">Tv Series</a>
                        <a href="{{ route('tv_online.index') }}" class="text-sm font-medium {{ request()->routeIs('tv_online.*') ? 'text-white font-bold' : 'text-gray-300 hover:text-white' }} transition-colors">TV Online</a>
                        
                        @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->is_approved_adult))
                            <a href="{{ route('movies.adult') }}" class="text-sm font-black text-netflix-red hover:text-red-400 transition-all flex items-center gap-1">
                                <span class="bg-netflix-red text-white text-[10px] px-1 rounded">21+</span>
                                Content
                            </a>
                        @endif
                        
                        {{-- Categories Dropdown --}}
                        <div class="relative group">
                            <button class="text-sm font-medium text-gray-300 hover:text-white transition-colors flex items-center gap-1">
                                Categories
                                <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute top-full left-0 mt-2 w-48 bg-netflix-gray/95 backdrop-blur-xl rounded-lg shadow-2xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2">
                                @php 
                                    $navCategories = \App\Models\Category::all(); 
                                    if(Auth::check() && Auth::user()->is_approved_adult) {
                                        // Show all
                                    } else {
                                        $navCategories = $navCategories->where('is_adult', false);
                                    }
                                @endphp
                                @foreach($navCategories as $cat)
                                    <a href="{{ route('movies.category', $cat->slug) }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">{{ $cat->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center space-x-4">
                    <form action="{{ route('search') }}" method="GET" class="relative hidden sm:block" id="search-form">
                        <div class="flex items-center">
                            <button type="button" onclick="toggleSearch()" class="text-gray-300 hover:text-white transition-colors p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                            <input type="text" name="q" placeholder="Titles, people, genres..." value="{{ request('q') }}"
                                class="search-input w-0 bg-transparent border-b border-white/30 text-white text-sm focus:outline-none focus:border-netflix-red transition-all duration-300 opacity-0"
                                id="search-input">
                        </div>
                    </form>

                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-netflix-red transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-netflix px-4 py-2 text-white text-xs font-bold rounded-md">Join Now</a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center gap-2 group">
                                <div class="w-8 h-8 rounded bg-netflix-red flex items-center justify-center font-bold text-white text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="w-3 h-3 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            
                            <div class="absolute top-full right-0 mt-2 w-48 bg-netflix-gray/95 backdrop-blur-xl rounded-lg shadow-2xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2">
                                <div class="px-4 py-2 border-b border-white/5 mb-1 text-xs text-gray-500">
                                    Signed in as <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                                </div>
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">Admin Panel</a>
                                @endif
                                
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">Account Settings</a>
                                
                                <form action="{{ route('logout') }}" method="POST" class="mt-1 border-t border-white/5 pt-1">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-netflix-red hover:bg-white/5 transition-colors font-semibold">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    {{-- Mobile Menu Trigger --}}
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-300 hover:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
                    {{-- Mobile Menu --}}
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-300 hover:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden hidden bg-netflix-dark/95 backdrop-blur-xl border-t border-white/5">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-sm text-white">Home</a>
                <a href="{{ route('movies.index') }}" class="block text-sm text-gray-300">Movies</a>
                <a href="{{ route('tv_online.index') }}" class="block text-sm text-gray-300">TV Online</a>
                @foreach($navCategories as $cat)
                    <a href="{{ route('movies.category', $cat->slug) }}" class="block text-sm text-gray-400 pl-4">{{ $cat->name }}</a>
                @endforeach
                <a href="{{ route('admin.dashboard') }}" class="block text-sm text-netflix-red font-medium">Admin Panel</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-netflix-darker border-t border-white/5 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-netflix-red font-bold text-lg mb-4">NETFLIXKU</h4>
                    <p class="text-gray-500 text-sm">Platform streaming film online terbaik. Nikmati berbagai film dan video dari berbagai genre.</p>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm">Navigation</h5>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Home</a></li>
                        <li><a href="{{ route('movies.index') }}" class="text-gray-500 hover:text-white text-sm transition-colors">All Movies</a></li>
                        <li><a href="{{ route('search') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Search</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm">Categories</h5>
                    <ul class="space-y-2">
                        @foreach($navCategories->take(5) as $cat)
                        <li><a href="{{ route('movies.category', $cat->slug) }}" class="text-gray-500 hover:text-white text-sm transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm">Admin</h5>
                    <ul class="space-y-2">
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Manage Categories</a></li>
                        <li><a href="{{ route('admin.movies.index') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Manage Movies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 mt-8 pt-8 text-center">
                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} Netflixku. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl');
                nav.style.background = 'rgba(10, 10, 10, 0.95)';
            } else {
                nav.classList.remove('shadow-2xl');
                nav.style.background = 'rgba(10, 10, 10, 0.85)';
            }
        });

        // Search toggle
        function toggleSearch() {
            const input = document.getElementById('search-input');
            if (input.classList.contains('w-0')) {
                input.classList.remove('w-0', 'opacity-0');
                input.classList.add('w-48', 'opacity-100', 'pl-2');
                input.focus();
            } else {
                input.classList.add('w-0', 'opacity-0');
                input.classList.remove('w-48', 'opacity-100', 'pl-2');
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        // Submit search on Enter
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('search-form').submit();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
