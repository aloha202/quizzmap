$(function (){



    if($('#Question_type').length) {
        const qt_change = function () {
            alert($(this).val());
        }


        /*
        setInterval(function (){
            console.log($('#Question_type').val());
        }, 1000);

         */
        $('#Question_type').change(function (){
           if($(this).val() == 1){
               $('.admin-answers-collection').show();
           } else {
                $('.admin-answers-collection').hide();
           }
        });
        $('#Question_type').change();

    }





})