@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
  	{{ session('status') }}
  </div>                      
 @endif
<div class="container">
	<h4>Категории разделов вопросов/ответов</h4>
        @if(!empty($category))
        <div class="col-12">
	 <table class="table">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">id</th>
		      <th scope="col">Заголовок</th>	      		      
		      <th scope="col">Редактор</th>		           
		    </tr>
		  </thead>
           <tbody>
         @foreach($category as $item)
		<tr> 
			<td>{{ $item->id }}</td>
			<td>{{ $item->name }}</td>			
                        <td><button onclick="edit({{ $item->id }}, '{{ $item->name }}')" class="btn btn-success"><i class="fas fa-pen-fancy"></i></button>
                            <a href="/admin/qa/categoryDelete/{{ $item->id }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                        </td>
		</tr>		
		@endforeach
           </tbody>
	 </table>        
        </div>
        @endif
        <div class="col-12 mt-5">
            <form action="/admin/qa/categoryUpdate" method="POST">
                         {{ csrf_field() }}
                         <input id="id" type="hidden" name="id" value="0">
                         <label>Категории вопросов</label>
                         <input id="name" type="text" name="name" value="">                                          
                         <button type="submit" class="btn btn-success">Добавить/Изменить                       
                      </button>           
            </form>
            
        </div>

</div>
 <script>
     function edit(id, name){
         document.querySelector("#id").value=id;
         document.querySelector("#name").value=name;
     }
 </script>
@endsection

