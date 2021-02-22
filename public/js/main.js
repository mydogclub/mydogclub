(function($, undefined){
		$(function(){
/*
Регистрация
*/
			$('.registration-user div h6 span').click(function(){
			   var target = $(this).data('target');
			   $('.registration-user form').hide();			   
               $(target).show();               
			});
/*
*/
            $('#registration').submit(function(){
               $(this).hide();
               $('#registration').submit();
            });
            $('#login').submit(function(){
               $(this).hide();
               $('#login').submit();
            });
            $('#search_form').submit(function(e){
              e.preventDefault();
              var action = $(this).attr('action');
              var data = $(this).serialize();              
              window.open(action+"?"+data);
              return false;
            });

            $('#addComment button').click(function(){               
               addComment();
            });

            $('#moreComments').click(function(){
               showComments();
            });

            $('#showPoll').click(function(){
               $.ajax({                
                  type: 'GET',
                  url: $(this).data('href'),                  
                  cache: false,              
                  success: function(result){
                  $('#poll').find('form').hide();
                  $('#poll').html(result);
                                           }
               });
               return false; 
            });

            $('.scrollup').fadeOut();
            $(window).scroll(function(){
            if ($(this).scrollTop() > 300) {
            $('.scrollup').fadeIn();
            } else {
            $('.scrollup').fadeOut();
            }
            });

            $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 1000);
            return false;
            });
            
            if (typeof viewComments!=='undefined') {
               showComments();
            }
            $(function () {
             $('[data-toggle="tooltip"]').tooltip()              
             });
            $('.mobile-login').click(function(){
                $('.registration-user').toggle();
            });   

});
	})(jQuery);

   
            var listBreed = document.querySelectorAll('.listBreed>h2');
            var infoBreed = document.querySelectorAll('.infoBreed');
            var listBreedOpen = document.querySelectorAll('.listBreedOpen');         

            for (let i = 0; i < listBreed.length; i++) {
               listBreed[i].addEventListener('click',function(elem){
            if(listBreedOpen[i].innerText=="+"){
              if ($(this).data('count')=='0')
              {
                addListBreed($(this).data('letter'),this)
              }             
              listBreedOpen[i].innerText = "-";}
            else listBreedOpen[i].innerText = "+";
               infoBreed[i].classList.toggle('show');                       
                                                                });
                                                       }

          function addListBreed(letter, elem)
          {
            $('#formListBreed input[name="letter"]').val(letter)
               var form = $('#formListBreed');
               var action = form.attr('action');
               var data = form.serialize();
               $.ajax({                
                  type: 'POST',
                  url: action,
                  data: data,
                  cache: false,              
                  success: function(result){
                 $(elem).next('.infoBreed').html(result);
                 $(elem).data('count',1);
                                           }
               }); 

          }
          function showComments()
            {  
               var form = $('#showComments');
               var action = form.attr('action');
               var data = form.serialize();
               $.ajax({                
                  type: 'POST',
                  url: action,
                  data: data,
                  cache: false,              
                  success: function(result){
                  $('#comments').append(result.comment);
                  if($('#commentCount').val()<=result.displayed_comments){
                     $('#moreComments').css('display', 'none');
                  }
                  $('#displayed_comments').val(result.displayed_comments);
                                           }
               });
            } 

         function addComment(){
            var form = $('#addComment');
            var action = form.attr('action');
            var data = form.serialize();
            var text = $('#commentText').val();
            if(text.length<=5){
               $('#addCommentError').css('display', 'block');
               $('#addCommentError').html('Комментарий не менее 6 символов');
               return false;
            }            
            $.ajax({                
                  type: 'POST',
                  url: action,
                  data: data,
                  cache: false,              
                  success: function(result){                  
                  $('#comments').html(result.comment);
                  $('#commentText').val('');
                  $('#commentCount').val(result.commentCount);
                  $('#commentCountShow').html(result.commentCount);
                                          },
                  error: function(error){
                  $('#addCommentError').css('display', 'block');
                  $('#addCommentError').html(error);
                  }
                  });
            return false;
         }

         function deleteComment(id){            
            var form = $("#_"+id);            
            form.submit();
         }

         $('.newbtn').bind("click" , function() {
           $('#pic').click();
          });
 
         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function showProfileUser(id)
        {         
         var action = '/profile/'+id;
         $.ajax({                
                  type: 'GET',
                  url: action,                  
                  cache: false,              
                  success: function(result){                  
                  $('#profileModal .modal-body').html(result);
                  $('#profileModal').modal('show');                  
                                          }                
                  });
            return false;

        }
        
        
        
        
var Shares = {
title: 'Поделиться',
width: 700,
height: 800,

init: function() {
var share = document.querySelectorAll('.social');
for(var i = 0, l = share.length; i < l; i++) {
var url = share[i].getAttribute('data-url') || location.href, title = share[i].getAttribute('data-title') || '',
desc = share[i].getAttribute('data-desc') || '', el = share[i].querySelectorAll('a');
for(var a = 0, al = el.length; a < al; a++) {
var id = el[a].getAttribute('data-id');
if(id)
this.addEventListener(el[a], 'click', {id: id, url: url, title: title, desc: desc});
}
}
},

addEventListener: function(el, eventName, opt) {
var _this = this, handler = function() {
_this.share(opt.id, opt.url, opt.title, opt.desc);
};
if(el.addEventListener) {
el.addEventListener(eventName, handler);
} else {
el.attachEvent('on' + eventName, function() {
handler.call(el);
});
}
},

share: function(id, url, title, desc, img) {
url = encodeURIComponent(url);
desc = encodeURIComponent(desc);
title = encodeURIComponent(title);
img = encodeURIComponent(img);
switch(id) {
case 'fb':
this.popupCenter('https://www.facebook.com/sharer/sharer.php?u=' + url, this.title, this.width, this.height);
break;
case 'vk':
this.popupCenter('https://vk.com/share.php?url=' + url + '&description=' + title + '. ' + desc, this.title, this.width, this.height);
break;
case 'tw':
var text = title || desc || '';
if(title.length > 0 && desc.length > 0)
text = title + ' - ' + desc;
if(text.length > 0)
text = '&text=' + text;
this.popupCenter('https://twitter.com/intent/tweet?url=' + url + text, this.title, this.width, this.height);
break;
case 'ok':
this.popupCenter('https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=' + url, this.title, this.width, this.height);
break;
case 'pt':
this.popupCenter('https://pinterest.com/pin/create/button/?url=' + url + '&description=' + desc +'&media=' + img, this.title, this.width, this.height);
break;
}
},

newTab: function(url) {
var win = window.open(url, '_blank');
win.focus();
},

popupCenter: function(url, title, w, h) {
var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;
var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
var left = ((width / 2) - (w / 2)) + dualScreenLeft;
var top = ((height / 3) - (h / 3)) + dualScreenTop;
var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
if (window.focus) {
newWindow.focus();
}
}
};
function goBack() {
window.history.back();
}

// lazyload - \\ отложенная загрузка изображений
document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages;    

  if ("IntersectionObserver" in window) {
    lazyloadImages = document.querySelectorAll("img[data-src]");
    var imageObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          var image = entry.target;
          image.src = image.dataset.src;
          image.removeAttribute("data-src");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function(image) {
      imageObserver.observe(image);
    });
  } else {  
    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll("img[data-src]");
    
    function lazyload () {
      if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }    

      lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.removeAttribute("data-src");
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
  }
})