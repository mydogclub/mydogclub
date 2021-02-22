@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
  	{{ session('status') }}
  </div>                      
 @endif
<div class="container pb-5">
 <div class="row py-3">
 	<h4>Болезни</h4>
 	<div class="col-12">
 		<a href="{{ url('/admin/diseases') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
 	</div>
 </div>
 <div class="row">	    
		<div class="card col-12" style="background-color: #DCDCDC;">
          <div class="container">
		      <div class="row">		  
			  	<div class="col-6">
			  		<img src="{{ asset('image/diseases').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img }}max.jpg" class="card-img-top mt-3" alt="*">			  		
			  	</div>
			  	<div class="col-6 bg-light d-flex justify-content-center flex-wrap" style="overflow-y: auto;max-height: 400px;">
			  		@foreach($files as $img)
			  		<div class="border border-primary p-0 mb-1">
			  			<img src="{{ asset('image/diseases/'.$item->id).'/'.$img }}">
			  			<p><button class="btn btn-info" onclick="copyToClipboard('/image/diseases/{{ $item->id }}/{{ $img }}');">Копировать ссылку</button>
                                                   <button class="btn btn-danger" onclick="deleteImage('/image/diseases/{{ $item->id }}/{{ $img }}', this);">Удалить</button>
                                                </p>
			  		</div>
			  		@endforeach			  		
			  	</div>
			  	<div class="col-6 mt-3">
			  		<form action="/admin/diseases/upload" method="POST" enctype="multipart/form-data">
				        {{ csrf_field() }}
				        <input type="hidden" name="id" value="{{ $item->id }}">
				        <input type="hidden" name="img" value="{{ $item->img }}">
		                <input type="file" name="image">
		                <input type="submit" value="Загрузить" name="mainPhoto">
		            </form>
			  	</div>
			  	<div class="col-6 mt-3">
			  		<form action="/admin/diseases/upload" method="POST" enctype="multipart/form-data">
			  			{{ csrf_field() }}
			  			<input type="hidden" name="id" value="{{ $item->id }}">
		             	<input type="file" name="img[]" multiple>
		                <input type="submit" value="Загрузить" name="otherPhotos">
		            </form>
			  	</div>
		  	</div>
		   </div>	 
		  <div class="card-body">            
             <div class="d-flex justify-content-between mt-3" style="border: 1px solid gray"><p>Автор статьи:{{ $item->user->name}}</p><p> Дата создания:{{ $item->created_at->format('d.m.Y')}}</p><p> Дата обновления:{{ $item->updated_at->format('d.m.Y')}}</p></div>
		    <form method="POST" action="/admin/diseases/update" id="diseasesedit">
		    	{{ csrf_field() }}		    	
		    	<input type="hidden" name="id" value="{{ $item->id }}">		    	
		    	<small style="color: #0000FF;">Title/Заголовок</small>
		    	<span id="title"></span>		    	
		    	<input class="form-control" type="text" name="title" value="{{ $item->title }}" required>		    	
		    	<small style="color: #0000FF;">Alias/Псевдоним</small>
		    	<input class="form-control" type="text" id="alias" name="alias" value="{{ $item->alias }}">
		    	<small style="color: #0000FF;">Keywords/Ключевые слова через запятую</small>
		    	<input class="form-control" type="text" name="keywords" value="{{ $item->keywords }}" required>
                                                          <small style="color: #0000FF;">Description/Краткое описание</small>
		    	<input class="form-control" type="text" name="description" value="{{ $item->description }}" required>
		    	<small style="color: #0000FF;">Text/Описание</small>
		    	<textarea class="form-control" name="text" rows="20" id="editor">{!! $item->text !!}</textarea>
		    	<div class="d-flex justify-content-between mt-2">
		    	<button type="submit" class="btn btn-success">Сохранить</button>
		    	<a href="{{ url('/admin/diseases/destroy', $item->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a></div>          	
		    </form>
		  </div>
		</div>
	  </div>
		 <div class="row py-3">
 	       <div class="col-12">
 		     <a href="{{ url('/admin/diseases') }}" class="btn btn-success"><i class="fas fa-arrow-left"></i></a>
 	      </div>
        </div>		
</div>
<script>

$(document).ready(function() {
	var inputTitle = $('#diseasesedit input[name = "title"]').val();	
	$.ajaxSetup({
      headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
               });    
    $('#diseasesedit input[name = "title"]').blur(function()
      {
       if (inputTitle.localeCompare($(this).val())) 
       {                                
      $.ajax({                
                  type: 'POST',
                  url: '/ajax',                  
                  data: {						
					    procedure:'validDiseasesTitle',
						title:$(this).val(),
						},
                  cache: false,              
                  success: function(result){
                   $('#title').text(result.message);
                   if (result.error == 1) {color = 'red';$('#diseasesedit button').attr('disabled', true)}
                   if (result.error == 0) {color = 'green';$('#alias').val(result.alias);$('#diseasesedit button').attr('disabled', false)}
                   		$('#title').css('color', color);
                                           }                  
               });
        } 
      });
});


	function copyToClipboard(text) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val(text).select();
	document.execCommand("copy");
	$temp.remove();
	}
        function deleteImage(urlImage, elem){
            $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
               });
         $.ajax({                
                  type: 'POST',
                  url: '/admin/diseases/delImage',                  
                  data: { 
                         _token:$('meta[name="csrf-token"]').attr('content'),
                         url:urlImage,
			},
                  cache: false,              
                  success: function(result){
                  $(elem).parent().parent().remove();                                           }                  
               });
        }

</script> 


@endsection