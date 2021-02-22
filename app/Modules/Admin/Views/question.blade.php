@extends('Admin::app')

@section('content')
@if (session('status'))
  <div>
  	{{ session('status') }}
  </div>                      
 @endif
<div class="container">
	<h4>Список вопросов</h4>
        @if(!empty($question))
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
         @foreach($question as $item)
		<tr> 
			<td>{{ $item->id }}</td>
                        <td><a href="/admin/answer?category={{ $item->id }}">{{ $item->title }}({{ $item->answers()->count() }})</a></td>			
                        <td><a href="/admin/qa/questionDelete/{{ $item->id }}" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
		</tr>		
		@endforeach
           </tbody>
	 </table>        
        </div>
        <nav aria-label="Page navigation example" id="Pagination">
                {{ $question->links('layouts.paginate') }}
    </nav>
        @endif
</div>
 
@endsection

