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

})