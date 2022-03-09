jQuery(document).on( 'click', '.my-shimdb-notice .notice-dismiss', function() {
    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'my_dismiss_shimdb_notice'
        }
    })



})
