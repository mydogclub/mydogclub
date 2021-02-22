           <div id="poll" class="position-relative">
            <form method="POST" action="/poll">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $pollId }}">
              <p class="h2 block-title ">у вас уже есть<br> собака?</p>          
                 <div>
                    <label>
                    <input class="poll-check" type="radio" name="choice1" value="yes"><span></span>да
                    </label>
                    <label class="ml-4">
                    <input class="poll-check" type="radio" checked name="choice1" value="no"><span></span>нет
                    </label>
                 </div>
                 <h2 class="block-title">вы собираетесь<br> завести собаку?</h2>                
                 <div>
                    <label>
                    <input class="poll-check" type="radio" name="choice2" value="yes"><span></span>дa
                    </label>
                    <label class="ml-4">
                    <input class="poll-check" type="radio" checked name="choice2" value="no"><span></span>нет
                    </label>
                 </div>
                 <h2 class="block-title">вы опытный<br> собаковод?</h2>     
                 <div>
                    <label>
                    <input class="poll-check" type="radio" name="choice3" value="yes"><span></span>дa
                    </label>
                    <label class="ml-4">
                    <input class="poll-check" type="radio" checked name="choice3" value="no"><span></span>нет
                    </label>
                 </div>
                 <h2 class="block-title">вам был полезен<br> наш сайт?</h2> 
                 <div>
                    <label>
                    <input class="poll-check" type="radio" name="choice4" value="yes"><span></span>дa
                    </label>
                    <label class="ml-4">
                    <input class="poll-check" type="radio" checked name="choice4" value="no"><span></span>нет
                    </label>
                 </div>
                  <button class="btn btn-primary vote" type="submit" name="run-vote" title="Голосовать">голосовать</button>   
                </form>
                  <button data-href="/poll/{{ $pollId }}" class="btn btn-primary vote" id="showPoll">Результаты</button>
              </div> 