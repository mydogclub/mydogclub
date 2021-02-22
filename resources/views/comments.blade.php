<section id="comments">
            <h2>Коментарии:</h2>                        
            </section>
            <button id="moreComments" type="button" class="btn btn-primary mb-5 leave-comment" title="Еще комментарии">Еще комментарии</button>
            <form id="showComments" method="POST" action="{{ url('/comments') }}">
              {{ csrf_field() }}
              <input id="commentCount" type="hidden" name="commentCount" value="{{ $commentCount }}">
              <input id="displayed_comments" type="hidden" name="displayed_comments" value="0">
              <input type="hidden" name="source_id" value="{{ $source_id }}">
              <input type="hidden" name="type" value="{{ $type }}">              
            </form>
          @guest
          <h2>Комментарии могут оставлять только зарегестрированные пользователи</h2>
          @else
          <h2>Написать комментарий</h2>
          <form id="addComment" method="POST" action="{{ url('/addComment') }}">
            {{ csrf_field() }}
              <input type="hidden" name="source_id" value="{{ $source_id }}">
              <input type="hidden" name="type" value="{{ $type }}">
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">                
              <div class="form-group">                
                <textarea id="commentText" class="form-control" name="text" maxlength="500" rows="5" required="required"></textarea>
                 <div class="alert alert-danger" style="display: none" id="addCommentError"></div>
              </div>
              <div class="d-flex justify-content-end"> 
                <button type="button" class="btn btn-primary mb-5 leave-comment" title="Оставить комментарий">Оставить комментарий</button>
              </div>             
          </form>          
          @endguest
<script>  
  var viewComments = true;
</script>