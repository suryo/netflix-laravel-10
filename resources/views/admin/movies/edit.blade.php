@extends('layouts.admin')

@section('title', 'Edit Movie')
@section('page-title', 'Edit: ' . $movie->title)

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
        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data" id="movieForm">
            @csrf @method('PUT')

            {{-- Title, Type & Category --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-300 mb-2" id="titleLabel">Movie Title *</label>
                    <input type="text" name="title" value="{{ old('title', $movie->title) }}" placeholder="e.g. The Dark Knight"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                    @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Content Type *</label>
                    <select name="type" id="typeSelect" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                        <option value="movie" {{ old('type', $movie->type) == 'movie' ? 'selected' : '' }}>Movie</option>
                        <option value="tv_series" {{ old('type', $movie->type) == 'tv_series' ? 'selected' : '' }}>TV Series</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                    <select name="category_id" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $movie->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }} {{ $category->is_adult ? '(18+)' : '' }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Description (Rich Text) --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <div id="editor" style="height: 200px;">{!! old('description', $movie->description) !!}</div>
                <input type="hidden" name="description" id="description">
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Video URL & Quality --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2" id="videoUrlLabel">
                        Video URL (Google Drive)
                    </label>
                    <input type="text" name="video_url" id="videoUrlInput" value="{{ old('video_url', $movie->video_url) }}" placeholder="https://drive.google.com/file/d/xxx/view?usp=sharing"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                    <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-wider font-semibold" id="videoUrlHint">💡 Paste link share Google Drive, otomatis konversi ke embed</p>
                    @error('video_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quality Badge</label>
                    <select name="quality" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                        <option value="HD" {{ old('quality', $movie->quality) == 'HD' ? 'selected' : '' }}>HD</option>
                        <option value="4K" {{ old('quality', $movie->quality) == '4K' ? 'selected' : '' }}>4K Ultra HD</option>
                        <option value="CAM" {{ old('quality', $movie->quality) == 'CAM' ? 'selected' : '' }}>CAM / TS</option>
                        <option value="SD" {{ old('quality', $movie->quality) == 'SD' ? 'selected' : '' }}>SD</option>
                    </select>
                </div>
            </div>

            {{-- Images with resolution info and previews --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Poster Image</label>
                    <p class="text-[10px] text-admin-accent uppercase tracking-tighter mb-2 font-bold">Rekomendasi: 600 x 900 px (Portrait 2:3)</p>
                    <input type="file" name="poster" id="posterInput" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer transition-all">
                    <div class="mt-2">
                        @if($movie->poster)
                            <img id="posterPreview" class="image-preview" src="{{ asset('storage/' . $movie->poster) }}" alt="Poster Preview">
                        @else
                            <img id="posterPreview" class="image-preview" style="display:none;" src="#" alt="Poster Preview">
                        @endif
                    </div>
                    @error('poster')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Banner / Backdrop Image</label>
                    <p class="text-[10px] text-admin-accent uppercase tracking-tighter mb-2 font-bold">Rekomendasi: 1280 x 720 px (Landscape 16:9)</p>
                    <input type="file" name="backdrop" id="backdropInput" accept="image/*" class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-admin-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer transition-all">
                    <div class="mt-2">
                        @if($movie->backdrop)
                            <img id="backdropPreview" class="image-preview" src="{{ asset('storage/' . $movie->backdrop) }}" alt="Backdrop Preview">
                        @else
                            <img id="backdropPreview" class="image-preview" style="display:none;" src="#" alt="Backdrop Preview">
                        @endif
                    </div>
                    @error('backdrop')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Rating, Year, Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 border-t border-admin-border pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                    <input type="text" name="rating" value="{{ old('rating', $movie->rating) }}" placeholder="e.g. 8.5"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Release Year</label>
                    <input type="number" name="release_year" value="{{ old('release_year', $movie->release_year) }}" placeholder="e.g. 2024" min="1900" max="2099"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2" id="durationLabel">Duration</label>
                    <input type="text" name="duration" id="durationInput" value="{{ old('duration', $movie->duration) }}" placeholder="e.g. 2h 30m"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Director & Cast --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Director</label>
                    <input type="text" name="director" value="{{ old('director', $movie->director) }}" placeholder="e.g. Christopher Nolan"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cast</label>
                    <input type="text" name="cast" value="{{ old('cast', $movie->cast) }}" placeholder="e.g. Actor 1, Actor 2"
                        class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Episode Management (Visible only for TV Series) --}}
            <div id="episodeSection" class="hidden mb-8 border-t border-admin-border pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Episode Management
                    </h3>
                    <button type="button" id="addEpisodeBtn" class="px-4 py-2 bg-admin-accent hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Episode
                    </button>
                </div>
                
                <div id="episodeContainer" class="space-y-4">
                    @foreach($movie->episodes as $index => $episode)
                    <div class="episode-row bg-white/5 p-4 rounded-lg border border-admin-border relative group animate-fadeIn">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">No</label>
                                <input type="number" name="episodes[{{ $index }}][episode_number]" value="{{ $episode->episode_number }}" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent" required>
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Episode Title</label>
                                <input type="text" name="episodes[{{ $index }}][title]" value="{{ $episode->title }}" placeholder="e.g. Pilot / Episode 1" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent">
                            </div>
                            <div class="md:col-span-6">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">G-Drive Video URL</label>
                                <input type="text" name="episodes[{{ $index }}][video_url]" value="{{ $episode->video_url }}" placeholder="https://drive.google.com/file/d/xxx/view" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent" required>
                            </div>
                            <div class="md:col-span-1 flex justify-center">
                                <button type="button" class="remove-episode p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <template id="episodeTemplate">
                    <div class="episode-row bg-white/5 p-4 rounded-lg border border-admin-border relative group animate-fadeIn">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-1">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">No</label>
                                <input type="number" name="episodes[{index}][episode_number]" value="{number}" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent" required>
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Episode Title</label>
                                <input type="text" name="episodes[{index}][title]" placeholder="e.g. Pilot / Episode 1" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent">
                            </div>
                            <div class="md:col-span-6">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">G-Drive Video URL</label>
                                <input type="text" name="episodes[{index}][video_url]" placeholder="https://drive.google.com/file/d/xxx/view" class="w-full bg-admin-bg border border-admin-border rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-admin-accent" required>
                            </div>
                            <div class="md:col-span-1 flex justify-center">
                                <button type="button" class="remove-episode p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4">
                <button type="submit" class="px-10 py-3 bg-admin-accent hover:bg-blue-600 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-admin-accent/20">
                    Update Movie
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
    // Dynamic labels and episode section based on Content Type
    const typeSelect = document.getElementById('typeSelect');
    const titleLabel = document.getElementById('titleLabel');
    const durationLabel = document.getElementById('durationLabel');
    const durationInput = document.getElementById('durationInput');
    const videoUrlLabel = document.getElementById('videoUrlLabel');
    const videoUrlHint = document.getElementById('videoUrlHint');
    const episodeSection = document.getElementById('episodeSection');

    function updateLabels() {
        if (typeSelect.value === 'tv_series') {
            titleLabel.innerText = 'Series Title *';
            durationLabel.innerText = 'Total Episodes';
            durationInput.placeholder = 'e.g. 12 Episodes / 1 Season';
            videoUrlLabel.innerText = 'Main Trailer / Playlist URL';
            videoUrlHint.innerText = '💡 URL Utama untuk TV Series (Trailer/Playlist)';
            episodeSection.classList.remove('hidden');
        } else {
            titleLabel.innerText = 'Movie Title *';
            durationLabel.innerText = 'Duration';
            durationInput.placeholder = 'e.g. 2h 30m';
            videoUrlLabel.innerText = 'Video URL (Google Drive)';
            videoUrlHint.innerText = '💡 Paste link share Google Drive, otomatis konversi ke embed';
            episodeSection.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', updateLabels);
    updateLabels(); // Initial run

    // Episode Row Management
    const addEpisodeBtn = document.getElementById('addEpisodeBtn');
    const episodeContainer = document.getElementById('episodeContainer');
    const episodeTemplate = document.getElementById('episodeTemplate').innerHTML;
    let episodeIndex = {{ $movie->episodes->count() }};

    function addEpisodeRow() {
        const nextNumber = episodeContainer.children.length + 1;
        const html = episodeTemplate
            .replace(/{index}/g, episodeIndex)
            .replace(/{number}/g, nextNumber);
        
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const row = tempDiv.firstElementChild;
        
        // Remove button functionality
        row.querySelector('.remove-episode').addEventListener('click', function() {
            row.remove();
            reorderEpisodes();
        });

        episodeContainer.appendChild(row);
        episodeIndex++;
    }

    function reorderEpisodes() {
        const rows = episodeContainer.querySelectorAll('.episode-row');
        rows.forEach((row, idx) => {
            const numInput = row.querySelector('input[type="number"]');
            if(numInput) numInput.value = idx + 1;
        });
    }

    addEpisodeBtn.addEventListener('click', addEpisodeRow);

    // Initial listener for existing rows
    document.querySelectorAll('.remove-episode').forEach(btn => {
        btn.addEventListener('click', function() {
            btn.closest('.episode-row').remove();
            reorderEpisodes();
        });
    });
</script>
@endpush
