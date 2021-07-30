<div class="row">
    <div class="col-12">
        @if ($paginator->hasPages())
            <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fas fa-angle-double-left"></i>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fas fa-angle-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                <i class="fas fa-angle-double-left"></i>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                <i class="fas fa-angle-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled">
                                <span class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">
                                <i class="fas fa-angle-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)">
                                <i class="fas fa-angle-double-right"></i>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-angle-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-angle-double-right"></i>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
</div>

