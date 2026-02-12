@extends('layouts.app')

@section('title', 'Register - Netflixku')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-black/60 relative overflow-hidden pt-24 pb-12">
    {{-- Background Image Overlay (Using the same as login for consistency) --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-netflix-dark via-netflix-dark/80 to-netflix-dark opacity-100"></div>
        <img src="https://assets.nflxext.com/ffe/siteui/vlv3/f841d4c7-10e1-40af-bca1-07b3f8dc1418/f6d7434e-d6de-4285-a0d3-0570a2f4705a/ID-en-20220502-popsignuptwoweeks-perspective_alpha_website_small.jpg" 
             class="w-full h-full object-cover opacity-30" alt="background">
    </div>

    <div class="relative z-10 w-full max-w-md p-8 md:p-12 bg-black/75 rounded-lg border border-white/10 backdrop-blur-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
        <p class="text-gray-400 text-sm mb-8">Join thousands of movies fans today.</p>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full bg-netflix-gray border @error('name') border-netflix-red @else border-white/20 @enderror rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
                @error('name')
                    <p class="text-netflix-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full bg-netflix-gray border @error('email') border-netflix-red @else border-white/20 @enderror rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
                @error('email')
                    <p class="text-netflix-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="ktp_number" class="block text-sm font-medium text-gray-400 mb-2">KTP Number (16 Digits)</label>
                <input type="text" name="ktp_number" id="ktp_number" value="{{ old('ktp_number') }}" required maxlength="16" minlength="16"
                    placeholder="Contoh: 3201234567890001"
                    class="w-full bg-netflix-gray border @error('ktp_number') border-netflix-red @else border-white/20 @enderror rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
                <p class="text-xs text-gray-500 mt-1 italic">Diperlukan untuk verifikasi kategori dewasa.</p>
                @error('ktp_number')
                    <p class="text-netflix-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full bg-netflix-gray border @error('password') border-netflix-red @else border-white/20 @enderror rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
                @error('password')
                    <p class="text-netflix-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full bg-netflix-gray border border-white/20 rounded-md py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-netflix-red transition-all">
            </div>

            <button type="submit" class="w-full bg-netflix-red text-white font-bold py-3 rounded-md hover:bg-red-700 transition-colors shadow-lg mt-4 active:scale-95 duration-150">
                Start Watching
            </button>
        </form>

        <div class="mt-8 pt-8 border-t border-white/10 text-gray-400 text-center">
            Already a member? <a href="{{ route('login') }}" class="text-white hover:underline font-semibold">Sign In</a>.
        </div>
    </div>
</div>
@endsection
