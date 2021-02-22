<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/ico">    
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"> 
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src ="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> 
    <script src ="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js "></script> 
    <script src="{{ asset('js/main.js') }}"></script>   

       
    
</head>
<body> 
    <div class="container-fluid">
      <div class="row">
        <header class="bg-dark text-light text-center px-3">
        	<h3>Панель администратора сайта</h3>
        	 <p class="text-right m-0"><a href="/" target="_blank" class="btn btn-info">Перейти на сайт</a></p>
        </header>
      </div>
      <div class="row">
      	<div class="col-12 col-md-2 bg-secondary text-light px-3" style="min-height: 100vh;">
      		<ul class="nav flex-column">
            @can('Admin')
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin">Пользователи</a>
			  </li>
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/gallery">Галерея</a>
			  </li>
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/comment">Комментарии</a>
			  </li>
            @endcan
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/blog">Блог</a>
			  </li>	
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/news">Новости</a>
			  </li>	
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/developments">События</a>
			  </li>
            @can('Admin')
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/breeds">Справочник пород</a>
			  </li>	
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/diseases">Справочник болезней</a>
			  </li>	
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/keeping">Содержание</a>
			  </li>
                          <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/qa">Категории вопрос/ответ</a>
			  </li>
                          <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/question">QA вопрос</a>
			  </li>
                          <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/admin/answer">QA ответ</a>
			  </li>
           @endcan					  
		  </ul>
      	</div>
      	<div class="col-12 col-md-10 px-0 pt-3">
      		@yield('content')
      	</div>
      	
      </div>
    </div>
    <script>
      $('textarea').ckeditor();
    </script> 
</body>
</html>