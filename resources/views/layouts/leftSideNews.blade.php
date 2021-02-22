@if(isset($sideNews) && count($sideNews) > 0)
<div>
  <p class="block-title">новости</p>
  @foreach($sideNews as $k=>$item)
    <div class="news">
        <div class="news-img">
          <img data-src="{{ $item->url }}mini.jpg" class="img-fluid" alt="*">
        </div>
        <div class="news-title">
          <a href="{{ route('newsShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}">{{ str_limit($item->title,20) }}</a>  
       </div>
    </div>
  @endforeach               
 </div>
 @else
<p>Новостей нет</p>
 @endif