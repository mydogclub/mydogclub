@extends('layouts.app')

@section('content')
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}">Главная</a></li>                       
                <li class="breadcrumb-item active" aria-current="page">Породы собак</li>
              </ol>
            </nav>
            <h1>Породы собак от А до Я с описанием и фотографиями</h1>
            <hr>
          <article>            
            <div class="row">
              <div class="breed">
                @foreach($letters as $item)
                    <div class="listBreed">            
                      <h2   data-count="0" data-letter='{{ $item->letter }}'><span class="listBreedOpen">+</span>
                         Породы собак на {{ $item->letter }}
                      </h2>
                      <div class="infoBreed">                                  
                                                          
                      </div>
                    </div>
                  @endforeach                    
                </div>           
            </div>            
          </article> 

          <form method="POST" action="/breeds" id="formListBreed">
            {{ csrf_field() }}
            <input type="hidden" name="letter" value="">
          </form>
         
@endsection
@php
$title= 'Породы | ';
$keywords = 'Ключевые слова в породах';
$description = 'Породы собак от А до Я с описанием и фотографиями';
@endphp