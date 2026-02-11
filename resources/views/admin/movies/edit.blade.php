@extends('layouts.admin')

@section('title', 'Edit Movie')
@section('page-title', 'Edit: ' . $movie->title)

@section('content')
<div class="max-w-3xl">
    <div class="bg-admin-card rounded-xl border border-admin-border p-6">
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Title & Category --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Movie Title *</label>
                    <input type="text" name="title" value="{{ old('title', $movie->title) }}" placeholder="e.g. The Dark Knight"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent" required>
                    @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category_id" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $movie->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="4" placeholder="Movie synopsis..."
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent resize-y">{{ old('description', $movie->description) }}</textarea>
            </div>

            {{-- Video URL --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Video URL (Google Drive)
                </label>
                <input type="text" name="video_url" value="{{ old('video_url', $movie->video_url) }}" placeholder="https://drive.google.com/file/d/xxx/view?usp=sharing"
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                <p class="text-xs text-gray-600 mt-1">💡 Paste Google Drive sharing link, it will be auto-converted for playback</p>
            </div>

            {{-- Current Images & Upload --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Poster Image</label>
                    @if($movie->poster)
                        <div class="mb-2 relative inline-block">
                            <img src="{{ asset('storage/' . $movie->poster) }}" class="w-24 h-36 object-cover rounded-lg border border-admin-border">
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-admin-card"></span>
                        </div>
                    @endif
                    <input type="file" name="poster" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer">
                    <p class="text-xs text-gray-600 mt-1">Leave empty to keep current</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Backdrop Image</label>
                    @if($movie->backdrop)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $movie->backdrop) }}" class="w-40 h-20 object-cover rounded-lg border border-admin-border">
                        </div>
                    @endif
                    <input type="file" name="backdrop" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer">
                    <p class="text-xs text-gray-600 mt-1">Leave empty to keep current</p>
                </div>
            </div>

            {{-- Rating, Year, Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                    <input type="text" name="rating" value="{{ old('rating', $movie->rating) }}" placeholder="e.g. 8.5"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year', $movie->release_year) }}" placeholder="e.g. 2024" min="1900" max="2099"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration', $movie->duration) }}" placeholder="e.g. 2h 30m"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
            </div>

            {{-- Director & Cast --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input type="text" name="director" value="{{ old('director', $movie->director) }}" placeholder="e.g. Christopher Nolan"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cast</label>
                    <input type="text" name="cast" value="{{ old('cast', $movie->cast) }}" placeholder="e.g. Actor 1, Actor 2"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent">
                </div>
            </div>

            {{-- Featured --}}
            <div class="mb-8">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $movie->is_featured) ? 'checked' : '' }}
                        class="w-5 h-5 rounded bg-admin-bg border-admin-border text-admin-accent focus:ring-admin-accent">
                    <span class="text-sm text-gray-300">Featured Movie (shown in hero section)</span>
                </label>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3">
                <button type="submit" class="px-8 py-3 bg-admin-accent hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                    Update Movie
                </button>
                <a href="{{ route('admin.movies.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-gray-300 rounded-lg transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
