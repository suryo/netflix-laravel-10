@extends('layouts.admin')

@section('title', 'Add Movie')
@section('page-title', 'Add New Movie')

@section('content')
<div class="max-w-3xl">
    <div class="bg-admin-card rounded-xl border border-admin-border p-6">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title & Category --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Movie Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. The Dark Knight"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent" required>
                    @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category_id" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="4" placeholder="Movie synopsis..."
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent resize-y">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Video URL (Google Drive) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Video URL (Google Drive)
                    <span class="text-gray-500 text-xs font-normal ml-1">Paste Google Drive sharing link</span>
                </label>
                <input type="text" name="video_url" value="{{ old('video_url') }}" placeholder="https://drive.google.com/file/d/xxx/view?usp=sharing"
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                <p class="text-xs text-gray-600 mt-1">💡 Supports: drive.google.com/file/d/ID/view, drive.google.com/open?id=ID</p>
                @error('video_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Images --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Poster Image</label>
                    <input type="file" name="poster" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer">
                    @error('poster')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Backdrop Image</label>
                    <input type="file" name="backdrop" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer">
                    @error('backdrop')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Rating, Year, Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                    <input type="text" name="rating" value="{{ old('rating') }}" placeholder="e.g. 8.5"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="e.g. 2024" min="1900" max="2099"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" placeholder="e.g. 2h 30m"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
            </div>

            {{-- Director & Cast --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input type="text" name="director" value="{{ old('director') }}" placeholder="e.g. Christopher Nolan"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cast</label>
                    <input type="text" name="cast" value="{{ old('cast') }}" placeholder="e.g. Actor 1, Actor 2"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
            </div>

            {{-- Featured --}}
            <div class="mb-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="w-5 h-5 rounded bg-admin-bg border-admin-border text-admin-accent focus:ring-admin-accent">
                    <span class="text-sm text-gray-300">Featured Movie (shown in hero section)</span>
                </label>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="px-8 py-3 bg-admin-accent hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                    Save Movie
                </button>
                <a href="{{ route('admin.movies.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-gray-300 rounded-lg transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
