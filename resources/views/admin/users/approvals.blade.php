@extends('layouts.admin')

@section('title', 'User Approvals')
@section('page-title', 'User Approvals')

@section('content')
<div class="bg-admin-card rounded-xl border border-admin-border">
    <div class="p-6 border-b border-admin-border">
        <h3 class="text-white font-bold">Pending Adult Access Approvals</h3>
        <p class="text-xs text-gray-500 mt-1">Review KTP numbers and grant access to restricted content.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-admin-border">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">KTP Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Member Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Adult (21+) Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border">
                @forelse($users as $user)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-white font-medium text-sm">{{ $user->name }}</span>
                            <span class="text-[10px] text-gray-500">{{ $user->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <code class="bg-black/50 px-2 py-1 rounded text-gray-300 text-xs font-mono">{{ $user->ktp_number ?? 'N/A' }}</code>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_approved_member)
                            <span class="text-blue-400 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Active Member
                            </span>
                        @else
                            <span class="text-gray-500 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                Unapproved
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_approved_adult)
                            <span class="text-green-400 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                21+ Verified
                            </span>
                        @else
                            <span class="text-amber-400 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                No Access
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if(!$user->is_approved_member)
                                <form action="{{ route('admin.users.approve_member', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[10px] font-bold rounded uppercase transition-colors shadow-lg">
                                        Approve Member
                                    </button>
                                </form>
                            @endif

                            @if(!$user->is_approved_adult)
                                <form action="{{ route('admin.users.approve_adult', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-admin-accent hover:bg-red-600 text-white text-[10px] font-bold rounded uppercase transition-colors shadow-lg">
                                        Approve 21+
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.users.impersonate', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-[10px] font-bold rounded uppercase transition-colors shadow-lg flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                    Login As
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">No users to approve.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-admin-border">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
