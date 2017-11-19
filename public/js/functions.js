function searchValidate(value){
    if(value.trim()==''){
        return false
    }
    else{
        return true;
    }
}

function hide_n_slide(obj)
{
    $(obj).fadeTo(400, 0, function () { // Links with the class "close" will close parent
        $(obj).slideUp(400);
    //$(obj).stopTime("hide");
    });
}

function notification_animation(i, obj)
{
    $(obj).hide();
    $(obj).oneTime(i*2000, function() {
        $(obj).slideDown(200, function(){
            $(obj).fadeIn(400, function(){
                if(!$(obj).hasClass('static')){
                    $(obj).oneTime(20000, "hide", function(){
                        hide_n_slide(obj);
                    })
                }
            })
        })
    })
}   

function create_notification(parent, type, msg, i)
{
    var span = document.createElement('span');
    $(span).hide();
    $(span).html('<span class="notification n-'+type+'">'+msg+'</span>');
    $(span).appendTo($(parent));
    notification_animation(i, $(span));
}

$(document).ready(function() { 

    $( "#searchbox, #home-searchbox" ).ime();
    $("#searchbox").focus();
    setTimeout( function() { $("#home-searchbox").focus(); }, 500);

    //$('a.cache').modalPanel();

    $('.notification').click(function(){
        hide_n_slide(this);
        return false;
    })

    /*var hidden_lang = $('#lang-switch > .hidden-lang');
    hidden_lang.hide();
    $('#lang-switch').mouseover(function(){
        hidden_lang.fadeIn();
    });
    $('#lang-switch').mouseleave(function(){
        hidden_lang.fadeOut();
    });
    */

});

function write_email(id, domain)
{
    if(id=='' || domain == '')
        return;
    document.write(id+'@'+domain);
}


//ajax
$.ajaxSetup({
    beforeSend: function() {
        $('#ajax-loader').fadeIn(500);
    },
    complete: function(){
        $('#ajax-loader').fadeOut(500);
    },
    success: function() {
        $('#ajax-loader').fadeOut(500);
    }
});

//protect email
$(function(){
    var spt = $('span.mailme').each(function(){
        var at = / at /;
        var dot = / dot /g;
        var addr = $(this).text().replace(at,"@").replace(dot,".");
        $(this).after('<a href="mailto:'+addr+'">'+ addr +'</a>');
        $(this).remove();
    });
});


//Hide and Show dateTools
var i;
function dateTools () {

    if (i==null) {
        $("#dateTools").show(400);
        i=1;
        setTimeout(
            function()
            {
                $( "#dateTools" ).addClass('dateTools');
            }, 600);

        return;
    };//alert('Date Tolls');
    $( "#dateTools" ).removeClass('dateTools');
    $("#dateTools").hide(400);
    i=null;
    return;
}



$(document).ready(function(){
    setTimeout(
        function()
        {
            $( "a.cache" ).show(700);
        }, 1000);
    setTimeout(
        function()
        {
            $( "#SeachTime" ).show(700);
        }, 1000);
    setTimeout(
        function()
        {
            $( "#DateSearchButton" ).show(800);
        }, 2000);

});

function showDetails( docId, languageId, showtype ){
    //alert(docId+":"+languageId);
    var url =base_url+"site_ajax_calls/show_details/"+docId+"/"+languageId+"/"+showtype;
    var modal = document.getElementById('myModal'+docId); 
    //alert(modal);
    // if(modal!=null) {
    //     $("#myModal").remove();
    // }
    $(modal).modal({
         remote: url
});

}

function setCookie(c_name,value,exdays){
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
  document.cookie=c_name + "=" + c_value;
}
/*
$(function() {
var availableTags = [
"বাগেরহাট",
"বান্দরবান",
"বরগুনা",
"বরিশাল",
"ভোলা",
"বগুড়া",
"ব্রাহ্মণবাড়িয়া",
"চাঁদপুর",
"চাঁপাইনবাবগঞ্জ",
"চট্টগ্রাম",
"চুয়াডাঙ্গা",
"কুমিল্লা",
"কক্সবাজার",
"ঢাকা",
"দিনাজপুর",
"ফরিদপুর",
"ফেনী",
"গাইবান্ধা",
"গাজীপুর",
"গোপালগঞ্জ",
"হবিগঞ্জ",
"ঝালকাঠী",
"জামালপুর",
"যশোর",
"ঝিনাইদহ",
"জয়পুরহাট",
"খাগড়াছড়ি",
"খুলনা",
"কিশোরগঞ্জ",
"কুড়িগ্রাম",
"কুষ্টিয়া",
"লক্ষ্মীপুর",
"লালমনিরহাট",
"মাদারীপুর",
"মাগুরা",
"মানিকগঞ্জ",
"মৌলভীবাজার",
"মেহেরপুর",
"মুন্সীগঞ্জ",
"ময়মনসিংহ",
"নওগাঁ",
"নড়াইল",
"নারায়ণগঞ্জ",
"নরসিংদী",
"নাটোর",
"নেত্রকোণা",
"নীলফামারী",
"নোয়াখালী",
"পাবনা",
"পঞ্চগড়",
"পিরোজপুর",
"পটুয়াখালী",
"রাজবাড়ী",
"রাজশাহী",
"রাঙ্গামাটি",
"রংপুর",
"সাতক্ষীরা",
"শরীয়তপুর",
"শেরপুর",
"সিরাজগঞ্জ",
"সুনামগঞ্জ",
"সিলেট",
"টাঙ্গাইল",
"ঠাকুরগাঁও"
];
$( "#searchbox" ).autocomplete({
source: availableTags
});
$( "#home-searchbox" ).autocomplete({
source: availableTags
});
});
 */

/* AUTO SUGGEST */
/*
$(function() {
    var src = base_url+'/search/suggest';
    $( ".search-query-input" ).autocomplete({
        source: src,
        minLength: 1,
        select: function( event, ui ) {
            if(ui.item)
            {
                // field value is not updated when selected
                // so we update the value here and submit
                $(this).val(ui.item.value);
                $('#search-form').submit();
            }
        }
    });
});
*/
