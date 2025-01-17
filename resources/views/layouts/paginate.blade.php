@if ($paginator->hasPages())
<ul class="pagination justify-content-center">
        @if ($paginator->onFirstPage())
            
<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true"><span aria-hidden="true">&laquo;</span> Назад</a></li>

        @else
            
<li class="page-item" title="Назад"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span aria-hidden="true">&laquo;</span> Назад</a></li>

        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                
<li class="page-item disabled"><span>{{ $element }}</span></li>

            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        
<li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>

                    @else
                        
<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>

                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            
<li class="page-item" title="Вперед"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Вперед <span aria-hidden="true">&raquo;</span></a></li>

        @else
            
<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Вперед <span aria-hidden="true">&raquo;</span></a></li>

        @endif
    </ul>

@endif