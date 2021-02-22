<div class="row position-sticky top-0">
<nav class="navbar navbar-expand-lg navbar-dark bg-gray py-0">
          <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

            <div class="collapse navbar-collapse" id="navbars">
                    <ul class="navbar-nav mr-auto">
                     @php                     
    function buildMenu($items, $parent)
    {
        foreach ($items as $item) {
            $str = '/'.Request::path();
            $str= ($str== $item->path) ? ' active' : '';
            if (isset($item->children)) {            
            @endphp
                <li class="nav-item dropdown {{ $str }}">
                    <a href="{{ $item->path }}"
                        class="nav-link dropdown-toggle py-sm-2 py-lg-3 px-4"
                        id="navbarDropdown"                        
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        role="button"
                    >
                        {{ $item->title }}
                    </a>
                    <div class="dropdown-menu bg-gray" aria-labelledby="navbarDropdown">
                        @php buildMenu($item->children, $item->id) @endphp
                    </div>
                </li>
            @php
            } else {
              if($parent == 0 && $item->parent == 0){
            @endphp
                <li class="nav-item {{ $str }}">
                    <a href="{{ $item->path }}" class="nav-link py-sm-2 py-lg-3 px-3">{{ $item->title }}</a>
                </li>
            @php
             }
             else{
                 if($item->parent == $parent){                  
                 @endphp
                 <a class="dropdown-item" href="{{ $item->path }}">{{ $item->title }}</a>
                 @php
               }
              }
            }
        }
    }

    buildMenu($menuItems, 0)
    @endphp              
                     
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="https://google.com/search" id="search_form">
                      <div class="input-group stylish-input-group">                           
                          <input name="q" value="" class="form-control" placeholder="Поиск">
                            <input type="hidden" name="q" value="site:https://my-dog.club">
                                <span class="input-group-addon">
                                    <button type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>  
                                </span>                                                      
                      </div>
                    </form>
            </div>
              <div class="align-items-center mobile-login">
                  <i class="fas fa-sign-in-alt"></i>
              </div>
          </div>
    </nav> 
</div>
