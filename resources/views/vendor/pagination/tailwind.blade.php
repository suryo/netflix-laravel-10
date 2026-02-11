@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm text-gray-600 bg-white/5 rounded-lg cursor-not-allowed">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-300 bg-white/10 rounded-lg hover:bg-white/20 transition-colors">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 text-sm text-white bg-[#E50914] rounded-lg font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-300 bg-white/10 rounded-lg hover:bg-white/20 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-300 bg-white/10 rounded-lg hover:bg-white/20 transition-colors">
                &raquo;
            </a>
        @else
            <span class="px-3 py-2 text-sm text-gray-600 bg-white/5 rounded-lg cursor-not-allowed">
                &raquo;
            </span>
        @endif
    </nav>
@endif
