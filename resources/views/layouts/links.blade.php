<div id="share">
<div class="social" data-url="{{ url()->current() }}" data-title="{{ env('APP_NAME') }} @if(isset($title)){{ '| '.$title }}@endif">
    <p class="liked">Понравилось? Поделитесь с друзьями!</P>
<p>
<a class="push facebook" data-id="fb"><i class="fab fa-facebook-f"></i></a>
<a class="push twitter" data-id="tw"><i class="fab fa-twitter"></i></a>
<a class="push vkontakte" data-id="vk"><i class="fab fa-vk"></i></a>
<a class="push odnoklassniki" data-id="ok"><i class="fab fa-odnoklassniki"></i></a>
<a class="push pinterest" data-id="pt"><i class="fab fa-pinterest-p"></i></a>
</p>
</div>
</div>