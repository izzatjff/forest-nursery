@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-nav">
        <p class="pagination-info">
            Showing
            <span>{{ $paginator->firstItem() }}</span>
            to
            <span>{{ $paginator->lastItem() }}</span>
            of
            <span>{{ $paginator->total() }}</span>
            results
        </p>

        <ul class="pagination-links">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="pagination-btn pagination-disabled" aria-disabled="true" aria-label="Previous">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev" aria-label="Previous">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="pagination-btn pagination-ellipsis">&hellip;</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="pagination-btn pagination-active" aria-current="page">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next" aria-label="Next">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="pagination-btn pagination-disabled" aria-disabled="true" aria-label="Next">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
