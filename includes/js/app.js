jQuery(document).ready(function ($){
    $('#imdb-fetch').on('click',function (e){
        $('#imdb-fetch').val('Loading...');
        var shimdbURL = $('#shimdbURL').val();
        var listPage = $('#list-page').val();
        $.ajax({
            type: "POST",
            url: shimdbURL+'includes/external/fetch.php',
            dataType: "json",
            data: { "imdb-id": jQuery('#imdb-id').val(),
                    "imdb-type": jQuery('#imdb-type').val()
                    },
            success: function( data ){
                var cache = data.cachenow;
                var adminLink = data.adminLink;
                var Title = data.title;
                var imdbIndex = jQuery('#imdbIndex');
                imdbIndex.html("");
                if(cache==="False") {
                    if(typeof Title !== 'undefined') {
                        imdbIndex.html('<h3 style="color:green">The list named "' + Title + '" was added to the database. You can have a look <a href="' + adminLink + '">here</a>.</h3>');
                    }else{
                        imdbIndex.html('<span style="color:red">Check the id. It is not a list.</span>');
                    }
                }else{
                    imdbIndex.html('<span style="color:red">You alreay have this list.</span>');
                }
                jQuery('#imdb-fetch').val('Fetch');
            },

        });

    });
})