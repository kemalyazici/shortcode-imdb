jQuery(document).ready(function($) {
    let tabWidth = document.getElementById('imdb_fp_tab_container').clientWidth;
    if(typeof tabWidth !== 'undefined' && tabWidth !== null) {
        if (tabWidth < 701) {
            $('#imdb_rating_size').css('font-size', '13px');
            $('#imdb_vote_size').css('font-size', '9px');
            $('#imdb_meta_size').css('font-size', '13px');
            $('#imdb_fp_tab_info').css('font-size', '14px');
            $('#imdb_fp_title_size').css('font-size', '16px');

        }
    }
	
    let bgColor = getBackground($("#shimdb-tab"));
    let tabBG ="";
    if(bgColor.includes('rgba')){
        tabBG = rgba2hex(bgColor);
    }else{
        tabBG = RGBToHex(bgColor);
    }



    if(tabBG!=="#000000") {
        tabBG = LightenDarkenColor(tabBG, -50);
    }else{
        tabBG = LightenDarkenColor(tabBG, 30);
    }
    if(tabBG.length<7){
        tabBG = "#000000";
    }
    var invertTab = invertColor(tabBG);
    let tabid = $('.shimdb-tab-input[type=radio]:checked').attr('id');
    tabid = tabid.replace('tab','lab');
    $(".shimdb-tabs label.shimdb-tab-lab").css('background-color',tabBG);
    $("#"+tabid).css('background-color','inherit');

    $('input.shimdb-tab-input:radio').change(function (e){
        var newid = $(this).attr('id');
        newid = newid.replace('tab','lab');
        $(".shimdb-tabs label.shimdb-tab-lab").css('background-color',tabBG);
        $("#"+newid).css('background-color','inherit');
    });
    var sideTag = $('.side-tab-labels');
    sideTag.mouseover(function(){
        $(this).css('background-color',tabBG);
    });
    sideTag.mouseout(function(){
        $(this).css('background-color','inherit');
    });

    sideTag.on('click',function (){

    })

    $('select.select-subtab').css('background-color',tabBG);
    // $('.shimdb-tab-select').after(function (){
    //     $(this).css('color',tabBG)
    // })

    function disabledButton(id){
        //Control button is disabled
        var openadverb = $('#openadverb'+id)
        var count = $('#count'+id)
        openadverb.prop('disabled', true);
        var second = $('#display_time'+id).val();
        var intervalObj = setInterval(function () {
            count.text("(" + second + ")");
            if(second == 0){
                count.text("");
                $('#adverb'+id).remove();
                openadverb.remove();
                $('#embed'+id).css('display','block');

                /* Clear the setInterval object */
                clearInterval(intervalObj);
            }
            second--;
        }, 1000 );
    }

    $('.open-ads').on('click',function (){
        var getid = $(this).attr('id');
        var id = getid.replace('openadverb','');
        disabledButton(id);
    });

    $('.select-subtab').change(function (){
        let getId = $(this).attr('id');
        let subID  = getId.replace('select-subtab','');
        let selectedId = $(this).val();
        $('.select_content_div_class'+subID).hide();
        $('#select_content_div'+subID+'-'+selectedId).show();

    });

    $('.tab-label').click( function (){
        var id= $(this).attr('for');
        var myid = $('#'+id);
        // $('input[type="checkbox"].tab-input').removeAttr('checked');
        if (!myid.is(':checked')) {
            $myid.attr('checked', 'checked');
        }
    });


});

function getBackground(jqueryElement) {
    // Is current element's background color set?
    var color = jqueryElement.css("background-color");

    if ((color !== 'rgba(0, 0, 0, 0)') && (color !== 'transparent')) {
        // if so then return that color
        return color;
    }

    // if not: are you at the body element?
    if (jqueryElement.is("body")) {
        // return known 'false' value
        return false;
    } else {
        // call getBackground with parent item

        return getBackground(jqueryElement.parent());
    }
}
var hexDigits = ["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"];

function hex(x) {
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function RGBToHex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function LightenDarkenColor(col, amt) {

    var usePound = false;

    if (col[0] === "#") {
        col = col.slice(1);
        usePound = true;
    }

    var num = parseInt(col,16);

    var r = (num >> 16) + amt;

    if (r > 255) r = 255;
    else if  (r < 0) r = 0;

    var b = ((num >> 8) & 0x00FF) + amt;

    if (b > 255) b = 255;
    else if  (b < 0) b = 0;

    var g = (num & 0x0000FF) + amt;

    if (g > 255) g = 255;
    else if (g < 0) g = 0;

    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);

}

function rgba2hex(rgba) {
    let sep = rgba.indexOf(",") > -1 ? "," : " ";
    rgba = rgba.substr(5).split(")")[0].split(sep);

    // Strip the slash if using space-separated syntax
    if (rgba.indexOf("/") > -1)
        rgba.splice(3,1);

    for (let R in rgba) {
        let r = rgba[R];
        if (r.indexOf("%") > -1) {
            let p = r.substr(0,r.length - 1) / 100;

            if (R < 3) {
                rgba[R] = Math.round(p * 255);
            } else {
                rgba[R] = p;
            }
        }
    }
    let r = (+rgba[0]).toString(16),
        g = (+rgba[1]).toString(16),
        b = (+rgba[2]).toString(16),
        a = Math.round(+rgba[3] * 255).toString(16);

    if (r.length === 1)
        r = "0" + r;
    if (g.length === 1)
        g = "0" + g;
    if (b.length === 1)
        b = "0" + b;
    if (a.length === 1)
        a = "0" + a;

    return "#" + r + g + b + a;
}

function invertColor(hex) {
    if (hex.indexOf('#') === 0) {
        hex = hex.slice(1);
    }
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }
    if (hex.length !== 6) {
        throw new Error('Invalid HEX color.');
    }
    // invert color components
    var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
        g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
        b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
    // pad each with zeros and return
    return '#' + padZero(r) + padZero(g) + padZero(b);
}

function padZero(str, len) {
    len = len || 2;
    var zeros = new Array(len).join('0');
    return (zeros + str).slice(-len);
}
