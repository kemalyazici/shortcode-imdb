
jQuery(document).ready(function ($){
    $('.imdb_job_click').on('click',function (e){
        var job = '.imdb_job_'+$(this).attr('imdat');
        var job2 = '.imdb_arrow_'+$(this).attr('imdat');
        if ($(job).hasClass('panel-collapsed')) {
                    // expand the panel
                    $(job).slideDown();
                    $(job).removeClass('panel-collapsed');
                    $(job2).removeClass('imdb-arrow-down').addClass('imdb-arrow-up');
                }
                else {
                    // collapse the panel
                    $(job).slideUp();
                    $(job).addClass('panel-collapsed');
                    $(job2).removeClass('imdb-arrow-up').addClass('imdb-arrow-down');
                }
        return false;
    });


});