@extends('layouts.app')

@section('content')
<div>
@if(isset($news))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/news">Новости</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $news->title }}</li>                
              </ol>
            </nav>
            <h1>{{ $news->title }}</h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $news->url }}path.jpg" class="img-fluid mb-4 w-100" alt="{{ $news->title }}" title="{{ $news->title }}">          
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">
                <!--<h5 class="mb-3">{{ $news->title }}</h5>-->
                 {!! $news->text !!}<div class="lines"></div>            
              </div>              
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">{{ $news->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $news->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
              </div>
              <div><span class="small-comment">
               Автор:<a href="{{ route('newsShowUser', ['user_id' => $news->user_id]) }}" class="ml-1 mr-3">{{ $news->user->name }}</a></span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $news->user->name }}" onclick="showProfileUser({{ $news->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>              
            </div>
          </article>
          @include('comments', ['source_id'=>$news->id, 'type'=>'article', 'commentCount'=>$commentCount])
          <div class="btn-group btn-group-sm flex-wrap">
              @php
              $tags = explode(',',$news->keywords);
              @endphp
              @foreach($tags as $val)
              <a href="{{ route('homeShowTag', ['tag' => trim($val)]) }}" class="btn btn-secondary m-1 rounded">{{ $val }}</a>
              
              @endforeach
              
          </div>  
 @else
  <div class="alert alert-danger">
    Извините, но страница, которую вы ищете, не существует.<br>
Вы можете вернуться на <a href="/home">домашнюю страницу</a>
  </div> 
  @endif                
    </div>

@endsection

@php
$title = $news->title.' | Новости | ';
$keywords = $news->keywords;
$description = strip_tags(htmlspecialchars_decode($news->description));
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
"headline": "{{ $news -> title }}",
"name": "{{$news -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $news->created_at }}",
"dateModified": "{{ $news->updated_at }}",
"image": [
"{{ $news->url.'path.jpg' }}"
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