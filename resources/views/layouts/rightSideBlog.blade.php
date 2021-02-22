@if(isset($sideBlogs) && count($sideBlogs) > 0)
<div class="side-blog">
               <p class="block-title">популярное в блоге</p>
               @foreach($sideBlogs as $k=>$item)               
                <div class="popular">
                  <div class="popular-img">
                    <img data-src="{{ $item->url }}mini.jpg" class="img-fluid" alt="{{ $item->title }}" title="{{ $item->title }}">
                  </div>               
                  <div class="popular-title">
                    <a href="{{ route('blogShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}">{{ str_limit($item->title,20) }}</a>  
                  </div>
                </div>
                @endforeach                
</div>
@else
<p>Статей нет</p>
@endif