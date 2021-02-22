@extends('layouts.app')

@section('content')
@php
$title= 'Главная страница | ';
$keywords = 'собаки, породы собаки, уход, кормление, воспитание щенка, взрослой собаки, подбор клички, дрессировка, обучение, питомец, выставка, болезни, лечение';
$description = 'my-dog.club - сайт о собаках, о породах собак, галерея питомцев, статьи про собак, кормление, содержание, дрессировка и лечение собак';
@endphp
<div class="row align-items-stretch order-sm-0 order-2">                
                 <div class="col-sm-12 col-lg-12 center-block">
                  <div class="homeText">
                   <h1>Добро пожаловать на сайт "Моя собака!"</h1>
                   <p>
                    Мы рады поприветствовать вас на страницах нашего информационного сайта и конечно же как вы уже поняли - это сайт о собаках!
                  </p>
                  <p>Мы уверенны, что наш сайт сможет Вам помочь с <a href="https://my-dog.club/breeds">выбором породы собаки</a>, ее дальнейшем правильном выращивании, уходе, кормлении, воспитании от щенка до взрослой собаки, а также подборе клички. Вы сможете самостоятельно освоить азы дрессировки, правильно подобрать амуницию как для обучения, так и для повседневной жизни вашего любимого питомца, узнать, как подготовить Вашего будущего чемпиона к первой выставке.</p>
                  <p>У нас на сайте, в <a href="https://my-dog.club/blog">блоге</a> вы сможете найти информацию о болезнях собак и лечении этих заболеваний, подготовке собаки к вязке и о том, как принять роды, узнать какие витамины, минералы необходимы вашему питомцу для нормального развития и как их правильно давать.</p> 
                    <p>С помощью калькулятора, сможете правильно рассчитать какое количество корма как сухого, так и натурального необходимо Вашей собаке потреблять в сутки в зависимости от породы и возраста.</p>
                    <p>Кроме всего перечисленного, Вы найдете много другой полезной и познавательной информации, сможете похвастаться своим питомцем добавив его фото в <a href="https://my-dog.club/gallery">галерею</a>, обсудить возникшие у Вас всевозможные вопросы и пообщаться с единомышленниками как в личном кабинете, так и на форуме.</p>
                    <p>На нашем сайте можно разместить бесплатное объявление о продаже или покупке собаки.</p>
                  </div>
                 </div>                      
                 <div class="col-sm-12 col-lg-4 center-block d-none">
                  <div class="homeText">
                   <h2>Приглашаем к сотрудничеству</h2>
                   <p>
                   На страницах нашего сайта вы можете абсолютно бесплатно разместить любые материалы не коммерческого содержания, соответствующие тематике сайта, анонсировать предстоящее событие такие как выставка, семинар и т.п., поделится с читателями сайта интересной новостью, информацией или опубликовать авторскую статью.</p>
                   <p>Для того чтобы задать любые вопросы администрации сайта, а также для размещения материалов на сайте обращайтесь по адресу <a href="mailto:{{ env('MAIL_USERNAME') }}">{{ env("MAIL_USERNAME") }}</a> постараемся ответить на Ваш вопрос или рассмотреть возможность размещения материалов в кратчайшие сроки.</p>
                  </div>
                 </div>
            </div>
        <hr>
        @if(isset($sideBlogs) && $sideBlogs->count()>0)
        <article class="order-1">
            <div class="row">
             <div class="col-sm-12 col-lg-4">
                 <img src="{{ $sideBlogs->toArray()[0]['url'] }}max.jpg" class="img-fluid mb-3" alt="{{ $sideBlogs->toArray()[0]['title'] }}" title="{{ $sideBlogs->toArray()[0]['title'] }}">                        
             </div>
             <div class="col-sm-12 col-lg-8 center-text">
                 <a href="{{ route('blogShow', ['alias' => $sideBlogs->toArray()[0]['alias']]) }}" title="{{ $sideBlogs->toArray()[0]['title'] }}"><h5>{{ $sideBlogs->toArray()[0]['title'] }}</h5></a>              
              <p>{!! str_limit($sideBlogs->toArray()[0]['text'],150) !!}</p>    
             </div>
             <div class="col-12 d-flex justify-content-between">
              <div class="d-inline-block small-comment">{{ date_create($sideBlogs->toArray()[0]['created_at'])->Format('d.m.Y') }}</div>
               <a href="{{ route('blogShow', ['alias' => $sideBlogs->toArray()[0]['alias']]) }}" class="text-more" title="Подробнее">Подробнее ></a>
             </div>                        
            </div><div class="lines"></div>            
          </article>  
     @endif
