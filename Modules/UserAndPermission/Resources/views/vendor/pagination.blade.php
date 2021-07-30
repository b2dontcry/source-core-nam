@php
    $listOption = [10, 20, 30, 50, 100, ];
    $selected = (isset($_GET['per_page'])) ? $_GET['per_page'] : 10;
@endphp
<div class="row">
    <div class="col-md-4 col-12">
        <select name="per_page" id="per_page" class="pn-item-per-page">
            @foreach ($listOption as $option)
                <option value="{{ $option }}" {{ $option == $selected ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
        <span>
            @lang('message.show_items_per_page', [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total()
            ])
        </span>
    </div>
    <div class="col-md-8 col-12">
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
                            <a class="page-link" href="{{ $paginator->url(1) }}" tabindex="-1">
                                <i class="fas fa-angle-double-left"></i>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
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
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                                <i class="fas fa-angle-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
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
<script type="text/javascript">
    let selectPerPage = document.getElementById('per_page');
    selectPerPage.addEventListener('change', function () {
        document.getElementById('form-filter').submit();
    })
</script>
