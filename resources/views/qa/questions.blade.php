@extends('qa.app')

@section('content')
   <div class="center-block-qa">
       <div class="d-flex justify-content-end"><a href="#ask" class="position-relative btn btn-success p-1">Задать<br>вопрос</a></div>
                <h1 class="text-center">Хочу спросить</h1>
                <h2 class="text-center">Вопросы пользователей, раздел - <span class="text-success">{{ ($cat==0)?'Все категории':$category[$cat-1]->name }}</span></h2>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                        <a class="btn btn-link {{ ($page=='all'||$page=='')?'active':'' }}" href="{{Request::fullUrlWithQuery(['page' => ''])}}">Все вопросы</a>
                        </li>
                        <li class="nav-item">
                        <a class="btn btn-link {{ ($page=='with_answers')?'active':'' }}" href="{{Request::fullUrlWithQuery(['page' => 'with_answers'])}}">С ответом</a>
                        </li>
                        <li class="nav-item">
                        <a class="btn btn-link {{ ($page=='no_answers')?'active':'' }}" href="{{Request::fullUrlWithQuery(['page' => 'no_answers'])}}">Без ответа</a>
                        </li>
                        <li class="nav-item">
                        <a class="btn btn-link {{ ($page=='popular')?'active':'' }}" href="{{Request::fullUrlWithQuery(['page' => 'popular'])}}">Популярные</a>
                        </li>                        
                   </ul>
  </div>
<div class="center-block-qa">
    @if(count($questions)!==0)
   <article>
     @foreach($questions as $item)
     <section class="d-flex shadow p-2 mb-3 bg-white rounded flex-wrap">         
         <h6><a class="text-black" href="/qa/answers/{{ $item->id }}">{{ $item->title }}</a></h6><div class="lines"></div>        
              <div class="d-flex justify-content-between small w-100 align-items-center flex-wrap">
                  <a class="btn btn-success py-0 order-1 order-md-0" href="/qa/answers/{{ $item->id }}">ответить</a>
                  <div class="d-flex justify-content-end align-items-center order-0 order-md-1">
                      <div class="comment-author align-items-center">    
                          <h5 class="m-0 mr-3" onclick="showProfileUser({{ $item->user->id }});return false;">{{ $item->user->profile->name}}</h5>
                      </div> | {{ $item->created_at->format('d.m.Y') }} | 
                  &nbsp;<i class="fas fa-eye"></i>&nbsp; {{ $item->views }} | 
                &nbsp;<i class="far fa-comment-dots"></i>&nbsp; {{ $item->answers }}
                  </div>
              </div>        
     </section>
     @endforeach
   </article>
    @else
    <div class="lines"></div>
    <h6>Вопросов в этом разделе нет</h6>
    @endif
    <div class="lines"></div>
    <nav aria-label="Page navigation example" id="Pagination">
                {{ $questions->links('layouts.paginate') }}
    </nav>
    <div class="lines"></div>
    <div class="center-block-qa" id="ask">
                    @guest
                    <p>Задавать вопросы могут только авторизованные пользователи</p>
                    @else
                    @if (session('qa_error'))
                    <div class="alert alert-danger" role="alert">
                            {{ session('qa_error') }}
                    </div>
                    @endif
                      <form action="/qa/addQuestion" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                            <div>
                                    <div class="form-group is-filled">
                                        <select name="qa_category_id" class="form-control" required>
                                                <option value="">Выберите категорию</option>
                                                @foreach($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>

                                    <div class="form-group">
                                        <h6>Суть вопроса<sup>*</sup></h6>
                                            <input type="text" name="title" placeholder="Сформулируйте вопрос так, чтобы сразу было понятно, о чём речь." class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <h6>Детали вопроса<sup>*</sup></h6>
                                        <textarea name="content" class="form-control" rows="10" placeholder="Опишите в подробностях свой вопрос, чтобы получить более точный ответ. При необходимости, можете добавить изображение." required></textarea>
                                    </div>
                                    <div class="col-12 text-left">
                                    <h6>Выберите изображение <span class="small">(Максимальный размер 10Мб)</span></h6>
                                     <label class=newbtn>
                                      <img id="blah" src="{{ asset('image/placeholder.png') }}" >
                                      <input id="pic" class='pis' onchange="readURL(this);" type="file" name="image" accept="image/*">
                                     </label>
                                   </div>


                                    <input type="submit" class="btn btn-success" value="Опубликовать">
                            </div>                            
		      </form>
                    @endguest
                </div>
</div>
          
@endsection

@php
$title = ' Вопросы | ';
$keywords = 'собака, вопросы, здоровье, кормление, воспитание, дрессировка, совет, спросить, подскажите ';
$description = 'my-dog.club/qa - вопросы и ответы про собак, кормление, содержание, дрессировка, лечение собак, здоровье, советы владельцев';
@endphp
          

