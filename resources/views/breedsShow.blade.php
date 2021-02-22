@extends('layouts.app')

@section('content')
<div>
@if(isset($breeds))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/breeds">Породы</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $breeds->title }}</li>                
              </ol>
            </nav>
            <h1>{{ $breeds->title }}</h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $breeds->url }}max.jpg" class="img-fluid mb-4 w-100" alt="{{ $breeds->title }}" title="{{ $breeds->title }}">         
              </div>
              <div class="col-sm-12 col-lg-12 blog-text">
                
                 {!! $breeds->text !!}<div class="lines"></div>            
              </div>             
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">
                @can('Admin')
                {{ $breeds->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $breeds->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
                @endcan
              </div>

              <div><span class="small-comment">
               Автор: {{ $breeds->user->name }}</span>               
              </div>
              <a href="#" title="Профиль пользователя {{ $breeds->user->name }}" onclick="showProfileUser({{ $breeds->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>             
            </div>            
          </article>
          @include('comments', ['source_id'=>$breeds->id, 'type'=>'breed', 'commentCount'=>$commentCount])
           <div class="btn-group btn-group-sm flex-wrap">
              @php
              $tags = explode(',',$breeds->keywords);
              @endphp
              @foreach($tags as $val)
              <a href="{{ route('breedsShowTag', ['tag' => trim($val)]) }}" class="btn btn-secondary m-1 rounded">{{ $val }}</a>
              
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
$title = $breeds->title.' | Породы собак | ';
$keywords = $breeds->keywords;
$description = strip_tags(htmlspecialchars_decode($breeds->description));
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
"headline": "{{ $breeds -> title }}",
"name": "{{$breeds -> title}}",
"description": "{{$description}}",
"datePublished": "{{ $breeds->created_at }}",
"dateModified": "{{ $breeds->updated_at }}",
"image": [
"{{ $breeds->url.'max.jpg' }}"
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