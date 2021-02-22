@extends('layouts.app')

@section('content')
<div>
@if(isset($diseases))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/diseases">Болезни</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $diseases->title }}</li>                
              </ol>
            </nav>
            <h1>{{ $diseases->title }}</h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $diseases->url }}max.jpg" class="img-fluid mb-4 w-100" alt="{{ $diseases->title }}" title="{{ $diseases->title }}">         
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">
                
                 {!! $diseases->text !!}<div class="lines"></div>            
              </div>             
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">
                @can('Admin')
                {{ $diseases->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $diseases->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
                @endcan
              </div>

              <div><span class="small-comment">
               Автор: {{ $diseases->user->name }}</span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $diseases->user->name }}" onclick="showProfileUser({{ $diseases->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>             
            </div>            
          </article>
          @include('comments', ['source_id'=>$diseases->id, 'type'=>'disease', 'commentCount'=>$commentCount])          
 @else
  <div class="alert alert-danger">
    Извините, но страница, которую вы ищете, не существует.<br>
Вы можете вернуться на <a href="/home">домашнюю страницу</a>
  </div> 
  @endif                
    </div>    
@endsection

@php
$title = $diseases->title.' | Болезни собак | ';
$keywords = $diseases->keywords;
$description = strip_tags(htmlspecialchars_decode($diseases->description));
@endphp

@section('schema')
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "NewsArticle",
"mainEntityOfPage": {
"@type": "WebPage",
"@id": "{{ Request::url() }}"
},
"headline": "{{ $diseases -> title }}",
"name": "{{$diseases -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $diseases->created_at }}",
"dateModified": "{{ $diseases->updated_at }}",
"image": [
"{{ $diseases->url.'max.jpg' }}"
],
"author": {
"@type": "Person",
"name": "Admin"
},
"publisher": {
"@type": "Organization",
"name": "My-dog club",
"logo": {
"@type": "ImageObject",
"url": "https://my-dog.club/image/logo.png"
}
}
}
</script>
@endsection