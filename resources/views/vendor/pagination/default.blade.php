@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination-side" aria-hidden="true">
                        &lsaquo; <span>PREV</span>
                    </span>
                </li>
            @else
                <li>
                    <a class="pagination-side" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        &lsaquo; <span>PREV</span>
                    </a>
                </li>
            @endif

            {{-- "Three Dots" Separator --}}
            @if ($paginator->currentPage() > 3)
                <li class="disabled pagination-separator" aria-disabled="true">
                    <span>...</span>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element) && array_key_exists($paginator->currentPage(), $element))
                    @foreach ($element as $page => $url)
                        @if ($page < $paginator->currentPage()-2 || $page > $paginator->currentPage()+2)
                            @continue;
                        @endif

                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span class="pagination-number">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="pagination-number" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- "Three Dots" Separator --}}
            @if ($paginator->currentPage() < $paginator->lastPage()-2)
                <li class="disabled pagination-separator" aria-disabled="true">
                    <span>...</span>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="pagination-side" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span>NEXT</span> &rsaquo;
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination-side" aria-hidden="true">
                        <span>NEXT</span> &rsaquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
