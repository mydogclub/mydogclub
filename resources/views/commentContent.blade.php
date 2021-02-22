@foreach($comments as $item)
<div class="row comment my-3 mx-1">       
                <div class="col-12 d-flex">
                    <div>
                      <img src="{{ asset('image/avatar/'.$item->user->profile->avatar) }}" class="avatar" alt="{{ $item->user->profile->name}}">                
                    </div>
                    <div class="comment-author align-self-end ml-3">    
                        <h5 onclick="showProfileUser({{ $item->user->id }});return false;">{{ $item->user->profile->name}}</h5>
                        <span class="small-comment">{{ $item->created_at->format('d.m.Y') }} в {{ $item->created_at->format('H-i') }}</span>             
                    </div> 
                </div>
                    <div class="col-12 mt-3">
                      {!! $item->text !!}                      
                    </div>
                    @can('delComment', $item)
                    <form id="_{{ $item->id }}" action="/comments/{{ $item->id }}" method="POST" class="d-none">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="submit" value="submit" name="">                    
                    </form> 
                    <a class="deleteComment" href="javascript:deleteComment({{ $item->id }});" title="Удалить комментарий"><i class="fas fa-times-circle"></i></a>
                     @endcan
                     
                                
                           
</div>
@endforeach