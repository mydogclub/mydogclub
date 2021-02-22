@extends('layouts.app')

@section('content')
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Главная</a></li>
                @if(isset($showUser))
                <li class="breadcrumb-item active" aria-current="page">{{ $showUser['name'] }}</li>
                @else
                @if(count($blog) == 0)
                @else                              
                <li class="breadcrumb-item active" aria-current="page">Блог</li>
                @endif
                @endif         
              </ol>
            </nav>
            <h1>Блог</h1>
            <hr>
          <article>
            <div class="row">
              @if(count($blog) == 0)
                  <div class="col-12 alert alert-danger">
                    <p>Статей нет</p>
                  </div>
                  @endif
            	@foreach($blog as $item)
                <div class="col-12 col-md-4">                
                  <img src="{{ $item->url }}max.jpg" class="img-fluid mb-4" alt="{{ $item->title }}" title="{{ $item->title }}">                               
              </div>
              <div class="col-12 col-md-8 blog-text">
                  <a href="{{ route('blogShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}"><h5>{{ $item->title }}</h5></a>                  
                 {!! str_limit($item->description,200) !!}          
              </div>
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
              <div class="d-inline-block small">{{ $item->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $item->counter }} | 
                <i class="far fa-comment-dots"></i> {{ $item->comments }}
              </div>
              <div><span class="small-comment">
               Автор:<a href="{{ route('blogShowUser', ['user_id' => $item->user->id]) }}" class="ml-1 mr-1" title="Все статьи пользователя {{ $item->user->name }}">{{ $item->user->name }}</a></span>
               <a href="#" title="Профиль пользователя {{ $item->user->name }}" onclick="showProfileUser({{ $item->user->id }});return false;"><i class="far fa-id-card"></i></a>
               <a href="{{ route('blogShow', ['alias' => $item->alias]) }}" class="text-more ml-3" title="Подробнее">Подробнее <i class="fas fa-angle-double-right"></i></a>
              </div>
             </div><div class="lines"></div>            
              @endforeach
            </div>
          </article>
           
                <nav aria-label="Page navigation example" id="Pagination">
                {{ $blog->links('layouts.paginate') }}
                </nav> 

@endsection
@php
$title= 'Блог | ';
$keywords = '';
$description = 'Блог страница № '.$blog->currentPage();
@endphp