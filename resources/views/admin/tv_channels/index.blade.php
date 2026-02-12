@extends('layouts.admin')

@section('title', 'TV Channels')
@section('page-title', 'Manage TV Channels')

@section('content')
<div class="bg-admin-card rounded-xl border border-admin-border">
    <div class="p-6 border-b border-admin-border flex items-center justify-between">
        <h3 class="text-white font-bold">All Channels <span class="text-gray-500 font-normal text-sm">({{ $channels->total() }})</span></h3>
        <a href="{{ route('admin.tv-channels.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-admin-accent hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Channel
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-admin-border">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Channel</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border">
                @forelse($channels as $i => $channel)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $channels->firstItem() + $i }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-netflix-dark overflow-hidden flex-shrink-0 border border-admin-border">
                                @if($channel->logo)
                                    <img src="{{ asset('storage/' . $channel->logo) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-lg bg-netflix-dark">📺</div>
                                @endif
                            </div>
                            <div>
                                <span class="text-white font-medium text-sm block">{{ $channel->name }}</span>
                                <span class="text-gray-500 text-[10px] uppercase tracking-wider">{{ Str::limit($channel->stream_url, 30) }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-white/10 text-gray-300 px-2 py-1 rounded inline-block">{{ $channel->category ?? 'General' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($channel->is_active)
                            <span class="text-green-400 text-[10px] font-bold px-2 py-1 bg-green-500/10 rounded-full border border-green-500/20">ACTIVE</span>
                        @else
                            <span class="text-red-400 text-[10px] font-bold px-2 py-1 bg-red-500/10 rounded-full border border-red-500/20">INACTIVE</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('admin.tv-channels.edit', $channel) }}" class="text-admin-accent hover:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.tv-channels.destroy', $channel) }}" method="POST" class="inline" onsubmit="return confirm('Delete this channel?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">No channels found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($channels->hasPages())
    <div class="p-6 border-t border-admin-border">
        {{ $channels->links() }}
    </div>
    @endif
</div>
@endsection
