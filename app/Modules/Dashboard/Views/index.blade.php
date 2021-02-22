@extends('Dashboard::app')

@section('content')
                                                                                                @if(session('personalMes'))
					<div class="alert alert-success text-center mt-3">
					{{ session('personalMes') }}						
					</div>
                                                                                                @endif
                                                                                                @if (count($errors) > 0)                    
                                                                                                <div class="col-12 alert alert-danger">
                                                                                                  <ul>
                                                                                                    @foreach ($errors->all() as $error)
                                                                                                      <li>{{ $error }}</li>
                                                                                                    @endforeach
                                                                                                  </ul>
                                                                                                </div>
                                                                                              @endif
<h5 style="text-align: center; color: blue;">Личные данные</h5>
<div class="container">
	<div class="row">
		<div class="col-12 col-lx-3 mb-3">
		  <div style="width: 210px; background-color: #dcdcdc; padding: 5px; margin: auto;">
			<figure>
				<img id="avatar" class="img-thumbnail" style="width: 100%; cursor: pointer;" data-toggle="tooltip" data-placement="right" data-html="true" title="<big>Нажмите для выбора аватарки</big>" src="{{ asset('image/avatar/'.$profile->avatar) }}">
				<figcaption>
					<form id="upload" action="/dashboard/avatarUpdate" method="POST" enctype="multipart/form-data">
                         {{ csrf_field() }}                                             
                        <input id="pic" onchange="readURL(this);" type="file" name="image" >
                        <p style="text-align: center; margin: 0;"><small>Maксимальный размер 1 Мб</small></p>                  
                      <button class="btn btn-success w-100">Изменить аватар                       
                      </button>           
                   </form>
				</figcaption>
			</figure>
		 </div>
		</div>
		<div class="col-12 col-lx-9">
			<div style="background-color: #dcdcdc; padding: 5px 10px;">
				<form action="/dashboard/personalEdit" method="POST">
					{{ csrf_field() }} 
					<div class="form-group">
					    <label>Ваше имя</label>
					    <input type="text" class="form-control" name='name' placeholder="Ваше имя" value="{{ $profile->name }}">    
					</div>
					<div class="form-group">
					    <label>Род деятельности</label>
					    <input type="text" class="form-control" name='profession' placeholder="Род деятельности" value="{{ $profile->profession }}">    
					</div>
					<div class="form-group">
					    <label>Ваш адрес</label>
					    <input type="text" class="form-control" name='address' placeholder="Ваше адрес" value="{{ $profile->address }}">    
					</div>
					<div class="form-group">
					    <label>Ваш возраст</label>
					    <input type="number" class="form-control" name='age' value="{{ $profile->age }}" min="0"> 
					</div>
					<div class="form-group">
					    <label>Ваши питомцы</label>
					    <input type="text" class="form-control" name='pets' placeholder="Ваши питомцы" value="{{ $profile->pets }}">    
					</div>
					<button type="submit" class="btn btn-success">Обновить</button>	
				</form>			
			</div>
		</div>	
		
	</div>	
</div>

<style type="text/css">
	label{
		color: blue;
	}	
</style>
<script>
	$(document).ready(function(){
		$('.alert.alert-success').fadeOut(5000);
                                      $('.alert.alert-danger').fadeOut(5000);
		$(function () {
        $('[data-toggle="tooltip"]').tooltip()
                      });
		$('#avatar').click(function(){
			$('#pic').click();
		})		
	});
	function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {console.log(e.target.result); 
                    $('#avatar').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
@endsection