<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Netflixku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] },
                    colors: {
                        netflix: { red: '#E50914', dark: '#141414', darker: '#0a0a0a' },
                        admin: { bg: '#0f172a', card: '#1e293b', border: '#334155', accent: '#3b82f6' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(59,130,246,0.1); color: #3b82f6; border-right: 3px solid #3b82f6; }
    </style>
    @stack('styles')
</head>
<body class="bg-admin-bg text-gray-300 min-h-screen">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 min-h-screen bg-admin-card border-r border-admin-border fixed left-0 top-0 z-40 hidden lg:block">
            <div class="p-6 border-b border-admin-border">
                <a href="{{ route('admin.dashboard') }}" class="text-netflix-red font-black text-xl tracking-wider">NETFLIXKU</a>
                <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
            </div>
            <nav class="py-4">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categories
                </a>
                <a href="{{ route('admin.movies.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                    Movies
                </a>
                <a href="{{ route('admin.comments.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Comments
                </a>
                <a href="{{ route('admin.users.approvals') }}" class="sidebar-link flex items-center justify-between px-6 py-3 text-sm font-medium {{ request()->routeIs('admin.users.approvals') ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.605 2.02a2.335 2.335 0 01-2.012 2.012 3.323 3.323 0 00-4.016 4.016 2.335 2.335 0 012.012 2.012 3.323 3.323 0 004.016 4.016 2.335 2.335 0 012.012 2.012 3.323 3.323 0 004.016-4.016 2.335 2.335 0 01-2.012-2.012z"/></svg>
                        Approvals
                    </div>
                    @if(isset($pendingApprovals) && $pendingApprovals > 0)
                        <span class="bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full shadow-lg pulse-glow">{{ $pendingApprovals }}</span>
                    @endif
                </a>
                <div class="border-t border-admin-border my-4"></div>
                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Site
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="px-6 py-3">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-sm font-medium text-red-500/70 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header class="bg-admin-card border-b border-admin-border px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="lg:hidden text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-lg font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">Admin</span>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-admin-accent to-purple-600 flex items-center justify-center text-white text-xs font-bold">A</div>
                </div>
            </header>

            {{-- Mobile Sidebar --}}
            <div id="mobile-sidebar" class="hidden lg:hidden fixed inset-0 bg-black/50 z-50" onclick="this.classList.add('hidden')">
                <div class="w-64 min-h-screen bg-admin-card border-r border-admin-border" onclick="event.stopPropagation()">
                    <div class="p-6 border-b border-admin-border">
                        <span class="text-netflix-red font-black text-xl">NETFLIXKU</span>
                    </div>
                    <nav class="py-4">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium">Categories</a>
                        <a href="{{ route('admin.movies.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium">Movies</a>
                        <a href="{{ route('admin.comments.index') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium">Comments</a>
                        <a href="{{ route('admin.users.approvals') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium text-amber-400">User Approvals</a>

                        <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-6 py-3 text-sm font-medium text-gray-500">View Site</a>

                        <form action="{{ route('logout') }}" method="POST" class="px-6 py-3">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-500">Logout</button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mx-6 mt-4" id="flash-msg">
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg px-4 py-3 text-sm flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </span>
                    <button onclick="document.getElementById('flash-msg').remove()" class="text-green-300 hover:text-white">&times;</button>
                </div>
            </div>
            @endif

            {{-- Page Content --}}
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
