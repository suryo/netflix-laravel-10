@extends('layouts.admin')

@section('title', 'Komentar')
@section('page-title', 'Kelola Komentar')

@section('content')
<div class="bg-admin-card rounded-xl border border-admin-border">
    <div class="p-6 border-b border-admin-border">
        <h3 class="text-white font-bold">Semua Komentar <span class="text-gray-500 font-normal text-sm">({{ $comments->total() }})</span></h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-admin-border text-left">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengirim</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Film</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Isi Komentar</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border">
                @forelse($comments as $i => $comment)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $comments->firstItem() + $i }}</td>
                    <td class="px-6 py-4 text-sm text-white font-medium">{{ $comment->name }}</td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-400">{{ $comment->email }}</div>
                        <div class="text-xs text-green-500 font-medium">{{ $comment->whatsapp }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('movies.show', $comment->movie->slug) }}" target="_blank" class="text-xs text-admin-accent hover:underline">
                            {{ $comment->movie->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-400">
                        <div class="max-w-xs truncate" title="{{ $comment->content }}">
                            {{ $comment->content }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">
                        {{ $comment->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada komentar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
    <div class="p-6 border-t border-admin-border">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection
