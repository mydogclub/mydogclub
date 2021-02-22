@extends('Dashboard::app')

@section('content')
<h5 style="text-align: center; color: blue;">Смена пароля</h5>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-md-6" style="background-color: #dcdcdc;">
			<form action="/dashboard/changePasswordEdit" method="POST">
			  {{ csrf_field() }}   
				      <table>
				        <tr>
				        	<td>Старый пароль</td>
				        	<td>
				        		<input type="password" name="password" required>
				        	</td>
				        </tr>
				        <tr>
				        	<td>Новый пароль</td>
				        	<td>
				        		<input type="password" name="newPassword" required>
				        	</td>
				        </tr>
				        <tr>
				        	<td>Повторите новый пароль &nbsp;</td>
				        	<td>
				        		<input type="password" name="newPassword_confirmation" required>
				        	</td>
				        </tr>
				      </table>			
				<button type="submit" class="btn btn-success">Обновить</button>
				
			</form>
			
		</div>
	</div>
	@if(session('changePasswordMes'))
					<div class="alert alert-success text-center mt-3">
					{{ session('changePasswordMes') }}						
					</div>
					@endif
    @if(session('changePasswordError'))
					<div class="alert alert-danger text-center mt-3">
					{{ session('changePasswordError') }}						
					</div>
					@endif
</div>
<style type="text/css">
	td {		
		padding: 15px 0; 
	}
</style>
<script>
	$(document).ready(function(){
		$('.alert.alert-success').fadeOut(5000);
		$('.alert.alert-danger').fadeOut(5000);
	});
</script>
@endsection