@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Главная</a></li>
                @if(isset($showUser))
                <li class="breadcrumb-item active" aria-current="page">{{ $showUser['name'] }}</li>
                @else
                @if(isset($showTitle))
                <li class="breadcrumb-item active" aria-current="page">{{ $showTitle }}</li>
                @else
                @if(count($gallery) == 0)
                @else                              
                <li class="breadcrumb-item active" aria-current="page">Галерея</li>
                @endif
                @endif
                @endif
              </ol>
            </nav>
            <h1>Галерея</h1>
            <hr>
                <div class="row">
                  @if(count($gallery) == 0)
                  <div class="col-12 alert alert-danger">
                    <p>Фотографий нет</p>
                  </div>
                  @endif
                  @foreach($gallery as $item)
                    <div class="col-12 col-sm-6 col-md-4 overflow-hidden">
                      <a href="{{ route('galleryShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}">
                        <img src="{{ $item->url }}max.jpg" class="img-fluid mb-4 w-100 gallery-img" alt="{{ $item->title }}">
                      </a>
                    </div>
                   @endforeach                          
                </div>
                <nav aria-label="Page navigation example" id="Pagination">
                {{ $gallery->links('layouts.paginate') }}
                </nav>
                @guest
                <p class="text-right small text-info">Чтобы добавить Ваши фото в галерею, зарегкстрируйтесь !!!</p>
                @endguest
                @if(Auth::check())
                <div class="text-right">
                <button class="btn btn-warning" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2"><span class="small">Добавить фото</span></button>
                </div>
                <div class="collapse multi-collapse <?php if (count($errors) > 0) echo 'show';?>" id="multiCollapseExample2">
                <form id="upload" action="gallery/upload" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">        
                   <div class="row form_upload">
                    @if (count($errors) > 0)                    
                      <div class="col-12 alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                     <div class="col-12 col-sm-6 text-center">
                      <h6>Выберите изображение <span class="small">(Максимальный размер 10Мб)</span></h6>
                       <label class=newbtn>
                        <img id="blah" src="{{ asset('image/placeholder.png') }}" >
                        <input id="pic" class='pis' onchange="readURL(this);" type="file" name="image" accept="image/*">
                       </label>
                     </div>
                     <div class="col-12 col-sm-6">                    
                      <h6>Заголовок</h6>                       
                        <input type="text" name="title" class="form-control"><br>                
                      <h6>Описание</h6>                       
                        <textarea name="text" rows="5" class="form-control"></textarea>          
                     </div>
                     <div class="col-12 text-right">
                      <button class="btn btn-success">Загрузить                        
                      </button>                       
                     </div>
                  </div>
                </form>
                 @if (count($errors) > 0)
                    <script>
                      var upload = document.getElementById('upload');
                      upload.scrollIntoView();
                    </script>
                 @endif
              </div>
                @endif                 
@endsection


@php
$title = ' Галерея | ';
$keywords = 'собачьи фотографии, фото, собаки, собачьи, галереи, фотогалереи, породы, питомники, лучшие, ярлыки';
$description = 'Фото-галереи собак по питомникам, породам и ярлыкам, лучшие собачьи фотографии, страница № '.$gallery->currentPage();
@endphp

