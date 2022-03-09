jQuery(document).ready(function($) {

    $('.imdb-add-new-container').sortable({
        items: '.sortable',
        update:function (event,ui){
            var $lis = jQuery('.imdb-order-number');
            var newVal = 0;
            $lis.each(function (){
                newVal++;
                $(this).html(newVal+". ");
            })
        }
    });

})