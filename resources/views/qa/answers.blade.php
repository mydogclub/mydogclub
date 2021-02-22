@extends('qa.app')

@section('content')
<div class="center-block-qa">                 
                    <div class="d-flex justify-content-end"><button onclick="goBack()" class="position-relative btn btn-success p-1">Вернуться к <br>вопросам</button></div>
                <h1 class="text-center">Хочу спросить</h1> 
                <h2 class="text-center">Ответы пользователей</h2>                    
  </div>

   <article>
    <section class="d-flex shadow p-2 mb-3 bg-white rounded flex-wrap">
        <div class="d-flex w-100">
             <img data-src="{{ asset('image/avatar/'.$user[0]->profile->avatar) }}" class="avatar" alt="{{ $user[0]->name }}">
             <div class="comment-author align-self-end ml-3">    
                        <h5 onclick="showProfileUser({{ $question['user_id'] }});return false;">{{ $user[0]->name }}</h5>
                        <span class="small-comment">{{ $question['created_at']->format('d.m.Y') }} в {{ $question['created_at']->format('H-i') }}</span>             
                    </div>
         </div><div class="lines"></div>
         <div>
             <h6>{{ $question['title'] }}</h6>
             <?php
             $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'questions'.DIRECTORY_SEPARATOR."my-dog-club-question-".$question['id'];
             ?>
             <p>
                 @if(is_file(public_path($newName.'.jpg')))
                 <img class="qa-img" data-src="{{ asset($newName.'.jpg') }}"
                      alt="*"
                      onclick="showModal(this)"             
                      data-img="{{ asset($newName.'.b.jpg') }}"
                      >                  
                 @endif
                 {{ $question['content']}}
             </p>
         </div>
              <div class="d-flex justify-content-end small w-100 align-items-center">{{ $question['created_at']->format('d.m.Y') }} | 
                  &nbsp;<i class="fas fa-eye"></i>&nbsp; {{ $question['views'] }} | 
                &nbsp;<i class="far fa-comment-dots"></i>&nbsp; {{ $question['answers'] }}
              </div>        
     </section>
     @if(count($answers)!==0)
     <section class="d-flex shadow p-2 mb-3 bg-dark rounded flex-wrap justify-content-center"><h5 class="qa-text">Ответы пользователей</h5></section>   
     @foreach($answers as $item)
     <section class="d-flex shadow p-2 mb-3 bg-white rounded flex-wrap">
         <div class="d-flex w-100">
             <img data-src="{{ asset('image/avatar/'.$item->user->profile->avatar) }}"
                  class="avatar" alt="{{ $item->user->profile->name}}">
             <div class="comment-author align-self-end ml-3">    
                        <h5 onclick="showProfileUser({{ $item->user->id }});return false;">{{ $item->user->profile->name}}</h5>
                        <span class="small-comment">{{ $item->created_at->format('d.m.Y') }} в {{ $item->created_at->format('H-i') }}</span>             
                    </div>
         </div><div class="lines"></div>
         <?php
             $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'answers'.DIRECTORY_SEPARATOR."my-dog-club-answer-".$item->id;
          ?>
         @if(is_file(public_path($newName.'.jpg')))
         <img class="qa-img"
              data-src="{{ asset($newName.'.jpg') }}"
              alt="*"
              onclick="showModal(this)"             
              data-img="{{ asset($newName.'.b.jpg') }}"
              >                 
                 @endif
         {{ $item->body }}       
     </section>
     @endforeach
     @else
      <section class="d-flex shadow p-2 mb-3 bg-white rounded flex-wrap">
          <h6>Ответов нет, будьте первым!</h6>       
     </section>
     @endif
     
   </article>
   <div class="center-block-qa">
                    @guest
                    <p>Отвечать могут только авторизованные пользователи</p>
                    @else
                    @if (session('qa_error'))
                    <div class="alert alert-danger" role="alert">
                            {{ session('qa_error') }}
                    </div>
                    @endif
                      <form action="/qa/addAnswer" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type ="hidden" name="question_id" value="{{ $question['id']}}">
                            <div>                             
                                    <div class="form-group">
                                        <h6>Ваш ответ<sup>*</sup></h6>
                                        <textarea name="content" class="form-control" rows="10" placeholder="Ответьте на вопрос. При необходимости, можете добавить изображение." required></textarea>
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
                    <div class="my-modal">
                     <button id="CloseModal" type="button"><i class="fas fa-times"></i></button>
                    <div class="my-modal-content">                  
                        <img class="img-fluid" src="" alt="*">                                       
                    </div>
                    </div>          
@endsection
@push('script')
<script>
    var modal = document.querySelector(".my-modal");
    function showModal(elem){       
        document.querySelector(".my-modal-content img").setAttribute("src",elem.dataset.img);
        modal.style.display = "flex";        
    }
    document.querySelector("#CloseModal").onclick = function(){
    modal.style.display = "none";
}
</script>
@endpush

@php
$title = ' Ответы на вопрос '.$question['title'].' | ';
$keywords = 'вопрос, собака, ответ, ';
$description = $question['title'];
@endphp