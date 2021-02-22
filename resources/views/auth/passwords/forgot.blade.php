@extends('layouts.app')

@section('content')
<div>
    <div>
      <p><b>Восстановление пароля</b></p>
    </div>
<div>       @if(session('error'))
            <p class="alert alert-danger w-100">{{ session('error') }}</p>
            @endif
            @if(session('message'))
            <p class="alert alert-success w-100">{{ session('message') }}</p>
            @else
            <form name="forgot" method="POST" action="/forgot">
            {{ csrf_field() }}
            <p><i>Email </i><input type="email" name="email"></p>
            <p>
                <input type="submit" value="Восстановление">
            </p>
        </form>
           @endif
    </div>
</div>
@endsection