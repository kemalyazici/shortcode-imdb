jQuery(document).ready(function($) {

    $(document).on("click",".imdb-close-click",function (e){
        var imdbId = jQuery(this).data('id');
        var newVal = 0;
        var shimdbURL = $('#shimdbURL').val();
        if (window.confirm("Are you sure? This data will be removed from your list!")) {
            $.ajax({
                type: "POST",
                url: shimdbURL + 'includes/external/removal.php',
                dataType: "html",
                data: {
                    "imdb-id": imdbId,
                    "ids": jQuery('#imdb-added').val(),
                },
                success: function (data) {

                    jQuery("." + imdbId).remove();
                    jQuery('#imdb-added').val(data);
                    var $lis = jQuery('.imdb-order-number');
                    $lis.each(function(e) {
                        newVal++
                        $(this).html(newVal+". ");
                    });

                }

            })
        }

    });



})