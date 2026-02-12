@extends('layouts.admin')

@section('title', 'Add TV Channel')
@section('page-title', 'Add New Channel')

@section('content')
<div class="max-w-3xl">
    <div class="bg-admin-card rounded-xl border border-admin-border p-8">
        <form action="{{ route('admin.tv-channels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Channel Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Metro TV"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="e.g. News"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                    @error('category')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Country Code (ID, US, etc)</label>
                    <input type="text" name="country" value="{{ old('country') }}" placeholder="e.g. ID"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all uppercase">
                    @error('country')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Streaming URL *</label>
                <input type="text" name="stream_url" value="{{ old('stream_url') }}" placeholder="HLS (.m3u8) or Embed URL"
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                <p class="text-[10px] text-gray-500 mt-1">💡 Masukkan URL streaming langsung (HLS) atau URL embed dari YouTube/pihak ketiga.</p>
                @error('stream_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" placeholder="Brief description of the channel..."
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Channel Logo</label>
                <input type="file" name="logo" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer transition-all">
                <p class="text-[10px] text-admin-accent uppercase tracking-tighter mt-1 font-bold italic">Rekomendasi: 200 x 200 px (Square)</p>
                @error('logo')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" class="sr-only" checked>
                        <div class="block bg-admin-border w-10 h-6 rounded-full group-hover:bg-gray-600 transition-colors"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform translate-x-4"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-300">Active / Published</span>
                </label>
            </div>

            <div class="flex items-center gap-4 border-t border-admin-border pt-8">
                <button type="submit" class="px-8 py-3 bg-admin-accent hover:bg-blue-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-admin-accent/20">
                    Create Channel
                </button>
                <a href="{{ route('admin.tv-channels.index') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 rounded-xl transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    input:checked ~ .block { background-color: #3b82f6; }
    input:checked ~ .dot { transform: translateX(100%); }
</style>
@endsection
