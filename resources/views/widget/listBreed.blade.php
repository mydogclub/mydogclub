@foreach($breeds as $item)
<div class="row mb-2">
    <div class="col-12 col-md-3">
        <img src="{{ $item->url }}max.jpg" class="img-fluid" alt="*">
    </div>
    <div class="col-12 col-md-9 d-flex align-items-end"><a href="/breeds/{{ $item->alias }}"><h3>{{ $item->title }}</h3></a>
     </div>                             
</div>
@endforeach