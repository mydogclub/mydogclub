@extends('layouts.app')

@section('content')
<div>
<nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Главная</a></li>
                <li class="breadcrumb-item"><a href="/dogs">Навигация по разделу</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>                
              </ol>
            </nav>
            <h1 class="disText">Навигация по разделу "Собаки"</h1>
            <hr>
            <article>
            <div class="row">
                <h2 class="disText w-100">Породы собак</h2>
                <ul class="nav flex-column">
                @php
                $i=1;
                @endphp
                @foreach($breeds as $item)                
                <li><a class="text-secondary" href="{{ route('breedsShow', ['alias' => $item->alias]) }}"><h3 class="disText">{{ $i++ }}. {{ $item->title}}</h3></a> </li> 
                @endforeach
                </ul>
            </div>
                    <div class="lines"></div>
            <div class="row">
                <h2 class="disText w-100">Болезни собак</h2>
                <ul class="nav flex-column">
                @php
                $i=1;
                @endphp
                @foreach($diseases as $item)                
                <li><a class="text-secondary" href="{{ route('diseasesShow', ['alias' => $item->alias]) }}"><h3 class="disText">{{ $i++ }}. {{ $item->title}}</h3></a> </li> 
                @endforeach
                </ul>
            </div>  
          </article>           
    </div>    
@endsection

@php
$title = 'Навигация по разделу "Собаки" | ';
$keywords = 'Породы собак, болезни собак';
$description = 'Список порд собак по алфавиту, список болезней собак';
@endphp