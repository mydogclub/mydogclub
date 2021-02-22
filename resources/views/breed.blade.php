@extends('layouts.app')

@section('content')
<div>
@if(isset($breeds))
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/breeds">Породы</a></li>                               
              </ol>
            </nav>
            <h1>Породы собак</h1>
            <hr>
            <article>
            @foreach($breeds as $item)
                <div class="row mb-2">
                    <div class="col-12 col-md-3">
                        <img src="{{ $item->url }}max.jpg" class="img-fluid" alt="*">
                    </div>
                    <div class="col-12 col-md-9 d-flex align-items-end"><a href="/breeds/{{ $item->alias }}"><h3>{{ $item->title }}</h3></a>
                     </div>                             
                </div>
            @endforeach
            <nav aria-label="Page navigation example" id="Pagination">
                {{ $breeds->links('layouts.paginate') }}
                </nav>

          </article>
                 
 @else
  <div class="alert alert-danger">
    Извините, но страница, которую вы ищете, не существует.<br>
Вы можете вернуться на <a href="/home">домашнюю страницу</a>
  </div> 
  @endif                
    </div>

@endsection

@php
$title = ' Породы | ';
$description = 'Описание пород собак';
@endphp