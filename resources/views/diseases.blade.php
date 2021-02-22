@extends('layouts.app')

@section('content')
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Главная</a></li>                       
                <li class="breadcrumb-item active" aria-current="page">Болезни собак</li>
              </ol>
            </nav>
            <h1>Болезни собак от А до Я с описанием и фотографиями</h1>
            <hr>
          <article>            
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                <ul class="nav nav-pills">
                <li class="nav-item"><a class="btn btn-info m-1 border border-dark" href="/diseases">Все</a> </li> 
                @foreach($letters as $item)
                <li class="nav-item"><a class="btn btn-info m-1 border border-dark" href="{{ route('diseasesLetter', ['letter' => $item->letter]) }}">{{ $item->letter}}</a> </li> 
                  @endforeach 
                </ul>
                </div>
                <div class="lines"></div>
                <div class="col-12 d-flex justify-content-start">
                <ul class="nav flex-column">
                @foreach($diseases as $item)
                <li class="nav-item"><a class="nav-link text-secondary" href="{{ route('diseasesShow', ['alias' => $item->alias]) }}"><h2 class="disText">{{ $item->title}}</h2></a> </li> 
                  @endforeach 
                </ul>
                </div>
            </div>            
          </article>        
@endsection
@php
$title= 'Болезни | ';
$keywords = 'Ключевые слова в болезнях';
$description = 'Болезни собак от А до Я с описанием и фотографиями';
@endphp