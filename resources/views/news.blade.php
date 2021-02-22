@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Главная</a></li>
                @if(isset($showUser))
                <li class="breadcrumb-item active" aria-current="page">{{ $showUser['name'] }}</li>
                @else
                @if(count($news) == 0)
                @else                              
                <li class="breadcrumb-item active" aria-current="page">Новости</li>
                @endif
                @endif         
              </ol>
            </nav>
            <h1>Новости</h1>
            <hr>
          <article>
            <div class="row">
               @if(count($news) == 0)
                  <div class="col-12 alert alert-danger">
                    <p>Новостей нет</p>
                  </div>
                  @endif
              @foreach($news as $item)
              <div class="col-12 col-md-4">
                  <img src="{{ $item->url }}max.jpg" class="img-fluid mb-4" alt="{{ $item->title }}" title="{{ $item->title }}">                        
             </div>
             <div class="col-12 col-md-8 center-text">
                 <a href="{{ route('newsShow', ['alias' => $item->alias]) }}" title="{{ $item->title }}"><h5>{{ $item->title }}</h5></a>
               {!! str_limit($item->description,200) !!}    
             </div>
              <div class="col-12 d-flex flex-column flex-lg-row justify-content-between">
               <div class="d-inline-block small">{{ $item->created_at->format('d.m.Y') }} | 
                <i class="fas fa-eye"></i> {{ $item->counter }} | 
                <i class="far fa-comment-dots"></i> {{ $item->comments }}
               </div>
               <div>
               <a href="{{ route('newsShow', ['alias' => $item->alias]) }}" class="text-more" title="Подробнее">Подробнее ></a>
              </div>
             </div><div class="lines"></div>                          
              @endforeach              
            </div>
          </article>
          <nav aria-label="Page navigation example" id="Pagination">
                {{ $news->links('layouts.paginate') }}
          </nav>
@endsection

@php
$title = ' Новости | ';
$keywords = '';
$description = 'Новости страница № '.$news->currentPage();
@endphp
          