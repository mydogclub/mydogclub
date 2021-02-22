@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
  	{{ session('status') }}
  </div>                      
 @endif
<div class="container">
	<h4>Галерея</h4>
	<div class="row mb-3">		
		<form action="/admin/gallery/upload" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
        <input type="file" name="image">
        <input type="submit" name="Загрузить">
        </form>
	</div>
	<div class="row">
		@foreach($gallery as $item)     
		<div class="card col-12 col-md-6" style="background-color: #DCDCDC; border: 3px solid white;">		  
		  	<img src="{{ asset('image/gallery').'/my-dog-club-'.$item->alias.'-'.$item->img }}max.jpg" class="card-img-top mt-3" alt="*">		  
		  <div class="card-body">
		    <form method="POST" action="/admin/gallery/update">
		    	{{ csrf_field() }}
		    	<input type="hidden" name="id" value="{{ $item->id }}">
		    	<small style="color: #FF0000;">Title/Заголовок</small>
		    	<input class="form-control" type="text" name="title" value="{{ $item->title }}" required>
		    	<small style="color: #FF0000;">Alias/Псевдоним</small>
		    	<input class="form-control" type="text" name="alias" value="{{ $item->alias }}" required>
		    	<small style="color: #FF0000;">Keywords/Ключевые слова через запятую</small>
		    	<input class="form-control" type="text" name="keywords" value="{{ $item->keywords }}" required>
		    	<small style="color: #FF0000;">Text/Описание</small>
		    	<textarea class="form-control" name="text" rows="5">{!! $item->text !!}</textarea>
		    	<div class="d-flex justify-content-between mt-2">
		    	<button type="submit" class="btn btn-success">Сохранить</button>
		    	<a href="{{ url('/admin/gallery/destroy', $item->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a></div>	
		    </form>
		  </div>
		</div>
		@endforeach
	</div>
	<p>{{ $gallery->links() }}</p>
</div>
<style type="text/css">
	.pagination{
		font-weight: 700;
		font-size: 36px;
		justify-content: center;		
	}
	.pagination li span,.pagination li a {
	    color: #FF8C00;
	    font-size: 36px;
	    font-weight: 900;
	    margin:0 5px;
    }
    .pagination li a{
    	cursor: pointer;
    	color: rgb(0,0,0);
    }
    .card-img-top{
    	width: 50%;
    }	
</style>
@endsection