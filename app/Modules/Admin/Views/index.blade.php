@extends('Admin::app')

@section('content')
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">id</th>
      <th scope="col">Ник</th>
      <th scope="col">Email</th>
      <th scope="col">Роль</th>
      <th scope="col">Бан</th>
      <th scope="col">Верифицирован</th>
      <th scope="col">Действие</th>      
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    @continue($user->role == 'admin')
    <tr>
    	<td>{{ $user->id}}</td>
    	<td>{{ $user->name}}</td>
    	<td>{{ $user->email}}</td>
    	<td>{{ $user->role}}</td>
    	<td>@if($user->ban == 'Y') Забанен @else Активен @endif</td>
    	<td>
    		@if($user->verified == 0)
    		 Нет
    		<a href="javascript:setVerified({{ $user->id }})" class="btn btn-success"><i class="fas fa-paw"></i></a>   		
    		@else Да    		 
    	    @endif</td>
    	<td>
    		@if($user->ban == 'Y') 
    		<a href="javascript:setBan({{ $user->id }}, 'N')" class="btn btn-success">Разбанить</a> 
    		@else 
    		<a href="javascript:setBan({{ $user->id }}, 'Y')" class="btn btn-danger">Забанить</a> 
    		@endif

    		@if($user->role == 'user') 
    		<a href="javascript:setRole({{ $user->id }}, 'moderator')" class="btn btn-success">Модератором</a> 
    		@endif
    		@if($user->role == 'moderator') 
    		<a href="javascript:setRole({{ $user->id }}, 'user')" class="btn btn-danger">Пользователем</a> 
    		@endif
                                      <a href="{{ url('/admin/user/edit', $user->id) }}" class="btn btn-success"><i class="fas fa-pen-fancy"></i></a>
    		<a href="javascript:deleteUser({{ $user->id }})" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>   		
    	</td>
    </tr>
    @endforeach
  </tbody>
</table>
<form id="user" method="POST" action="">
	{{ csrf_field() }}
	<input id="user_id" type="hidden" name="user_id" value="">
	<input id="value" type="hidden" name="value" value="">
	
</form>
<script>
	var form = document.getElementById('user');
	var user_id = document.getElementById('user_id');
	var val = document.getElementById('value');
	function setVerified(id)
	{
      user_id.value = id;
      val.value = 1;
      form.action = '/admin/user/verified';
      form.submit();
	}
	function setBan(id, ban)
	{
      user_id.value = id;
      val.value = ban;
      form.action = '/admin/user/ban';
      form.submit();
	}
	function setRole(id, role)
	{
      user_id.value = id;
      val.value = role;
      form.action = '/admin/user/role';
      form.submit();
	}
	function deleteUser(id)
	{
      user_id.value = id;      
      form.action = '/admin/user/deleteUser';
      form.submit();
	}
</script>
@endsection
