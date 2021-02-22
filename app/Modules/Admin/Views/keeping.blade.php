@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
  	{{ session('status') }}
  </div>                      
 @endif
<div class="container pb-5">	
	<div class="row">
		<h4>Содержание</h4>
		<div class="col-12 d-flex justify-content-between my-3">
			 <h5>Содержание</h5> 
			 <p>
			 	<a href="{{ url('/admin/keeping/create')}}" class="btn btn-success">
			 	<i class="far fa-newspaper"></i> Добавить статью 
			   </a>
			</p> 
	   </div>
 <div class="col-12">
	<table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">id</th>
		      <th scope="col">Заголовок</th>	      		      
		      <th scope="col">Редактор</th>		           
		    </tr>
		  </thead>
           <tbody>		           
		@foreach($keeping as $item)
		<tr> 
			<td>{{ $item->id }}</td>
			<td>{{ $item->title }}</td>			
			<td><a href="{{ url('/admin/keeping/show', $item->id) }}" class="btn btn-success"><i class="fas fa-pen-fancy"></i></a></td>
		</tr>		
		@endforeach
		   </tbody>
	</table>
 </div>
	</div>
	<p>{{ $keeping->links() }}</p>
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