@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-[#8C8275] bg-[#FAF8F2] border border-[#EAE5D9] cursor-default rounded-xl">
                    &laquo; ก่อนหน้า
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-[#2C3E2D] bg-white border border-[#D5CEBC] rounded-xl hover:bg-[#FAF8F2] transition">
                    &laquo; ก่อนหน้า
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-[#2C3E2D] bg-white border border-[#D5CEBC] rounded-xl hover:bg-[#FAF8F2] transition">
                    ถัดไป &raquo;
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-[#8C8275] bg-[#FAF8F2] border border-[#EAE5D9] cursor-default rounded-xl">
                    ถัดไป &raquo;
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-[#6B6357] font-mono">
                    แสดงรายการที่
                    <span class="font-bold text-[#2C3E2D]">{{ $paginator->firstItem() ?? 0 }}</span>
                    ถึง
                    <span class="font-bold text-[#2C3E2D]">{{ $paginator->lastItem() ?? 0 }}</span>
                    จากทั้งหมด
                    <span class="font-bold text-[#5A6B47]">{{ number_format($paginator->total()) }}</span>
                    รายการ
                    @if (request('per_page') === 'all')
                        <span class="text-[#7B8D65]">(แสดงทั้งหมด)</span>
                    @else
                        <span class="text-[#7B8D65]">({{ $paginator->perPage() }} รายการ/หน้า)</span>
                    @endif
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-xl shadow-sm space-x-1">
                    
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="ก่อนหน้า">
                            <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#8C8275] bg-[#FAF8F2] border border-[#EAE5D9] cursor-not-allowed rounded-lg" aria-hidden="true">
                                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#2C3E2D] bg-white border border-[#D5CEBC] rounded-lg hover:bg-[#FAF8F2] hover:text-[#5A6B47] transition shadow-xs" aria-label="ก่อนหน้า">
                            <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#8C8275] bg-transparent border-0 cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-[#5A6B47] border border-[#5A6B47] rounded-lg shadow-sm font-mono">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#4A3B32] bg-white border border-[#D5CEBC] rounded-lg hover:bg-[#FAF8F2] hover:text-[#5A6B47] transition font-mono" aria-label="ไปที่หน้า {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#2C3E2D] bg-white border border-[#D5CEBC] rounded-lg hover:bg-[#FAF8F2] hover:text-[#5A6B47] transition shadow-xs" aria-label="ถัดไป">
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="ถัดไป">
                            <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#8C8275] bg-[#FAF8F2] border border-[#EAE5D9] cursor-not-allowed rounded-lg" aria-hidden="true">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
