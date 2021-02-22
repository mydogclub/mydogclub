@extends('layouts.app')

@section('content')
<div>
@if(isset($developments))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/developments">События</a></li>                
                <li class="breadcrumb-item active" aria-current="page">{{ $developments->title }}</li>
              </ol>
            </nav>
            <h1>{{ $developments->title }}</h1>
            <hr>
            <article>
            <div class="row">
                <div class="col-sm-12 col-md-12 mh250">
                  <img id="main_img" src="{{ $developments->url }}path.jpg" class="img-fluid mb-4 w-100" alt="{{ $developments->title }}" title="{{ $developments->title }}">               
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">                
                 {!! $developments->text !!}<div class="lines"></div>            
              </div>                            
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">{{ $developments->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $developments->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
              </div>
              <div><span class="small-comment">
               Автор:<a href="{{ route('developmentsShowUser', ['user_id' => $developments->user->id]) }}" class="ml-1 mr-3">{{ $developments->user->name }}</a></span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $developments->user->name }}" onclick="showProfileUser({{ $developments->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>              
            </div>
          </article>
          @include('comments', ['source_id'=>$developments->id, 'type'=>'article', 'commentCount'=>$commentCount])
          <div class="btn-group btn-group-sm flex-wrap">
              @php
              $tags = explode(',',$developments->keywords);
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
$title = $developments->title.' | События | ';
$keywords = $developments->keywords;
$description = strip_tags(htmlspecialchars_decode($developments->description));
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
"headline": "{{ $developments -> title }}",
"name": "{{$developments -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $developments->created_at }}",
"dateModified": "{{ $developments->updated_at }}",
"image": [
"{{ $developments->url.'path.jpg' }}"
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