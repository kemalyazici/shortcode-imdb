jQuery(document).ready(function($) {
    var selectType = $('#imdb-list-type')
    selectType.on('change',function (e){
        var Type = selectType.val();
        $('.imdb-add-new-container').html('');
        if(Type === 'title'){
            $('.imdb-add-new-inbox').html('<label for="imdb-add-new-title">Add Title </label><input type="text" id="imdb-add-new" class="form-control" placeholder="example: tt0120737"> <input class="button" id="add_imdb_item" type="button" value="Add">');
        }else if(Type === 'name'){
            $('.imdb-add-new-inbox').html('<label for="imdb-add-new-name">Add Name </label><input type="text" id="imdb-add-new" class="form-control" placeholder="example: nm0005212"> <input class="button" id="add_imdb_item" type="button" value="Add">');
        }else if(Type === 'image'){
            $('.imdb-add-new-inbox').html('<label for="imdb-add-new-image">Add Image </label><input type="text" id="imdb-add-new" class="form-control" placeholder="example: https://www.imdb.com/title/tt0120737/mediaviewer/rm3986930176"> <input class="button" id="add_imdb_item" type="button" value="Add">');
        }else if(Type === 'video'){
            $('.imdb-add-new-inbox').html('<label for="imdb-add-new-video">Add Video </label><input type="text" id="imdb-add-new" class="form-control" placeholder="example: vi2073101337"> <input class="button" type="button" id="add_imdb_item" value="Add">');
        }else if(Type === '-'){
            $('.imdb-add-new-inbox').html('');
        }

        $('#add_imdb_item').on('click',function (e){

            $('#add_imdb_item').val('adding...');

            var shimdbURL = $('#shimdbURL').val();
            $.ajax({
                type: "POST",
                url: shimdbURL+'includes/external/fetch.php',
                dataType: "json",
                data: { "imdb-id": jQuery('#imdb-add-new').val(),
                    "imdb-added": jQuery('#imdb-added').val(),
                    "imdb-type": Type,
                },
                success: function( data ){
                    if(data.addedCheck!=="false") {
                        var imdbID = jQuery('#imdb-add-new').val();
                        var html = "";
                        var $k = 0;
                        var newVal = 0;
                        if(data.content.error==="no") {
                            if (Type === "title") {
                                html += "<div class='imdb-add-container sortable " + imdbID + "'>";

                                html += "<div class='imdb-add-row'>";
                                html += "<div class='imdb-add-poster'><img src='" + data.content.poster + "'><div style='clear: both'></div></div>";
                                html += "<div class='imdb-add-content'><div class='imdb-add-close'><a href='#' data-id='" + imdbID + "' class='imdb-close-click'><img src='" + shimdbURL + "includes/assets/close.png'/></a></div>" +
                                    "<div class='imdb-add-title'><span class='imdb-order-number'></span><a href='https://imdb.com/title/" + imdbID + "' target='_blank'>"
                                    + data.content.title +
                                    " (" + data.content.year + ")" +
                                    "</a></div>" +
                                    "<div class='imdb-add-genre'>" + data.content.genres + "</div>" +
                                    "<div class='imdb-add-desc'>" +
                                    "<label for='sum'>Summary</label>" +
                                    "<textarea placeholder='You can enter a summary here...' name='imdb_desc[]'>" + data.content.sum + "</textarea>" +
                                    "</div>" +
                                    "<div class='imdb-add-desc'>" +
                                    "<label for='desc'>Description</label>" +
                                    "<textarea placeholder='You can enter a description here...' name='imdb_list_desc[]'></textarea>" +
                                    "<div style='clear: both'></div>" +
                                    "<input name='imdb_list_values[]' type='hidden' value='" + data.enc + "' class='imdb_list_value'>" +
                                    "</div>";
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            } else if (Type === "name") {
                                html += "<div class='imdb-add-container sortable " + imdbID + "'>";

                                html += "<div class='imdb-add-row'>";
                                html += "<div class='imdb-add-poster'><img src='" + data.content.photo + "'><div style='clear: both'></div></div>";
                                html += "<div class='imdb-add-content'><div class='imdb-add-close'><a href='#' data-id='" + imdbID + "' class='imdb-close-click'><img src='" + shimdbURL + "includes/assets/close.png'/></a></div>" +
                                    "<div class='imdb-add-title'><span class='imdb-order-number'></span><a href='https://imdb.com/title/" + imdbID + "' target='_blank'>"
                                    + data.content.name +
                                    "</a></div>" +
                                    "<div class='imdb-add-desc'>" +
                                    "<label for='sum'>Bio</label>" +
                                    "<textarea placeholder='You can enter a bio here...' name='imdb_desc[]'>" + data.content.bio + "</textarea>" +
                                    "</div>" +
                                    "<div class='imdb-add-desc'>" +
                                    "<label for='desc'>Description</label>" +
                                    "<textarea placeholder='You can enter a description here...' name='imdb_list_desc[]'></textarea>" +
                                    "<div style='clear: both'></div>" +
                                    "<input name='imdb_list_values[]' type='hidden' value='" + data.enc + "' class='imdb_list_value'>" +
                                    "</div>";
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }


                        }else{
                            jQuery('.imdb-add-new-container').append('<div id="hideMe">You id is not valid..</div>');
                        }
                        jQuery('.imdb-add-new-container').append(html);
                        jQuery('#imdb-added').val(data.added);
                    }else{
                        jQuery('.imdb-add-new-container').append('<div id="hideMe">You already added this id..</div>');
                    }

                    var $lis = jQuery('.imdb-order-number');
                    $lis.each(function() {
                        newVal++
                        $(this).html(newVal+". ");
                    });
                    jQuery('#add_imdb_item').val('Add');
                },

            });

        });

    });



})