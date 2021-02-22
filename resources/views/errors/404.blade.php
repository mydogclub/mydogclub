@extends('layouts.appError')

@section('content')
<div class="alert-404">	
	<p>
	@if(isset($error))
	{{ $error }}
	@else
	Ошибка 404!!!<br> Страница удалена или не существует.
	@endif
    </p>
	<img src="{{ asset('image/404.png') }}">	
</div>
@endsection