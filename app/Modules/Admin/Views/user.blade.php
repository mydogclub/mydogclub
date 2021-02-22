@extends('Admin::app')

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
					<form id="upload" action="/admin/user/avatarUpdate" method="POST" enctype="multipart/form-data">
                         {{ csrf_field() }}
                         <input type="hidden" name="id" value="{{ $profile->id }}">
                         <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
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
				<form action="/admin/user/update" method="POST">
					{{ csrf_field() }} 
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                        <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                        <input type="hidden" name="model" value="Profile">
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
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-12">
			<form id="contactsEdit" action="/admin/user/update" method="POST">
			  {{ csrf_field() }} 
                                        <input type="hidden" name="id" value="{{ $contact->id }}">
                                        <input type="hidden" name="user_id" value="{{ $profile->user_id }}">
                                        <input type="hidden" name="model" value="Contact">
                                                                                    <div style="display: flex; flex-direction: column; margin: auto; background-color: #dcdcdc; max-width: 500px;">
				        <div class="dbcontacts">
				            <div><i class="fas fa-phone-volume" style="color:red; font-size: 30px;"></i> Телефон</div>
                                                                                    <div><input maxlength="20"  type="text" name="phone1" value="{{ isset($contact->phone1)?$contact->phone1:""}}">
                                                                                        <span class="errorform"></span></div>
				        </div>
				        <div class="dbcontacts">
				            <div><i class="fas fa-phone-volume" style="color:red; font-size: 30px;"></i> Телефон</div>
				            <div><input maxlength="20" type="text" name="phone2" value="{{ isset($contact->phone2)?$contact->phone2:""}}">
                                                                                          <span class="errorform"></span>
                                                                                        </div>
				        </div>
				        <div class="dbcontacts">
				        	<div><i class="fas fa-phone-volume" style="color:red; font-size: 30px;"></i> Телефон</div>
				        	<div><input maxlength="20" type="text" name="phone3" value="{{ isset($contact->phone3)?$contact->phone3:""}}">
                                                                                                 <span class="errorform"></span>
                                                                                                </div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-skype" style="color: #00CED1; font-size: 30px;"></i> Skype</div>
				             <div><input maxlength="50" type="text" name="skype" value="{{ isset($contact->skype)?$contact->skype:""}}"></div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-viber" style="background-color: #483D8B;color: white; font-size: 30px;"></i> Viber</div>
				             <div><input maxlength="50" type="text" name="viber" value="{{ isset($contact->viber)?$contact->viber:""}}">
                                                                                          <span class="errorform"></span>
                                                                                         </div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-telegram" style="color: #0000CD; font-size: 30px;"></i> Telegram</div>
				             <div><input maxlength="50" type="text" name="telegram" value="{{ isset($contact->telegram)?$contact->telegram:""}}"></div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fas fa-at" style="font-size: 30px;"></i> Email</div>
				             <div><input maxlength="50" type="email" name="email" value="{{ isset($contact->email)?$contact->email:""}}"></div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-facebook-square" style="color:#4682B4; font-size: 30px;"></i> Facebook</div>
				             <div><input maxlength="150" type="text" name="facebook" value="{{ isset($contact->facebook)?$contact->facebook:""}}"></div>
				        </div>
                                                                                        <div class="dbcontacts">
				             <div><i class="fab fa-instagram" style="font-size: 30px;"></i> Instagram</div>
				             <div><input maxlength="150" type="text" name="instagram" value="{{ isset($contact->instagram)?$contact->instagram:""}}"></div>
                                                                                        </div> 
				        <div class="dbcontacts">
				             <div><i class="fab fa-twitter" style="background-color: #4682B4;color: white; font-size: 30px;"></i> Twitter</div>
				             <div><input maxlength="50" type="text" name="twitter" value="{{ isset($contact->twitter)?$contact->twitter:""}}"></div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-vk" style="background-color: #4682B4;color: white; font-size: 30px;"></i> VK</div>
				             <div><input maxlength="50" type="text" name="vk" value="{{ isset($contact->vk)?$contact->vk:""}}"></div>
				        </div>
				        <div class="dbcontacts">
				             <div><i class="fab fa-odnoklassniki-square" style="background-color: white;color: #FFA500; font-size: 30px;"></i> Одноклассники</div>
				             <div><input maxlength="50" type="text" name="ok" value="{{ isset($contact->ok)?$contact->ok:""}}"></div>
				        </div>                                                                                
				        <div class="dbcontacts">
				             <div><i class="fab fa-whatsapp" style="background-color: #00FF00;color:white; font-size: 30px;"></i> Whatsapp</div>
				             <div><input maxlength="50" type="text" name="whatsapp" value="{{ isset($contact->whatsapp)?$contact->whatsapp:""}}">
                                                                                           <span class="errorform"></span>
                                                                                          </div>
				        </div>				        
				      </div>			
				<button type="submit" class="btn btn-success">Обновить</button>
				
			</form>
			
		</div>
	</div>
	@if(session('contactsMes'))
					<div class="alert alert-success text-center mt-3">
					{{ session('contactsMes') }}						
					</div>
					@endif
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
<style>
    .errorform{
        display: none; color: red;font-size: 10px;
    }
