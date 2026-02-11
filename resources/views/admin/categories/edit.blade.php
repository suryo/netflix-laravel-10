@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-xl">
    <div class="bg-admin-card rounded-xl border border-admin-border p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="e.g. Action, Comedy..."
                    class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-admin-accent focus:border-transparent transition-all" required>
                @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-3 bg-admin-accent hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-gray-300 rounded-lg transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
