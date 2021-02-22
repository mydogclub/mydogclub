@extends('Dashboard::app')

@section('content')
<h5 style="text-align: center; color: blue;">Переписка с пользователем {{ $user->profile->name}}</h5>
<div class="container">
	@if(session('privateMes'))
					<div class="alert alert-success text-center mt-3">
					{{ session('privateMes') }}						
					</div>
					@endif
    @if(session('privateMesError'))
					<div class="alert alert-danger text-center mt-3">
					{{ session('privateMesError') }}						
					</div>
					@endif
	<div class="row justify-content-center">	
		<div class="col-12">
		  <ol class="list-style-none p-0">
			@foreach($messages as $item)
			<li>
				<div class="d-flex justify-content-between s5">
					<p>@if(auth()->id()==$item->from_id)
					Я
					@else
					{{ $user->profile->name }}
					@endif</p>
					<p>{{ date('d.m.Y H:i', strtotime($item->created_at))}}</p>
				</div>

				<div>
				{{ $item->message }}
			    </div>
			</li>
			@endforeach
		  </ol>		
		</div>
	</div>
	<p>{{ $messages->links() }}</p>			
		<form action="/dashboard/privateMessages" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="to_id" value="{{ $user->id }}"> 
		 <div class="row mb-5">		
		<div class="col-12">
		<textarea rows=8 name="message" class="form-control"></textarea>			
		</div>
		<div class="col-12 d-flex align-items-center justify-content-end pt-1">
		<button type="submit" style="font-size: 50px;color: green; border-radius: 50%;padding:0 14px;border-width:0; cursor: pointer;" title="Отправить сообщение">
			<i class="fas fa-paw"></i>			
		</button>
		</div>
		</div>
		</form>			
</div>



<style type="text/css">
	ol.list-style-none>li {
	    display: block;		
		margin: 10px 0;
		padding: 0;
		background-color: #FdFdFd;
		border: 1px solid #DCDCDC;		
		color: black;		 
	}
	ol.list-style-none>li>div{
		max-height: 200px;
		overflow: auto;
		padding: 10px 10px;
	}
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
    p{
    	margin:0;
    }
    .s5 {
    background-color:#DCDCDC;
    background-image: linear-gradient(45deg, transparent,transparent 48%, rgba(255,255,255,.3) 48%, rgba(255,255,255,.3) 52%, transparent 52%);
    background-size:10px 10px;
}	
</style>
<script>
	$(document).ready(function(){
		$('.alert.alert-success').fadeOut(5000);
		$('.alert.alert-danger').fadeOut(5000);
	});
</script>

@endsection
