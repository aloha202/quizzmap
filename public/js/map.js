$(function (){

    const dim_x = 3;
    const dim_y = 2;

    const width = Math.ceil($('#map').width()/dim_x);
    const height = Math.ceil($('#map').height()/dim_y);


    for(let i = 0; i < dim_y; i++){
        for(let j = 0; j < dim_x; j++){

            const id = 'over_' + i + '_' + j;

            $("#map").append(("<div class='overshadow' id='%id%'></div>").replace('%id%', id));

            $('#' + id).css({
                left: width * j,
                top: height * i,
                width: width,
                height: height
            });

          //  $('body').scrollTo({x: width, y: 2000});


        }
    }
    $('#over_1_1').remove();


    $('html, body').animate({
        scrollTop: $('#map').height() - $(window).height(),
        scrollLeft: ($('#map').width() - $(window).width()) /2
    });

    $('.location').click(function (){

    });


    $('.question .button-next').prop('disabled', true);
    $('.question .button-next').click(function(){
       if($(this).prop("type") == 'button'){
           var next = $(this).parents('.question').next('.question');
           $(this).parents('.question').fadeOut(function (){
              next.fadeIn();
           });
       }
    });
    $('.question .button-previous').click(function(){
        var prev = $(this).parents('.question').prev('.question');
        $(this).parents('.question').fadeOut(function (){
            prev.fadeIn();
        });
    });

    $('.question .choice-question input').change(function (){
       $(this).parents('.question').find('.button-next').prop('disabled', false);
    });
    $('.questions .question').each(function (index){
       if(index){
           $(this).hide();
       }
    });

    if($('.parser-question').length){
        setInterval(function (){
            $('.parser-question').each(function (){
                let allFilled = true;
                var parent = $(this).parents('.question');
                $('.parser-question').find('select, input').each(function (){
                    if(!$(this).val()){
                        allFilled = false;
                    }
                });
                if(allFilled){
                    parent.find('.button-next').prop('disabled', false);
                }else{
                    parent.find('.button-next').prop('disabled', true);
                }
            })
        }, 1000);
    }

})