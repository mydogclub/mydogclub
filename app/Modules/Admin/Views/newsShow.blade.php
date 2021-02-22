@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
    {{ session('status') }}
  </div>                      
 @endif
<div class="container pb-5">
 <div class="row py-3">
  <h4>Новости</h4>
  <div class="col-12">
    <a href="{{ url('/admin/news') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
  </div>
 </div>
 <div class="row">      
    <div class="card col-12" style="background-color: #DCDCDC;">                      
        <div class="w-50">
            <img src="{{ asset('image/news').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img }}max.jpg" class="card-img-top mt-3" alt="*">
        </div> 
      <div class="card-body">
        <form action="/admin/news/upload" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $item->id }}">
            <input type="hidden" name="img" value="{{ $item->img }}">
                <input type="file" name="image">
                <input type="submit" name="Загрузить">
             </form>
             <div class="d-flex justify-content-between mt-3" style="border: 1px solid gray"><p>Автор новости:{{ $item->user->name}}</p><p> Дата создания:{{ $item->created_at->format('d.m.Y')}}</p><p> Дата обновления:{{ $item->updated_at->format('d.m.Y')}}</p></div>
        <form method="POST" action="/admin/news/update" id="newsedit">
          {{ csrf_field() }}          
          <input type="hidden" name="id" value="{{ $item->id }}">         
          <small style="color: #0000FF;">Title/Заголовок</small>
          <span id="title"></span>          
          <input class="form-control" type="text" name="title" value="{{ $item->title }}" required>         
          <small style="color: #0000FF;">Alias/Псевдоним</small>
          <input class="form-control" type="text" id="alias" name="alias" value="{{ $item->alias }}">
          <small style="color: #0000FF;">Keywords/Ключевые слова через запятую</small>
          <input class="form-control" type="text" name="keywords" value="{{ $item->keywords }}" required>
          <small style="color: #0000FF;">Desc/Краткое описание</small>
          <textarea class="form-control" name="desc" rows="5">{!! $item->description !!}</textarea>
          <small style="color: #0000FF;">Text/Описание</small>
          <textarea class="form-control" name="text" rows="5">{!! $item->text !!}</textarea>
          <div class="d-flex justify-content-between mt-2">
          <button type="submit" class="btn btn-success">Сохранить</button>
          <a href="{{ url('/admin/news/destroy', $item->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a></div> 
        </form>
      </div>
    </div>
    </div>
     <div class="row py-3">
         <div class="col-12">
         <a href="{{ url('/admin/news') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
        </div>
        </div>    
</div>
<script>

$(document).ready(function() {
  var inputTitle = $('#newsedit input[name = "title"]').val();
  $.ajaxSetup({
      headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
               });   
    $('#newsedit input[name = "title"]').blur(function()
      {
       if (inputTitle.localeCompare($(this).val())) 
       {                                
      $.ajax({                
                  type: 'POST',
                  url: '/ajax',                  
                  data: {           
              procedure:'validNewsTitle',
            title:$(this).val(),
            },
                  cache: false,              
                  success: function(result){
                   $('#title').text(result.message);
                   if (result.error == 1) {color = 'red';$('#newsedit button').attr('disabled', true)}
                   if (result.error == 0) {color = 'green';$('#alias').val(result.alias);$('#newsedit button').attr('disabled', false)}
                      $('#title').css('color', color);
                                           }                  
               });
        } 
      });
});

</script>

@endsection