@if(isset($sideKeeping) && $sideKeeping->count()>0)
          <article class="order-1">
            <div class="row">
             <div class="col-sm-12 col-lg-4">
              <img data-src="{{ $sideKeeping->toArray()[0]['url']}}max.jpg" class="img-fluid mb-3" alt="*">             
             </div>
             <div class="col-sm-12 col-lg-8 center-text">
              <a href="{{ route('keepingShow', ['alias' => $sideKeeping->toArray()[0]['alias']]) }}" title="{{ $sideKeeping->toArray()[0]['title'] }}"><h5>{{ $sideKeeping->toArray()[0]['title'] }}</h5></a>              
              <p>{!! str_limit($sideKeeping->toArray()[0]['text'],150) !!}</p>        
             </div>
             <div class="col-12 d-flex justify-content-between">
              <div class="d-inline-block small-comment">{{ date_create($sideKeeping->toArray()[0]['created_at'])->Format('d.m.Y') }}</div>
               <a href="{{ route('keepingShow', ['alias' => $sideKeeping->toArray()[0]['alias']]) }}" class="text-more" title="Подробнее">Подробнее ></a>
             </div>                         
            </div><div class="lines"></div>
          </article>
        @endif   
        @if(isset($sideNews) && $sideNews->count()>0)     
          <article class="order-1">
            <div class="row">
             <div class="col-sm-12 col-lg-4">
              <img data-src="{{ $sideNews->toArray()[0]['url']}}max.jpg" class="img-fluid mb-3" alt="*">                    
             </div>
             <div class="col-sm-12 col-lg-8 center-text">
              <a href="{{ route('newsShow', ['alias' => $sideNews->toArray()[0]['alias']]) }}" title="{{ $sideNews->toArray()[0]['title'] }}"><h5>{{ $sideNews->toArray()[0]['title'] }}</h5></a>              
              <p>{!! str_limit($sideNews->toArray()[0]['text'],150) !!}</p>           
             </div>
             <div class="col-12 d-flex justify-content-between">
              <div class="d-inline-block small-comment">{{ date_create($sideNews->toArray()[0]['created_at'])->Format('d.m.Y') }}</div>
               <a href="{{ route('newsShow', ['alias' => $sideNews->toArray()[0]['alias']]) }}" class="text-more" title="Подробнее">Подробнее ></a>
             </div>                         
            </div><div class="lines"></div>
          </article>
        @endif
        @if(isset($sideDevelopments) && $sideDevelopments->count()>0)
          <article class="order-1">
            <div class="row">
             <div class="col-sm-12 col-lg-4">
              <img data-src="{{ $sideDevelopments->toArray()[0]['url']}}max.jpg" class="img-fluid mb-3" alt="*">             
             </div>
             <div class="col-sm-12 col-lg-8 center-text">
              <a href="{{ route('developmentsShow', ['alias' => $sideDevelopments->toArray()[0]['alias']]) }}" title="{{ $sideDevelopments->toArray()[0]['title'] }}"><h5>{{ $sideDevelopments->toArray()[0]['title'] }}</h5></a>              
              <p>{!! str_limit($sideDevelopments->toArray()[0]['text'],150) !!}</p>        
             </div>
             <div class="col-12 d-flex justify-content-between">
              <div class="d-inline-block small-comment">{{ date_create($sideDevelopments->toArray()[0]['created_at'])->Format('d.m.Y') }}</div>
               <a href="{{ route('developmentsShow', ['alias' => $sideDevelopments->toArray()[0]['alias']]) }}" class="text-more" title="Подробнее">Подробнее ></a>
             </div>                         
            </div><div class="lines"></div>
          </article>
        @endif
        
          
@endsection
