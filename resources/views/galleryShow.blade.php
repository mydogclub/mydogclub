@extends('layouts.app')

@section('content')
<div class="gallery-view">
  @if(isset($gallery))
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/gallery">Галерея</a></li>            
                <li class="breadcrumb-item active" aria-current="page">{{ $gallery->title }}</li>                
              </ol>
            </nav>
             <h1><a href="{{ route('galleryShowTitle', ['title' => substr($gallery->alias,0,strrpos($gallery->alias,'_'))]) }}">{{ $gallery->title }}</a></h1>
            <hr>
            <article>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                  <img id="main_img" src="{{ $gallery->url }}path.jpg" class="img-fluid mb-4 w-100" alt="{{ $gallery->title }}" title="{{ $gallery->title }}">                
              </div>
              <div class="col-sm-12 col-md-12 mb-4">
                {!! $gallery->text !!}<div class="lines"></div>                
              </div>                           
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">{{ $gallery->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $gallery->counter }} | 
                <i class="far fa-comment-dots"></i> <span id="commentCountShow">{{ $commentCount }}</span>
              </div>
              <div><span class="small-comment">
               Автор:<a href="{{ route('galleryShowUser', ['user_id' => $gallery->user_id]) }}" class="ml-1 mr-3">{{ $gallery->user->name }}</a></span>              
              </div>
              <a href="#" title="Профиль пользователя {{ $gallery->user->name }}" onclick="showProfileUser({{ $gallery->user->id }});return false;"><i class="far fa-id-card"></i></a>
             </div>              
            </div>           
          </article>
          @include('comments', ['source_id'=>$gallery->id, 'type'=>'gallery', 'commentCount'=>$commentCount])
  @else
  <div class="alert alert-danger">
    Извините, но страница, которую вы ищете, не существует.<br>
Вы можете вернуться на <a href="/home">домашнюю страницу</a>
  </div> 
  @endif                
    </div>
@endsection

@php
$title = $gallery->title.' | Галерея | ';
$keywords = $gallery->keywords;
$description = strip_tags(htmlspecialchars_decode($gallery->text));
@endphp