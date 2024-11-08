@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <!-- Info Halaman -->
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center">
            <p class="small text-muted mb-0">
                {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
            </p>
        </div>

        <!-- Pagination Links -->
        <ul class="pagination pagination-sm mb-0">
            <!-- First Page -->
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link border-0" href="{{ $paginator->url(1) }}" aria-label="First">
                    <i class="bi bi-chevron-double-left"></i>
                </a>
            </li>

            <!-- Previous Page -->
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link border-0" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <!-- Page Numbers -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link border-0">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link border-0" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            <!-- Next Page -->
            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link border-0" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>

            <!-- Last Page -->
            <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link border-0" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last">
                    <i class="bi bi-chevron-double-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif

<style>
/* Pagination Container */
.pagination {
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: transparent;
    --bs-pagination-hover-color: #0d6efd;
    --bs-pagination-hover-bg: #e9ecef;
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-disabled-color: #adb5bd;
    gap: 4px;
}

/* Page Link */
.page-link {
    min-width: 30px;
    height: 30px;
    padding: 0 !important;
    border-radius: 4px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8125rem;
    transition: all 0.15s ease-in-out;
}

/* Icon Size */
.page-link i {
    font-size: 0.75rem;
}

/* Active State */
.page-item.active .page-link {
    font-weight: 500;
}

/* Disabled State */
.page-item.disabled .page-link {
    background: transparent;
    opacity: 0.5;
}

/* Hover Effects */
.page-link:hover:not(.disabled) {
    transform: translateY(-1px);
}

/* Mobile Responsive */
@media (max-width: 575.98px) {
    .page-link {
        min-width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }

    .page-link i {
        font-size: 0.7rem;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .pagination {
        --bs-pagination-color: #dee2e6;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-hover-bg: rgba(255,255,255,0.1);
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-disabled-color: #6c757d;
    }
}
</style>
