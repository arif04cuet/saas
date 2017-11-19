{{ content() }}
{{ javascript_include('js/jquery.nestable.js') }}
<style type="text/css">


        /**
         * Nestable
         */

    .dd { position: relative; display: block; margin: 0; padding: 0;  list-style: none; font-size: 13px; line-height: 20px; }

    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }

    .dd-item,
    .dd-empty,
    .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

    .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:         linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd-handle:hover { color: #2ea8e5; background: #fff; }

    .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
    .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
    .dd-item > button[data-action="collapse"]:before { content: '-'; }

    .dd-placeholder,
    .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    }

        /**
         * Nestable Extras
         */

    .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

    #nestable-menu { padding: 0; margin: 20px 0; }

    .dd-hover > .dd-handle { background: #2ea8e5 !important; }

        /**
         * Nestable Draggable Handles
         */

    .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:         linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box; -moz-box-sizing: border-box;
    }
    /*.dd3-content:hover { color: #2ea8e5; background: #fff; }*/

    .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

    .dd3-item > button { margin-left: 30px; }

    .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:         linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
    /*.dd3-handle:hover { background: #ddd; }*/

</style>

{{ partial("content/partials/content_selector") }}
<h4>Menus</h4>
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contentType", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
            {{ link_to("javascript:;","Save All", "class": "btn btn-success","onclick":"saveAllMenu(this);return false;") }}
            <span id="roller" style="display: none;margin:0;"><img width="15px" src="img/loading.gif"></span>
    </li>
</ul>

<div class="span7">
    {{ menu }}
</div>
<div class="span4" id="div-frm_menu">
    <form id="frm_menu" method="post" autocomplete="on"  style="background-color: #eee; padding: 5px 10px;">
        {{ hidden_field("menu-id") }}
        <div class="clearfix3">
            <label for="name">Title(bn)</label>
            {{ text_field("menu-title_bn") }}
        </div>
        <div class="clearfix3">
            <label for="name">Title(en)</label>
            {{ text_field("menu-title_en") }}
        </div>
        {{ hidden_field("menu-external") }}
        <div class="clearfix3">
            <label for="name">Link Path</label>
            {{ select('menu-link-type', ['external':'External','front':'Front page','nolink':'No Link','contentref':'Content Reference']) }}
            <div class="input-append">
                {{ text_field("menu-link_path") }}
                <a id="btn-contentref" href="#Modal-Content-Selector" role="button" class="btn" data-toggle="modal"><i class="icon-search"></i></a>

            </div>

        </div>
        <div class="clearfix3">
            <label for="name">{{ check_field("menu-active","style":"margin:0") }} Active</label>

        </div>

        <div class="clearfix">
            <a href="javascript:;" onclick="updateMenuList();return false;" class="btn btn-info">Ok</a>
            <a href="javascript:;" onclick="newMenuList();return false;" class="btn btn-info">New</a>
        </div>
    </form>
</div>
<style>
    #frm_menu.affix {
        position: fixed;
        top: 45px;
    }
    .dd3-content span.deactive{
        color: crimson;
    }
</style>

