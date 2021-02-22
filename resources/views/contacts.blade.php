@extends('layouts.app')

@section('content')
@php
$title= 'Контакты | ';
$keywords = '';
$description = 'my-dog.club - контакты';
@endphp
<div class="row align-items-stretch">
    @if(count($errors) > 0)                    
                      <div class="col-12 alert alert-danger">
                        <ul>
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
    @endif
    @if(session('goodMsg'))
                 <div class="col-12 alert alert-success text-center">
                        {{ session('goodMsg') }}
                </div>   
    @endif
                 <div class="col-sm-12 col-lg-10 offset-lg-1 center-block">
                  <div class="homeText">
                   <h2>Приглашаем к сотрудничеству</h2>
                   <p>
                   На страницах нашего сайта вы можете абсолютно бесплатно разместить любые материалы не коммерческого содержания, соответствующие тематике сайта, анонсировать предстоящее событие такие как выставка, семинар и т.п., поделится с читателями сайта интересной новостью, информацией или опубликовать авторскую статью.</p>
                   <p>Для того чтобы задать любые вопросы администрации сайта, а также для размещения материалов на сайте обращайтесь по адресу <a href="mailto:{{ env('MAIL_USERNAME') }}">{{ env("MAIL_USERNAME") }}</a> постараемся ответить на Ваш вопрос или рассмотреть возможность размещения материалов в кратчайшие сроки.</p>
                  </div>
                 </div>
            </div>
        <hr>
<div class="row align-items-stretch">    
                 <div class="col-sm-12 col-lg-10 offset-lg-1 center-block">                     
                  <div class="homeText">
                   <h2>Отправить сообщение</h2>
                    <form action="/sendmsg" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Email address</label>
                          <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email">
                        </div>
                        <div class="form-group">
                          <label for="text1">Тема</label>
                          <input type="text" class="form-control" id="text1" name="title">
                        </div>                        
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">Сообщение</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="msg" maxlength="500"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100">Отправить</button>
                        </div>
                      </form>
                  </div>
                 </div>
            </div>
       
          
@endsection
