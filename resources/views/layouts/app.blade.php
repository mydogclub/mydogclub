<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@if(isset($title)){{ str_replace('"','',$title) }}@endif{{ env('APP_NAME') }}</title>{{--<meta name="keywords" content="@if(isset($keywords)){{ $keywords }}@endif">--}}
    <meta name="description" content="@if(isset($description)){{ str_replace('"','',$description) }}@endif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="p:domain_verify" content="f17ad6c871fbf33d8dcf60c085f4d4a7"/>
        @php
        $str = (check_mobile_device())?'M':'';
        @endphp 
  <link rel="preload" href="{{ asset('image/MainPhoto'.$str.'.webp') }}" as="image"> 
  <link rel="preload" href="{{ asset('css/bootstrap.min.css') }}" as="style">
  <link rel="preload" href="{{ asset('css/fa.css') }}" as="style">
  <link rel="preload" href="{{ asset('js/bootstrap.min.js') }}" as="script">
  <link rel="preload" href="{{ asset('js/main.js') }}" as="script">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fa.css') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/ico">    
  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css') }}">    
        @yield('schema', '') 
</head>
<body> 
    <div class="container-fluid">
     <div class="row">
      <header>       
        <img id="default_img" data-src="{{ asset('image/MainPhoto'.$str.'.webp') }}" class="img-fluid d-none d-md-block" alt="*">
        <div class="container">          
          <a href="https://my-dog.club/" class="logo"><img data-src="{{ asset('image/logo.png') }}" alt="*"></a>          
        </div>
            <div class="container position-relative">
               <div class="registration-user">            
                <div class="position-relative">
                @guest
                <h6>Вы вошли как &quot;Гость&quot;<br><span class="text-success" data-target="#login">Войдите</span> или <span class="text-danger" data-target="#registration">Зарегистрируйтесь</span></h6>
                           
                  <form method="POST" action="{{ route('login') }}" id="login">
                    {{ csrf_field() }}                      
                      <div class="form-group">                   
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Введите email">
                        @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <small>Неверно введены данные</small>
                                    </span>
                           <script>var login = document.getElementById("login");login.style.display = "block"</script>
                         @endif 
                      </div>
                      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">                   
                        <input type="password" id="password" class="form-control" name="password" placeholder="Введите пароль" required>
                        @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <small>Неверно введены данные</small>
                                    </span>
                                    <script>var login = document.getElementById("login");login.style.display = "block"</script>
                                @endif

                      </div>
                                       
                     <button type="submit" class="btn btn-primary register-now">Вход</button>
                     <a href="/forgot">Забыли пароль?</a>
                  </form>

                  <form method="POST" id="registration" action="{{ route('register') }}">
                        {{ csrf_field() }}                        
                      <div class="form-group">                                         
                        <input id="name1" type="text" class="form-control" name="name1" value="{{ old('name1') }}" required placeholder="Введите имя" autofocus>
                        @if ($errors->has('name1'))
                                    <span class="text-danger">
                                        <small>Неверно введены данные</small>
                                    </span>
                                    <script>var reg = document.getElementById("registration");reg.style.display = "block"</script>
                                @endif      
                      </div>
                      <div class="form-group">                  
                        <input id="email1" type="email" class="form-control" name="email1" placeholder="Введите email" value="{{ old('email1') }}" required>
                        @if ($errors->has('email1'))
                                    <span class="text-danger">
                                        <small>Неверно введены данные</small>
                                    </span>
                                    <script>var reg = document.getElementById("registration");reg.style.display = "block"</script>
                                @endif 
                      </div>
                      <div class="form-group">                                         
                        <input id="password1" type="password" class="form-control" name="password1" placeholder="Пароль от 6 символов" required>
                        @if ($errors->has('password1'))
                                    <span class="text-danger">
                                        <small>Неверно введены данные</small>
                                    </span>
                                    <script>var reg = document.getElementById("registration");reg.style.display = "block"</script>
                                @endif
                      </div>
                      <div class="form-group">                                          
                        <input id="password1-confirmation" type="password" class="form-control" name="password1_confirmation" placeholder="Подтвердите пароль" required>
                      </div>                  
                     <button type="submit" class="btn btn-primary register-now">Регистрация</button>
                  </form>
                  @else
                  @if($mesmes)
                  <div class="mesmes" title="У Вас есть не прочитанные сообщения,<br> перейдите в личный кабинет" data-toggle="tooltip" data-html="true"><a href="/dashboard/privateMessages"><i class="fas fa-mail-bulk" id="blink"></i></a>
                  </div>
                  @endif                  
                  <h6 class="mb-0">Привет !<br><a href="/dashboard" class="text-dark">{{ auth()->user()->name }}<br><small><i class="fas fa-sign-in-alt"></i> Войти в личный кабинет</small></a></h6>
                  <a class="btn btn-link text-danger w-100 p-0" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><small>Выход <i class="fas fa-sign-out-alt"></i></small> 
                 </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  <button type="submit" class="btn btn-primary register-now">Выход</button>
                  </form>
                  @endguest
                 </div>
                </div>
            </div>        
      </header>
     </div>
                                  <!--Навигация-->
                         @include ('layouts.navigation')
    
                                 <!--Окончание навигации-->
    <!--Контент главной страницы-->
                                    <!--Левая часть-->
    <div class="container">
        <div class="row">
     <div class="my-grid-container">
      <div class="left-column">
        <aside>
           <div class="side-block mt-3">
            @include ('layouts.leftSideNews')
          </div>



          <div class="side-block mt-3">
              @include('layouts.leftSideDevelopments')           
          </div>
          <div class="poll mt-3">            
              @include('layouts.leftSidePoll')                     
          </div>
        </aside> 
       </div>
      
                              <!--Центральная часть-->

        
          <div class="center-column mt-3 mx-3">
            <main>
            @yield('content')
            </main>
            @include('layouts.links')

          </div>        
                        <!--Конец центральной части-->


                                      <!--Правая часть-->

        <div class="right-column">
         <aside>          
            <div class="side-block mt-3">
            @include('layouts.rightSideBlog')
            </div>

            @include('layouts.rightSideGallery')

         </aside>          
        </div>
   </div>
        </div>           
   </div>
    <div class="row">
     <footer id="footer">        
        
           @include('layouts.footer')    
      </footer>     
    </div>
    </div><!--закрывающий container-fluid-->



    <a href="#" class="scrollup" title="Вверх" style="display: inline;"><i class="fas fa-chevron-circle-up"></i></a>
             @include('layouts.profile')
    <div class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>        
          </div>
        </div>
      </div>
   </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script async src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  @if (session('status'))
  <script>
    $('.modal-title').text('Статус');
    $('.modal-body p').html('{!! session('status') !!}');
    $('.modal').show();
  </script>                       
 @endif
 @if (session('warning'))                        
  <script>
    $('.modal-title').text('Предупреждение!');
    $('.modal-body p').text('{{ session('warning') }}');
    $('.modal').show();
  </script>                         
 @endif

 <script>
   $('.modal button').click(function(){
            $('.modal').hide();
            });            
 </script>
 <script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "Моя собака",
  "url" : "https://my-dog.club/",
  "sameAs" : [    
    "https://www.facebook.com/Моя-собака-108277107311605/"    
  ]
}
</script>
<script>
    $(document).ready(function($) {
$('.social a').on('click', function() {
var id = $(this).data('id');
if(id) {
var data = $(this).parent('.social');
var url = data.data('url') || location.href, title = data.data('title') || '', desc = data.data('desc') || '';
var img = $('#default_img').attr('src');
if($('img').is('#main_img')) img = $('#main_img').attr('src');
Shares.share(id, url, title, desc, img);
}
});
});
</script>
 
</body>
</html>
<?php
function check_mobile_device() {
$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
// var_dump($agent);exit;
foreach ($mobile_agent_array as $value) {
if (strpos($agent, $value) !== false) return true;
}
return false;
}
?>