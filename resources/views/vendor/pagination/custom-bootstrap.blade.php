@if ($paginator->hasPages())
    <div class="d-flex flex-column align-items-center justify-content-center gap-2 mt-4">

        {{-- تعريب النص العلوي --}}
        <div>
            عرض من {{ $paginator->firstItem() }} إلى {{ $paginator->lastItem() }}
            من أصل {{ $paginator->total() }} {{ $paginator->total() == 1 ? 'نتيجة' : 'نتائج' }}
        </div>

        {{-- روابط الصفحات --}}
        <nav>
            <ul class="pagination">
                {{-- السابق --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">‹ السابق</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ السابق</a>
                    </li>
                @endif

                {{-- أرقام الصفحات --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @php
                                $current = $paginator->currentPage();
                            @endphp

                            @if ($page >= $current - 1 && $page <= $current + 1)
                                @if ($page == $current)
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endif
                        @endforeach
                    @endif

                @endforeach

                {{-- التالي --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي ›</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">التالي ›</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
