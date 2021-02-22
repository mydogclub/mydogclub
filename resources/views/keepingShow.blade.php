@extends('layouts.app')

@section('content')
<div>
@if(isset($keeping))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/keeping">Содержание собак</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $keeping->title }}</li>                
              </ol>
            </nav>
            <h1>{{ $keeping->title }}</h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $keeping->url }}max.jpg" class="img-fluid mb-4 w-100" alt="{{ $keeping->title }}" title="{{ $keeping->title }}">         
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">
                
                 {!! $keeping->text !!}<div class="lines"></div>            
              </div>             
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">
                @can('Admin')
                {{ $keeping->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $keeping->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
                @endcan
              </div>

              <div><span class="small-comment">
               Автор: {{ $keeping->user->name }}</span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $keeping->user->name }}" onclick="showProfileUser({{ $keeping->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>             
            </div>            
          </article>
          @include('comments', ['source_id'=>$keeping->id, 'type'=>'keeping', 'commentCount'=>$commentCount])
          <div class="btn-group btn-group-sm flex-wrap">
              @php
              $tags = explode(',',$keeping->keywords);
              @endphp
              @foreach($tags as $val)
              <a href="{{ route('keepingShowTag', ['tag' => trim($val)]) }}" class="btn btn-secondary m-1 rounded">{{ $val }}</a>
              
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
$title = $keeping->title.' | Содержание собак | ';
$keywords = $keeping->keywords;
$description = strip_tags(htmlspecialchars_decode($keeping->description));
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
"headline": "{{ $keeping -> title }}",
"name": "{{$keeping -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $keeping->created_at }}",
"dateModified": "{{ $keeping->updated_at }}",
"image": [
"{{ $keeping->url.'max.jpg' }}"
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