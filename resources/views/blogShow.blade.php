@extends('layouts.app')

@section('content')
<div>
@if(isset($blog))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/blog">Блог</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>                
              </ol>
            </nav>
            <h1>{{ $blog->title }}</h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $blog->url }}path.jpg" class="img-fluid mb-4 w-100" alt="{{ $blog->title }}" title="{{ $blog->title }}">        
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">
                <!--<h3 class="mb-3">{{ $blog->title }}</h3>-->
                 {!! $blog->text !!}<div class="lines"></div>            
              </div>              
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">{{ $blog->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $blog->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
              </div>
              <div><span class="small-comment">
               Автор:<a href="{{ route('blogShowUser', ['user_id' => $blog->user->id]) }}" class="ml-1 mr-3">{{ $blog->user->name }}</a></span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $blog->user->name }}" onclick="showProfileUser({{ $blog->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>             
            </div>            
          </article>
          @include('comments', ['source_id'=>$blog->id, 'type'=>'article', 'commentCount'=>$commentCount])
          <div class="btn-group btn-group-sm flex-wrap">
              @php
              $tags = explode(',',$blog->keywords);
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
$title = $blog->title.' | Блог | ';
$keywords = $blog->keywords;
$description = strip_tags(htmlspecialchars_decode($blog->description));
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
"headline": "{{ $blog -> title }}",
"name": "{{$blog -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $blog->created_at }}",
"dateModified": "{{ $blog->updated_at }}",
"image": [
"{{ $blog->url.'path.jpg' }}"
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