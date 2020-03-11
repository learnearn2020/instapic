var url='http://blog.com.devel/';
window.addEventListener('load',function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    $('.like').css('cursor','pointer');
    $('.dislike').css('cursor','pointer');

    function dislike(){
        $('.like').unbind('click').click(function(){
            console.log('dislike');
            $(this).attr('src',url+'/img/heart-white.png');
             $(this).removeClass('like').addClass('dislike');
             like();
             $.ajax({
                    url:url+'dislike/'+$(this).data('id'),
                    type:'GET',
                    message:function(response){
                        console.log(response);
                    }

             });
        });
    }
    dislike();
    function like(){
        $('.dislike').unbind('click').click(function(){
            console.log('like');
            $(this).attr('src',url+'/img/heart-blue.png');
             $(this).removeClass('dislike').addClass('like');
             dislike();
             $.ajax({
                url:url+'like/'+$(this).data('id'),
                type:'GET',
                message:function(response){
                    console.log(response);
                }

         });
        });
    }
    like();
    $("#search-form").submit(function(){
        $(this).attr('action','http://blog.com.devel/users/'+$('#search').val());
    });
});
