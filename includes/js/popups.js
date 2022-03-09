jQuery(document).ready(function($) {

    $('.imdb-popup-click').on('click',function (){
        var  id = this.id;
        var url = $('#imdb-p-url-'+id).val();
        var tube = $('#imdb-p-tube-'+id).val();
        var autoplay = $('#imdb-p-autoplay-'+id).val();
        $.ajax({
            url: url+'includes/external/popups.php',
            dataType: 'html',
            type:'post',
            data:{
                imdb_id: id,
                tube:tube,
                autoplay:autoplay
            },
            success: function (data){
              $('#pop-up-here-'+id).html(data);
                $('.imdb-popup-overlay').css('z-index',99999999);
                return false;

            }
        });
        return false;
    });

    $(document).on('click','.imdb-p-close',function (){

        $('.imdb-popup-overlay').remove();
        return false;
    });
})