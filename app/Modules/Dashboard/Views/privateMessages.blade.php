@extends('Dashboard::app')

@section('content')
<h5 style="text-align: center; color: blue;">Переписка</h5>
<div class="container">
	<div class="row justify-content-center">	
		<div class="col-12">
		  <ol class="messages">
			@foreach($messages as $item)
			<li>
				<a href="/dashboard/privateMessagesUser/{{ $item->from_id }}">
					<div class="d-flex">
						  <div class="col-3 s5">
						     <table>
							  <tr>
								<td rowspan="2" style="padding-right: 10px;"><img src="{{ asset('image/avatar/'.$item->user->profile->avatar) }}">
								</td>
								<td style="vertical-align: bottom;">
									<small>
									{{ $item->user->profile->name }}
									</small>
								</td>
							  </tr>
							  <tr>
								<td style="vertical-align: top;">
									<small>
									{{ date('d.m.Y H:i', strtotime($item->created_at))}}
								   </small>
								</td>
							</tr>
						   </table>						
						</div>
						<div class="col-9" @if($item->status) {{ 'style=color:#808080'}} @endif>
							{{ str_limit($item->message, 200) }}
						</div>					
				    </div>
				</a>
			</li>
			@endforeach
		  </ol>		
		</div>
	</div>	
</div>



<style type="text/css">	
	.messages li a{
	    display: block;		
		margin: 10px 0;
		padding: 0;
		background-color: #FdFdFd;
		border: 1px solid #DCDCDC;	
		color: black;
		font-weight: 600;		 
	}
	.messages li a:hover{
		text-decoration: none;
		color: black;
	}
	img{
		width: 75px;
		height: 75px;
	}
	.messages{
		padding: 0;
		list-style: none;
	}
	div.col-3{		
		padding:10px 0; 
	}
	.s5 {
    background-color:#DCDCDC;
    background-image: linear-gradient(45deg, transparent,transparent 48%, rgba(255,255,255,.3) 48%, rgba(255,255,255,.3) 52%, transparent 52%);
    background-size:10px 10px;
}	
</style>

@endsection