jQuery(document).ready(function($) {
    var selectType = $('#imdb-list-type');
    selectType.css('backgroundColor', 'rgb(41,41,41)');
    selectType.css('textColor', '#fff');

    $('.add-new-btn').on('click', function (e){
        var values = $('input[name="imdb_list_values[]"]').map(function(){
            return this.value;
        }).get();

        var descs = $('textarea[name="imdb_desc[]"]').map(function(){
            return this.value;
        }).get();
        var listDescs = $('textarea[name="imdb_list_desc[]"]').map(function(){
            return this.value;
        }).get();

        var shimdbURL = $('#shimdbURL').val();
        var adminURL = $('#adminURL').val();
          var Type = selectType.val();
        $.ajax({
            type: "POST",
            url: shimdbURL+'includes/external/addlist.php',
            dataType: "html",
            data: { "imdb-val[]": values,
                "imdb-type": Type,
                "imdb-title": jQuery('#imdb-add-title').val(),
                "desc": descs,
                "listDesc": listDescs,
            },
            success:function (data){
                if(data==="ok"){
                    $(location).attr('href', adminURL);
                }else {
                    jQuery('.imdb-top').append(data);
                }
            }
        });

    })



})