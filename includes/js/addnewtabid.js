jQuery(document).ready(function($) {
    //Fetch
    $('#imdb_fetch_for_tab').on('click',function (e){
        var id = $('#imdb_id').val();
        var two = id.substring(0, 2);
        var url = $('#imdb_tab_url').val();
        var type = "none";
        if(two ==="tt"){
            type= "title"
        }else if(two ==="nm"){
            type= "name"
        }
        if(type!=="none"){
           // Buradan başla
            $('#imdb_fetch_for_tab').html('Loading...');
            $.ajax({
                url: url+'includes/external/fetch.php',
                type : 'post',
                dataType: 'json',
                data:{
                    "imdb-id" : id,
                    "imdb-type":type,
                },
                success: function (data){
                    $('#imdb_fetch_for_tab').html('Fetch');
                    $('#imdb_fetch_for_tab').prop('disabled', true);
                    $('#imdb_id').prop('disabled', true);
                    var title = type === "title" ? data.title.title : data.name.name2;
                    $('#imdb_tab_title').val(title);
                    $('#imdb_tab_id').val(id);
                    $('#imdb_info_title').append('<h3>Add tabs for '+title+' <button id="imdb_remove_tab" style="border-radius: 80%!important;padding: 5px!important;font-size:10px!important; border: 0;color:#fafafa;background-color: #c0c0c0;height: 25px;width: 25px" type="button">X</button></h3><div style="color: #0a0a0a; padding:10px; background-color: #f3dc73;border-radius: 3px; font-size: 14px;"><i class="fa fa-warning"></i> If you add only one sub tab, "sub tab title" will be ignored!</div>')

                    $('#imdb_info_tabs').append('<button id="imdb_new_tab" style="background: #0a0a0a;color: #fff" class="button" type="button">Add new main tab</button>');
                }
            })
           // Burada bitir
        }else{
            alert('Please enter a valid imdb id');

        }
    });

    //Remove
    $(document).on('click', '#imdb_remove_tab',function (e){
        if (confirm('Are you sure?')) {
            $('#imdb_fetch_for_tab').prop('disabled', false);
            $('#imdb_id').prop('disabled', false);
            $('#save_imdb_tabs').prop('disabled', true);
            $('#imdb_info_title').html('')
            $('#imdb_info_tabs').html('')
            $('#imdb_info_infos').html('')
        }

    });

    // Add main tabs
    $(document).on('click','#imdb_new_tab',function (e){
            var countID =  $('#imdb_main_count');
            var mainTab =  countID.val();
            var id = $('#imdb_id').val();
            var two = id.substring(0, 2);
            mainTab++;
            countID.val(mainTab);
            $('#save_imdb_tabs').prop('disabled', false);
            var html = '<div style="padding: 10px;margin-top: 10px;margin-bottom: 40px;min-height: 50px;background: #fff;position: relative; border:5px solid #ccc;" id="imdb_main_tab'+mainTab+'" class="imdb_main_tabs">';
            html += '<label><b>Main tab title:</b> </label><input type="text" style="width:50%" id="up_tab_title'+mainTab+'" class="up_tab_title"/>';
            html += '&nbsp;&nbsp;<label><b>Tab Style:</></label>';
            html += '<select id="up_tab_type'+mainTab+'" class="up_tab_types">';
            html += '<option value="side">Side Tabs</option>';
            html += '<option value="accordion">Accordion</option>';
            html += '<option value="select">Select Menu</option>';
            html += '</select>';
            html += '<br/>';
            html += '<div id="imdb_tab_info'+mainTab+'" style="margin-bottom:10px"></div>';
            html += '<div style="background-color: #0a0a0a; color:#fff;padding:15px">';
            html += '<label><b>Select tab type:</b>&nbsp;&nbsp;</label>';
            html += '<select id="select_tab_type'+mainTab+'">';
            if(two === "tt") {
                html += '<option value="cast">Cast</option>';
            }else{
                html += '<option value="filmo">Filmography</option>';
            }
            html += '<option value="text">Text</option>';
            html += '<option value="embed">Embed Video</option>';
            html += '<option value="youtube">Youtube Video</option>';
            html += '<option value="woo">WooCommerce Product</option>';
            html += '</select>';
            html += '<button class="button imdb_add_sub_tabs" id="imdb_add_sub_tab'+mainTab+'" type="button" style="background-color: #d32323;color:#FAFAFA;border: 0;">Add new sub tab</button>';
            html += '</div>';
            html += '<div style="position: absolute;right:5px;top:5px"><button class="button close_main_tabs" type="button" id="close_main_tab'+mainTab+'" style="background: transparent;border: 0; font-size:10px!important;"><i class="fa fa-close"></i></button></div>';
            html += '<input id="imdb_sub_count'+mainTab+'" value="0" type="hidden"/>';
            html += '</div>';
            $('#imdb_info_infos').append(html);
    });

    //Remove main tab
    $(document).on('click','.close_main_tabs',function (e){
        var allid = $(this).attr('id');
        var id = allid.replace('close_main_tab','');
        $('#imdb_main_tab'+id).remove();
    });

    // Add sub tab
    $(document).on('click','.imdb_add_sub_tabs',function (e){
        var allid = $(this).attr('id');
        var id = allid.replace('imdb_add_sub_tab','');
        var count = $('#imdb_sub_count'+id).val();
        count++;
        var type = $('#select_tab_type'+id).val();
        var html = '<div class="sub_tab_items'+id+'" id="sub_tab_item'+id+'-'+count+'" style="background-color: #fafafa;padding: 10px;margin-top: 10px;width: 95%;position:relative;border:1px solid #ccc;">';
        html += '<div style="position: absolute;right:5px;top:5px"><button class="button close_sub_tabs" type="button" id="close_sub_tab'+id+'-'+count+'" style="background: transparent;border: 0; font-size:10px!important;"><i class="fa fa-close"></i></button></div>';
        html += '<label><b>Sub tab title:</b> </label><input type="text" id="sub_tab_title'+id+'-'+count+'" style="width:50%" placeholder="Enter a title...">';
        if(type==="cast"){
                html += '<br/><h3>###title cast will be placed automatically###</h3>';
                html += '<label><b>How to show cast: </b></label><select id="imdb_tab_cast_show'+id+'-'+count+'"><option value="grid">Grid</option><option value="blog">Blog</option></select>';
                html += '<input type="hidden" value="cast" id="sub_tab_type'+id+'-'+count+'">'
        }else if(type==="filmo"){
            html += '<br/><h3>###name filmography will be placed automatically###</h3>';
            html += '<input type="hidden" value="filmo" id="sub_tab_type'+id+'-'+count+'">'
        }
        else if(type === "text"){

            html += '<br/><br/><textarea id="imdb_tab_text'+id+'-'+count+'" class="wp-editor"></textarea>';
            html += '<input type="hidden" value="text" id="sub_tab_type'+id+'-'+count+'">';

        }
        else if(type === "embed"){
            html += '<br/><br/><textarea id="imdb_tab_embed'+id+'-'+count+'" placeholder="Embed code here..." style="width: 95%;"></textarea>';
            html += '<br/><br/><label><b>The ad display time (seconds):&nbsp;&nbsp;&nbsp;</b></label><input type="number" id="imdb_tab_embed_display'+id+'-'+count+'" value="5" style="width: 100px">&nbsp;&nbsp;&nbsp;<b>If you set the seconds to zero, the ad will be ignored!</b>';
            html += '<br/><br/><label><div style="color: #fff; padding:10px; background-color: #6f98af; width: 95%;border-radius: 3px"><i class="fa fa-thumbs-up"></i> You can add your adverb here, it wil be shown before the video!</div></label><br/><textarea id="imdb_tab_embed_adverb'+id+'-'+count+'" placeholder="You can add adverb here"></textarea>';
            html += '<input type="hidden" value="embed" id="sub_tab_type'+id+'-'+count+'">';
        }
        else if(type==="youtube"){
            html += '<br/><br/><label><b>Youtube id:&nbsp;&nbsp;&nbsp;</b></label><input type="text" id="imdb_tab_youtube'+id+'-'+count+'" placeholder="Enter youtube link or id..." style="width: 50%">';
            html += '<input type="hidden" value="youtube" id="sub_tab_type'+id+'-'+count+'">';
        }
        else if(type==="woo"){
            html += '<br/><br/><label><b>Product ids:&nbsp;&nbsp;&nbsp;</b></label><input type="text" id="imdb_tab_woo'+id+'-'+count+'" placeholder="Enter product ids (For Exampe: 1,2,3,4 etc)..." style="width: 50%">';
            html += '<br><br><label><b>How to show products: </b></label><select id="imdb_tab_woo_show'+id+'-'+count+'"><option value="grid">Grid</option><option value="blog">Blog</option></select>';
            html += '<input type="hidden" value="woo" id="sub_tab_type'+id+'-'+count+'">';
        }
        html += '</div>';

        $('#imdb_tab_info'+id).append(html);
        if(type==="text") {
            wp.editor.initialize('imdb_tab_text' + id + "-" + count, {
                tinymce: {
                    wpautop: true,
                    plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                    toolbar1: 'bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | fullscreen | wp_adv',
                    toolbar2: 'formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help'
                },
                quicktags: true,
                mediaButtons: true,
            });
        }
        if(type==="embed"){
            wp.editor.initialize('imdb_tab_embed_adverb' + id + "-" + count, {
                tinymce: {
                    wpautop: true,
                    plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                    toolbar1: 'bold italic underline strikethrough | bullist numlist | blockquote hr wp_more | alignleft aligncenter alignright | link unlink | fullscreen | wp_adv',
                    toolbar2: 'formatselect alignjustify forecolor | pastetext removeformat charmap | outdent indent | undo redo | wp_help',
                    placeholder: "You can add adverb here...",
                },
                quicktags: true,
                mediaButtons: true,
                size:true
            });
        }

        $('#imdb_sub_count'+id).val(count);

    });
     //remove sub tab
    $(document).on('click','.close_sub_tabs',function (e){
        var allid = $(this).attr('id');
        var id = allid.replace('close_sub_tab','');
        $('#sub_tab_item'+id).remove();
    });

    //*************** SAVING ********************
    $(document).on('click','#save_imdb_tabs',function (e){
        $('#save_imdb_tabs').html('Saving...');
        let url = $('#imdb_tab_url').val();
        let local = $('#imdb_tab_location').val();
        let title = $('#imdb_tab_title').val();
        let id = $('#imdb_tab_id').val();
        let arr = [];

        $(".imdb_main_tabs").each(async function(){
            let mainID = $(this).attr('id');
            mainID = mainID.replace("imdb_main_tab","");
            let bigTitle = $('#up_tab_title'+mainID).val();
            let Type = $('#up_tab_type'+mainID).val();
            let subarr = [];
            $(".sub_tab_items"+mainID).each(function (){
                let subID = $(this).attr('id');
                subID = subID.replace("sub_tab_item","");
                let subtype = $("#sub_tab_type"+subID).val();

                let subObj = {};
                subObj['type'] = subtype;
                subObj['title'] = $("#sub_tab_title"+subID).val();
                subObj['main'] = bigTitle;
                subObj['tabType'] = Type;

                if(subtype === "cast"){

                    subObj['show'] = $('#imdb_tab_cast_show'+subID).val();
                }
                else if(subtype === "text"){

                    subObj['text'] = tinymce.editors['imdb_tab_text'+subID].getContent();
                }
                else if(subtype === "embed"){

                    subObj['embed'] = $('#imdb_tab_embed'+subID).val();
                    subObj['display_time'] = $('#imdb_tab_embed_display'+subID).val();
                    subObj['adverb'] = tinymce.editors['imdb_tab_embed_adverb'+subID].getContent();

                }
                else if(subtype === "youtube"){

                    subObj['youtube'] = $('#imdb_tab_youtube'+subID).val();
                }
                else if(subtype === "woo"){

                    subObj['woo'] = $('#imdb_tab_woo'+subID).val();
                    subObj['show'] = $('#imdb_tab_woo_show'+subID).val();
                }
                subarr.push(subObj);


            });
            arr.push(subarr);

        });

        $.ajax({
            url: url+'includes/external/tabsave.php',
            type : 'post',
            dataType: 'json',
            data:{
                save:"yes",
                id:id,
                title:title,
                arr: arr,
                secret: $('#tab_secret').val()
            },
            success:function(data){
                if(data.state === "ok") {
                    document.location.href = local;
                }else{
                    $('#imdb_notice_message').html('<div class="notice notice-error is-dismissible"><p>This id has been already added</p></div>');
                    // $('#imdb_notice_message').html(data.arr);
                    $('#save_imdb_tabs').html('Save');
                }
            }
        });
    });



     $('#imdb_info_infos').sortable({items: '.imdb_main_tabs'});
    $('div[id*="imdb_tab_info"]').sortable({items:'div[class*="sub_tab_items"]'});



})