@extends('qa.app')

@section('content')
<div class="alert-404">	
	<p>	
	Ошибка 404!!!<br> Страница удалена или не существует.	
       </p>
	<img src="{{ asset('image/404.png') }}">	
</div>
@endsection