</style>
<script>
	$(document).ready(function()
                   {
		$('.alert.alert-success').fadeOut(5000);
                                      $('#contactsEdit').submit(function(e)
                                      {
                                        var error = true;
                                        var phone1=$(this).find('input[name="phone1"]').val();
                                        var phone1error=$(this).find('input[name="phone1"]').next();
                                        if(!$.isNumeric(phone1) &&  phone1.length>0){
                                            $(this).find('input[name="phone1"]').val('');                                            
                                            phone1error.text( 'Неверный ввод');
                                            phone1error.css('display', 'block');
                                            phone1error.fadeOut(5000);
                                            error = false;
                                        }
                                        var phone3=$(this).find('input[name="phone3"]').val();
                                        var phone3error=$(this).find('input[name="phone3"]').next();
                                        if(!$.isNumeric(phone3) &&  phone3.length>0){
                                            $(this).find('input[name="phone3"]').val('');                                            
                                            phone3error.text( 'Неверный ввод');
                                            phone3error.css('display', 'block');
                                            phone3error.fadeOut(5000);
                                            error = false;
                                        }
                                        var phone2=$(this).find('input[name="phone2"]').val();
                                        var phone2error=$(this).find('input[name="phone2"]').next();
                                        if(!$.isNumeric(phone2) &&  phone2.length>0){
                                            $(this).find('input[name="phone2"]').val('');                                            
                                            phone2error.text( 'Неверный ввод');
                                            phone2error.css('display', 'block');
                                            phone2error.fadeOut(5000);
                                            error = false;
                                        }
                                        var viber=$(this).find('input[name="viber"]').val();
                                        var vibererror=$(this).find('input[name="viber"]').next();
                                        if(!$.isNumeric(viber) &&  viber.length>0){
                                            $(this).find('input[name="viber"]').val('');                                            
                                            vibererror.text( 'Неверный ввод');
                                            vibererror.css('display', 'block');
                                            vibererror.fadeOut(5000);
                                            error = false;
                                        }
                                        var whatsapp=$(this).find('input[name="whatsapp"]').val();
                                        var whatsapperror=$(this).find('input[name="whatsapp"]').next();
                                        if(!$.isNumeric(whatsapp) &&  whatsapp.length>0){
                                            $(this).find('input[name="whatsapp"]').val('');                                            
                                            whatsapperror.text( 'Неверный ввод');
                                            whatsapperror.css('display', 'block');
                                            whatsapperror.fadeOut(5000);
                                            error = false;
                                        }
                                        return error;
                                     });
	 });
</script>
@endsection