<script>
    var weight = 1;
    var depth = 1;
    var menuJsonStr = '';


    var menu_cnt = 0;
    $(document).ready(function()
    {
        $('#frm_menu').affix({
            offset: { top: $('#frm_menu').offset().top }
        });
        $('#nestable3').nestable();
        $('#nestable3').nestable('collapseAll');
        bindMenuBtn();
        $( "#menu-link-type" ).bind( "change", function() {
            setMenuPropOnMenuLinkChange($("option:selected",this).val());
        });
        menu_cnt = 0;
        resetMenuEditForm();
        ModalContentSelector.init('menu-link_path');
    });
    function setMenuPropOnMenuLinkChange(val){
        $('#menu-link_path').removeAttr('readonly');
        $('#btn-contentref').hide();
        if(val=='external'){
            $('#menu-external').val('1');
            $('#menu-link_path').val('http://');
        }else if(val=='front'){
            $('#menu-external').val('1');
            $('#menu-link_path').val('[front]');
            $('#menu-link_path').attr('readonly','readonly');
        }else if(val=='nolink'){
            $('#menu-external').val('0');
            $('#menu-link_path').val('nolink');
            $('#menu-link_path').attr('readonly','readonly');
        }else if(val=='contentref'){
            $('#menu-external').val('0');
            $('#menu-link_path').val('');
            $('#btn-contentref').show();
            //$('#menu-link_path').attr('readonly','readonly');
        }
        $('#menu-link-type').val(val);
    }
    function bindMenuBtn(){
        $( ".menu-edit").unbind("click");
        $( ".menu-edit" ).bind( "click", function() {
            onEditMenu(this);
        });

        $( ".menu-delete").unbind("click");
        $( ".menu-delete" ).bind( "click", function() {
            var r=confirm("Are you sure to delete the menu item from the list?");
            if (r==true)
            {
                onDeleteMenu(this);
            }
        });
    }

    function traverseList(ul, prnt, dpth){

        if(ul.size()==0){
            return;
        }

        var cli = $( ul ).children('li');

        $.each(cli, function( index, li ) {
            var t = $(li).find('.data-value');
            var jt = JSON.parse($(t).html());
            jt.weight = weight;
            weight++;
            jt.depth = dpth;

            jt.parent_id = prnt;

            var ul = $( li ).children('ol');

            jt.has_children = (ul.length==0?0:1);
            //console.debug( jt );
            //menuJson.push(t);
            menuJsonStr += ',' + JSON.stringify(jt);
            if(ul.length!=0){
                traverseList(ul, jt.id, dpth+1);
            }

        });
    }

    function saveAllMenu(t){

        $(t).hide();
        $('#roller').show();
        var ul = $('#menu-editor');
        //console.debug(ul);
        menuJsonStr = '[{}';
        traverseList(ul, 0, 1);
        menuJsonStr += ']';

        //return;
        // set weight & depth
        // weight will be calculated by the order
        // depth will be calculated by the depth
        
        /*var jsonStr = [];
        $.each($('.data-value'),function(index, value){
            jsonStr.push(JSON.parse($(value).html()));
        });*/

        //var str = JSON.stringify(menuJson);

        console.debug(menuJsonStr);
        //return;
        $.post("{{ url }}menus/saveAjax",
            {"mns":menuJsonStr},
        function(data,status){
            console.debug(data);
            // reload the
            if(data.result=="success"){
                location.reload(true);
            }
        });
    }
    function updateMenuList(){
        var mid = $('#menu-id').val();
        if(mid==""){
            //alert('insert');
            mid = "new-"+menu_cnt;
            menu_cnt++;
            insertNewMenu(mid);
        }else{
            //alert('update');
            updateMenuData(mid);
        }
        resetMenuEditForm();
        return false;
    }
    function getFormDataInJson(mid){

        var mttlbn = $('#menu-title_bn').val();
        var mttlen = $('#menu-title_en').val();
        var mlnk = $('#menu-link_path').val();
        var mex = $('#menu-external').val();
        var mact = $('#menu-active').prop('checked')?1:0;
        var jsonDt = {"id":mid,"title_en":mttlen,"link_path":mlnk,"external":mex,"active":mact,"title_bn":mttlbn};
        return jsonDt;
    }
    function insertNewMenu(mid){
        var jsonDt = getFormDataInJson(mid);
//        console.debug(jsonDt);
        var li =  '<li data-id="'+mid+'" class="dd-item dd3-item">' +
                  '<div style="display:none" class="data-value">' + JSON.stringify(jsonDt) +
                  '</div><div class="dd-handle dd3-handle"></div><div class="dd3-content"><span class="title-bn">' + jsonDt.title_bn +
                  '</span><div style="float:right;margin-top: -3px; "><a class="menu-edit btn btn-mini btn-warning" href="javascript:;">' +
                  '<i class="icon-edit"></i></a> ' +
                  '<a class="menu-delete btn btn-mini btn-danger" href="javascript:;"><i class="icon-trash"></i></a></div></div></li>';
        //console.debug(li);
        $('ol#menu-editor').append(li);
        bindMenuBtn();
        return false;
    }
    function updateMenuData(mid){
        var jsonDt = getFormDataInJson(mid);
        //console.debug(jsonDt.title_bn);
        $('li[data-id='+mid+'] > .data-value').html(JSON.stringify(jsonDt));
        $('li[data-id='+mid+'] > .dd3-content > span.title-bn').html(jsonDt.title_bn);
        if(jsonDt.active==1){
            // recursively activate all the child menus
            activateMenuChild($('li[data-id='+mid+']'), 1);
            // active all the parent li
            activateMenuParent($('li[data-id='+mid+']'), 1);
            $('li[data-id='+mid+'] > .dd3-content > span.title-bn').removeClass('deactive');
            $('li[data-id='+mid+'] > .dd3-content > span.title-bn').addClass('active');
        }else{
            // recursively deactivate all the child menus
            activateMenuChild($('li[data-id='+mid+']'), 0);
            $('li[data-id='+mid+'] > .dd3-content > span.title-bn').removeClass('active');
            $('li[data-id='+mid+'] > .dd3-content > span.title-bn').addClass('deactive');
        }
    }
    function activateMenuChild(pli, active){


        var cli = $( pli ).find($( "li" ));
        //console.debug(cli);
        $.each(cli, function( index, li ) {
            var t = $(li).children('.data-value');
            var jt = JSON.parse($(t).html());

            if(active==1){
                // recursively activate all the child menus
                // active all the parent li
                jt.active = 1;
                $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').removeClass('deactive');
                $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').addClass('active');
            }else{
                jt.active = 0;
                // recursively deactivate all the child menus
                $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').removeClass('active');
                $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').addClass('deactive');
            }
            $(t).html(JSON.stringify(jt));

        });
    }
    function activateMenuParent(li, active){

        if($(li).parent('ol').attr('id')=="menu-editor"){
            return;
        }
        var pli = $(li).parent('ol').parent('li');
        var t = $(pli).children('.data-value');
        var jt = JSON.parse($(t).html());

        if(active==1){
            // recursively activate all the child menus
            // active all the parent li
            jt.active = 1;
            $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').removeClass('deactive');
            $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').addClass('active');
        }else{
            jt.active = 0;
            // recursively deactivate all the child menus
            $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').removeClass('active');
            $('li[data-id='+jt.id+'] > .dd3-content > span.title-bn').addClass('deactive');
        }
        $(t).html(JSON.stringify(jt));
        activateMenuParent(pli, active);
    }
    function onEditMenu(t){
        //console.debug(t);
        var li = $(t).parent().parent().parent();
        //console.debug(li);
        var data = $(li).find('.data-value');
        //console.debug($(data).html());
        var jsonDt = JSON.parse($(data).html());
        //console.debug(jsonDt);
        $('#menu-id').val(jsonDt.id);
        $('#menu-title_bn').val(jsonDt.title_bn);
        $('#menu-title_en').val(jsonDt.title_en);
        $('#menu-link_path').val(jsonDt.link_path);
        if(jsonDt.external=='1'){
            $('#menu-external').val('1');
        }else{
            $('#menu-external').val('0');
        }
        if(jsonDt.active==1){
            $('#menu-active').prop('checked','checked');
        }else{
            $('#menu-active').prop('checked','');
        }
    }

    function onDeleteMenu(t){
        $(t).parent().parent().parent().remove();
    }
    function newMenuList(){
        resetMenuEditForm();
    }
    function resetMenuEditForm(){
        $('#menu-id').val('');
        $('#menu-title_bn').val('');
        $('#menu-title_en').val('');
        $('#menu-link_path').val('');
        $('#menu-external').val('');
        $('#menu-active').prop('checked','');
        $("#menu-title_bn").focus();
        setMenuPropOnMenuLinkChange('external');
    }
</script>
