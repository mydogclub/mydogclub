<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>    
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
    <script src="{{ asset('js/lang/summernote-ru-RU.js') }}"></script>   
    
</head>
<body> 
    <div class="container-fluid">
      <div class="row">  
      <header class="bg-dark text-light text-center px-3">
      	<h3 class="mb-0 pt-2">Личный кабинет {{ $profile->name }}</h3>        
      	 <p class="text-right m-0"><a href="/" class="btn btn-info">Вернуться на сайт</a></p>
      </header>
      </div>
      <div class="row">
      	<div class="col-12 col-lg-3 bg-secondary text-light px-3 dbsitebar">
      		<ul class="nav flex-column">
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/dashboard">Личные данные</a>
			  </li>
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/dashboard/contacts">Контактные данные</a>
			  </li>
			  <li class="nav-item">
			    <a class="btn btn-light w-100 mt-3" href="/dashboard/changePassword">Смена пароля</a>
			  </li>
			  <li class="nav-item mb-3">
			    <a class="btn btn-light w-100 mt-3" href="/dashboard/privateMessages">Личные сообщения</a>
			  </li>				  			  
		  </ul>
      	</div>
      	<div class="col-12 col-lg-9 px-0 pt-3">
      		@yield('content')
      	</div>
      	
      </div>
    </div> 
</body>
</html>