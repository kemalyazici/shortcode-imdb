jQuery(document).ready(function($) {
    var imdbPage = $('#imdb-list-page');
    var shimdbURL = $('#shimdbURL').val();
    var page = $('#imdb-scroll-page').val();
    var imdbLoadMore = $('#imdbLoadMore');
    var page = 2;
    imdbLoadMore.on('click', function (e){
        $.ajax({
            type: "POST",
            url: shimdbURL+'includes/external/scroll.php',
            dataType: "html",
            data: { "imdb_page": page,
                "imdb_scroll_type": jQuery('#imdb-scroll-type').val(),
                "list_id": jQuery('#imdb-list-id').val(),
                "imdb_id": jQuery('#imdb-list-real-id').val(),
                "arg_show": jQuery('#imdb-arg-show').val(),
                "list_bg": jQuery('#imdb-list-bg').val()
            },
            success: function( data ){
                jQuery('#imdb-scroll-page').val(++page);
                jQuery('#imdb-list-page').append(data);
                if(jQuery("#imdb-list-end-here" ).length !== 0) {
                    imdbLoadMore.hide();
                }
//


            }


        });

    });
})


