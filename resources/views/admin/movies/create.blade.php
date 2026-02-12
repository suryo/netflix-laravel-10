@extends('layouts.admin')

@section('title', 'Add Movie')
@section('page-title', 'Add New Movie')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background: #0f172a;
        color: white;
        font-family: inherit;
    }
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        background: #1e293b;
        border-color: #334155 !important;
    }
    .ql-container.ql-snow {
        border-color: #334155 !important;
    }
    .ql-editor.ql-blank::before {
        color: #475569 !important;
        font-style: normal;
    }
    .image-preview {
        display: none;
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        border: 1px solid #334155;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl">
    <div class="bg-admin-card rounded-xl border border-admin-border p-8">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" id="movieForm">
            @csrf

            {{-- Title, Type & Category --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Movie Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. The Dark Knight"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                    @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Content Type *</label>
                    <select name="type" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                        <option value="movie" {{ old('type') == 'movie' ? 'selected' : '' }}>Movie</option>
                        <option value="tv_series" {{ old('type') == 'tv_series' ? 'selected' : '' }}>TV Series</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category_id" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }} {{ $category->is_adult ? '(18+)' : '' }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Description (Rich Text) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <div id="editor" style="height: 200px;">{!! old('description') !!}</div>
                <input type="hidden" name="description" id="description">
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Video URL & Quality --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Video URL (Google Drive)
                    </label>
                    <input type="text" name="video_url" value="{{ old('video_url') }}" placeholder="https://drive.google.com/file/d/xxx/view?usp=sharing"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                    <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-wider font-semibold">💡 Paste link share Google Drive, otomatis konversi ke embed</p>
                    @error('video_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quality Badge</label>
                    <select name="quality" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                        <option value="HD" {{ old('quality') == 'HD' ? 'selected' : '' }}>HD</option>
                        <option value="4K" {{ old('quality') == '4K' ? 'selected' : '' }}>4K Ultra HD</option>
                        <option value="CAM" {{ old('quality') == 'CAM' ? 'selected' : '' }}>CAM / TS</option>
                        <option value="SD" {{ old('quality') == 'SD' ? 'selected' : '' }}>SD</option>
                    </select>
                </div>
            </div>

            {{-- Images with resolution info and previews --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Poster Image</label>
                    <p class="text-[10px] text-admin-accent uppercase tracking-tighter mb-2 font-bold">Rekomendasi: 600 x 900 px (Portrait 2:3)</p>
                    <input type="file" name="poster" id="posterInput" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer transition-all">
                    <img id="posterPreview" class="image-preview" src="#" alt="Poster Preview">
                    @error('poster')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Banner / Backdrop Image</label>
                    <p class="text-[10px] text-admin-accent uppercase tracking-tighter mb-2 font-bold">Rekomendasi: 1280 x 720 px (Landscape 16:9)</p>
                    <input type="file" name="backdrop" id="backdropInput" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer transition-all">
                    <img id="backdropPreview" class="image-preview" src="#" alt="Backdrop Preview">
                    @error('backdrop')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Rating, Year, Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 border-t border-admin-border pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                    <input type="text" name="rating" value="{{ old('rating') }}" placeholder="e.g. 8.5"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year') }}" placeholder="e.g. 2024" min="1900" max="2099"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Duration</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" placeholder="e.g. 2h 30m"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Director & Cast --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input type="text" name="director" value="{{ old('director') }}" placeholder="e.g. Christopher Nolan"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cast</label>
                    <input type="text" name="cast" value="{{ old('cast') }}" placeholder="e.g. Actor 1, Actor 2"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-white/5 rounded-lg border border-admin-border hover:border-admin-accent/30 transition-colors">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="w-5 h-5 rounded bg-admin-bg border-admin-border text-admin-accent focus:ring-admin-accent">
                        <span class="text-sm text-gray-300 font-semibold">Tandai sebagai Unggulan (Tampil di Hero Banner)</span>
                    </label>
                </div>
                <div class="p-4 bg-white/5 rounded-lg border border-admin-border hover:border-admin-accent/30 transition-colors">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_slider" value="1" {{ old('is_slider') ? 'checked' : '' }}
                            class="w-5 h-5 rounded bg-admin-bg border-admin-border text-admin-accent focus:ring-admin-accent">
                        <span class="text-sm text-gray-300 font-semibold">Tampilkan di Slider Landing Page</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="px-10 py-3 bg-admin-accent hover:bg-blue-600 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-admin-accent/20">
                    Selesai & Simpan
                </button>
                <a href="{{ route('admin.movies.index') }}" class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 rounded-lg transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    // Initialize Quill
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis sinopsis film di sini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    // Sync content to hidden field before submit
    const form = document.querySelector('#movieForm');
    form.onsubmit = function() {
        const description = document.querySelector('#description');
        description.value = quill.root.innerHTML;
        if(description.value === '<p><br></p>') description.value = '';
    };

    // Image Previews
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('posterInput').addEventListener('change', function() {
        readURL(this, 'posterPreview');
    });

    document.getElementById('backdropInput').addEventListener('change', function() {
        readURL(this, 'backdropPreview');
    });
</script>
@endpush
