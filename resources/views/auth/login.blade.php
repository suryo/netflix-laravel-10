@extends('layouts.app')

@section('title', 'Login - Netflixku')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-black/60 relative overflow-hidden pt-20">
    {{-- Background Image Overlay --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-netflix-dark via-netflix-dark/80 to-netflix-dark opacity-100"></div>
        <img src="https://assets.nflxext.com/ffe/siteui/vlv3/f841d4c7-10e1-40af-bca1-07b3f8dc1418/f6d7434e-d6de-4285-a0d3-0570a2f4705a/ID-en-20220502-popsignuptwoweeks-perspective_alpha_website_small.jpg" 
             class="w-full h-full object-cover opacity-30" alt="background">
    </div>

    <div class="relative z-10 w-full max-w-md p-8 md:p-12 bg-black/75 rounded-lg border border-white/10 backdrop-blur-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-8">Sign In</h1>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full bg-netflix-gray border @error('email') border-netflix-red @else border-white/20 @enderror rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
                @error('email')
                    <p class="text-netflix-red text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-netflix-gray border border-white/20 rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-400 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-netflix-gray border-white/20 text-netflix-red focus:ring-netflix-red">
                    Remember me
                </label>
            </div>

            <button type="submit" class="w-full bg-netflix-red text-white font-bold py-3 rounded-md hover:bg-red-700 transition-colors shadow-lg active:scale-95 duration-150">
                Sign In
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-white/10 text-gray-400">
            New to Netflixku? <a href="{{ route('register') }}" class="text-white hover:underline font-semibold">Sign up now</a>.
        </div>
    </div>
</div>
@endsection
