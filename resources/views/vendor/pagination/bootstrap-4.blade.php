@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item page-arrow">
                <span class="page-link disabled arrow">&lsaquo;</span></li>
        @else
            <li class="page-item page-arrow">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link arrow">&lsaquo;</a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item">
                <a href="{{ $paginator->url(1) }}" class="page-link">1</a>
            </li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item">
                <span class="page-link disabled">...</span>
            </li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item">
                <span class="page-link disabled">...</span>
            </li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item">
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item page-arrow">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link arrow">&rsaquo;</a>
            </li>
        @else
            <li class="page-item page-arrow">
                <span class="page-link arrow">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
