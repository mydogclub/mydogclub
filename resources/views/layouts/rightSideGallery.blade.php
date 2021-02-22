@if(isset($sideGalleries) && count($sideGalleries) > 0)

<div class="row side-gallery">
            <div class="col-12">
                <p class="h2">галерея</p>
            </div>
            @foreach($sideGalleries as $k=>$item)
                  
                  <div class="col-6">
                    <a href="{{ route('galleryShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}">
                        <img data-src="{{ $item->url }}mini.jpg" class="img-fluid" alt="*">
                    </a>                       
                  </div>
            @endforeach
                  <div class="col-6 d-flex align-items-center">
                    <a href="/gallery" class="text-more" title="Подробнее">Подробнее ></a>            
                  </div>                            
</div>
@else
<p>Фотографий нет</p>
@endif