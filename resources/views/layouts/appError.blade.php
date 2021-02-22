<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>404</title>        
  <link rel="preload" href="{{ asset('image/MainPhoto.webp') }}" as="image"> 
  <link rel="preload" href="{{ asset('css/bootstrap.min.css') }}" as="style">
  <link rel="preload" href="{{ asset('css/fa.css') }}" as="style">
  <link rel="preload" href="{{ asset('js/bootstrap.min.js') }}" as="script">
  <link rel="preload" href="{{ asset('js/main.js') }}" as="script">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fa.css') }}">
  <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/ico">    
  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css') }}">    
    
</head>
<body> 
    <div class="container-fluid">
     <div class="row">
      <header>       
        <img id="default_img" data-src="{{ asset('image/MainPhoto.webp') }}" class="img-fluid d-none d-md-block" alt="*">
        <div class="container">          
          <a href="https://my-dog.club/" class="logo"><img data-src="{{ asset('image/logo.png') }}" alt="*"></a>          
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