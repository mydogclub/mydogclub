@extends('Admin::app')

@section('content')
<div class="container">
	<div class="row">
		<h4>Комментарии</h4>
		<table class="table">
          <thead class="thead-dark">
            <tr>
		      <th scope="col">id</th>
		      <th scope="col">Ник</th>
		      <th scope="col">Комментарий</th>
		      <th scope="col">Дата</th>		      
		      <th scope="col">Действие</th>      
            </tr>
        </thead>
          <tbody>
  	@foreach($comments as $item)
		  	<tr>
		  		<td>{{ $item->id }}</td>
		  		<td>{{ $item->user->name }}</td>
		  		<td>{{ $item->text }}</td>
		  		<td>{{ $item->created_at->format('d.m.Y')}}</td>
		  		<td><a href="{{ url('/admin/comment/destroy', $item->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a></td>
		  	</tr>

  	@endforeach
	      </tbody>
        </table>
	</div>
	<p>{{ $comments->links() }}</p>
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