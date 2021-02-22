@if(isset($sideDevelopments) && count($sideDevelopments) > 0)
<div>
  <p class="block-title">события</p>                 
    <ul class="popular-blog">
      @foreach($sideDevelopments as $k=>$item) 
        <li><span class="chevron"></span><a href="{{ route('developmentsShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}">{{ str_limit($item->title,20) }}</a></li> 
      @endforeach       
   </ul>   
</div>
@else
<p>Событий нет</p>
@endif