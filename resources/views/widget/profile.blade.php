<div class="profile">
    <h5 class="s5"><span class="text-primary">Профиль пользователя</span><br> <span class="text-danger">{{ $user->profile->name }}</span></h5>	
		<img src="{{ asset('image/avatar/'.$user->profile->avatar) }}" class="img-thumbnail" alt="*">
	@if($user->profile->age !=0)
	<p><span class="text-primary">Возраст - </span>{{ $user->profile->age }}</p>
	@endif
	<div class="lines"></div>
	@if(!empty($user->profile->address))	
	<p><span class="text-primary">Адрес</span></p><p>{{ $user->profile->address }}</p>	
	@endif
	<div class="lines"></div>
	@if(!empty($user->profile->profession))	
	<p><span class="text-primary">Вид деятельности</span></p><p>{{ $user->profile->profession }}</p>	
	@endif
	<div class="lines"></div>
	@if(!empty($user->profile->pets))	
	<p><span class="text-primary">Питомцы</span></p><p>{{ $user->profile->pets }}</p>	
	@endif	
	<div class="lines"></div>
	<div class="contacts">	
	@if(!empty($user->contacts->phone1))	
	<p><a href="tel:{{ $user->contacts->phone1 }}" title="Телефон: {{ $user->contacts->phone1 }}"><i class="fas fa-phone-volume"></i> {{ $user->contacts->phone1 }}</a></p>	
	@endif	
	@if(!empty($user->contacts->phone2))	
	<p><a href="tel:{{ $user->contacts->phone2 }}" title="Телефон: {{ $user->contacts->phone2 }}"><i class="fas fa-phone-volume"></i> {{ $user->contacts->phone2 }}</a></p>	
	@endif	
	@if(!empty($user->contacts->phone3))	
	<p><a href="tel:{{ $user->contacts->phone3 }}" title="Телефон: {{ $user->contacts->phone3 }}"><i class="fas fa-phone-volume"></i> {{ $user->contacts->phone3 }}</a></p>	
	@endif	
	@if(!empty($user->contacts->skype))	
	<p><a href="skype:{{ $user->contacts->skype }}" title="Skype: {{ $user->contacts->skype }}"><i class="fab fa-skype"></i> {{ $user->contacts->skype }}</a></p>	
	@endif
	@if(!empty($user->contacts->viber))	
	<p><a href="viber:{{ $user->contacts->viber }}" title="Viber: {{ $user->contacts->viber }}"><i class="fab fa-viber"></i> {{ $user->contacts->viber }}</a></p>	
	@endif
	@if(!empty($user->contacts->telegram))	
	<p><a href="http://t.me/{{ $user->contacts->telegram }}" title="Telegram: {{ $user->contacts->telegram }}"><i class="fab fa-telegram"></i> <span>@</span>{{ $user->contacts->telegram }}</a></p>	
	@endif
	@if(!empty($user->contacts->email))	
	<p><a href="mailto:{{ $user->contacts->email }}" title="Email: {{ $user->contacts->email }}"><i class="fas fa-at"></i> {{ $user->contacts->email }}</a></p>	
	@endif
	@if(!empty($user->contacts->whatsapp))	
	<p><a href="http://wa.me/{{ $user->contacts->whatsapp }}" title="Whatsapp: {{$user->contacts->whatsapp }}"><i class="fab fa-whatsapp"></i> {{ $user->contacts->whatsapp }}</a></p>	
	@endif
    </div>
    <div class="lines"></div>
    <p>
	@if(!empty($user->contacts->facebook))	
	<a href="{{ $user->contacts->facebook }}" target="_blank" title="Facebook: {{ $user->contacts->facebook }}"><i class="fab fa-facebook-square"></i></a>
	@endif
	@if(!empty($user->contacts->twitter))	
	<a href="{{ $user->contacts->twitter }}" target="_blank" title="Twitter: {{ $user->contacts->twitter }}"><i class="fab fa-twitter"></i></a>
	@endif
	@if(!empty($user->contacts->instagram))	
	<a href="{{ $user->contacts->instagram }}" target="_blank" title="Instagram: {{ $user->contacts->instagram }}"><i class="fab fa-instagram"></i></a>
	@endif
	@if(!empty($user->contacts->vk))	
	<a href="{{ $user->contacts->vk }}" target="_blank" title="Vk: {{ $user->contacts->vk }}"><i class="fab fa-vk"></i></a>
	@endif
	@if(!empty($user->contacts->ok))	
	<a href="{{ $user->contacts->ok }}" target="_blank" title="Ok: {{ $user->contacts->ok }}"><i class="fab fa-odnoklassniki-square"></i></a>
	@endif	
    </p>
    @if(auth()->check())    
    <div class="lines"></div>
    <a href="/dashboard/privateMessagesUser/{{ $user->id }}" class="btn btn-success my-3" title="Отправить сообщение пользователю">Отправить сообщение пользователю</a>
    @else
    <p>Зарегестрированные пользователи могут обмениватся сообщениями</p>
    @endif
</div>
