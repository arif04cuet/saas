<div class="hide" id="contentTypes">
    {{ select_static("fld_tmp",contentTypes) }}
</div>
<div class="hide" id="cntntTypes">
    {{ select("cnt_tmp",cntntTypes, 'using': ['name', 'name'],'useEmpty' : false) }}
</div>
<div class="hide" id="lookupTbl">
    {{ select("lookuptbl_tmp",lookuptbls, 'using': ['id', 'name'],'useEmpty' : false) }}
</div>

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2>Create a Conten Type</h2>
    <div class="clearfix">
        <label for="name">Machine Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="name">Human Name</label>
        {{ form.render("human_name") }}
    </div>


    <div class="clearfix">
        <label for="name">Is Common</label>
        {{ form.render("is_common") }}
    </div>
    <div class="clearfix">
        <label for="name">Disable Right Side-bar</label>
        {{ form.render("is_right_side_bar") }}
    </div>
    <div class="clearfix">
        <label for="name">Icon</label>
        {{ form.render("icon") }}
    </div>

    <div class="clearfix">
        <label for="name">Fields</label>
        <div class="">
            <label for="name">Use Title</label>
            {{ form.render("use_title") }}
        </div>
        <div class="">
            <label for="name">Use Body</label>
            {{ form.render("use_body") }}
        </div>
        <table  id="tblFields" >
            <thead>
            <tr>
                <th>Name</th>
                <th>Human Name</th>
                <th>Type</th>
                <th>Active</th>
                <th>Required</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>

            </tr>
            </tbody>
        </table>
        <a href="javascript:;" onclick="addFieldRow()">Add</a>
    </div>

    <div class="clearfix">
        <label for="name">Content Template (BN)</label><i>(press F11 for fullscreen & Esc to back)</i>
        {{ form.render("volt_template_bn") }}
    </div>
    <div class="clearfix">
        <label for="name">Content Template (EN)</label><i>(press F11 for fullscreen & Esc to back)</i>
        {{ form.render("volt_template_en") }}
    </div>



    <div class="clearfix">
        <label for="name">Queries</label>
        <table id="tblSqlQueries" style="width:100%">
            <tbody>
            <tr><td>{{ text_area('sql_query[0]','class':'input-xxlarge','rows':'4') }}</td><td></td></tr>
            </tbody>
        </table>
        <a href="javascript:;" onclick="addSqlQueries()">Add</a>
    </div>

    <div class="clearfix">
        <label for="name">CSS</label>
        {{ form.render("css") }}
    </div>
    <div class="clearfix">
        <label for="name">js</label>
        {{ form.render("js") }}
    </div>

</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("contenttype", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>
<script>
    var numOfFlds = 0;
    var numOfSqls = 0;
    $(document).ready(function(){
        addFieldRow();

    });
    function getFileProps(id,name){
        var t = '<div style="display:none" id="'+id+'">' +
            '<input type="text" value="960" name="'+name+'[maxwidth]" placeholder="Max Width">' +
            '<input type="text" value="250" name="'+name+'[maxheight]" placeholder="Max Height">' +
            //'<input type="text" value="" name="'+name+'[minwidth]" placeholder="Min Width">' +
            //'<input type="text" value="" name="'+name+'[minheight]" placeholder="Min Height">' +
            '<select name="'+name+'[cropimage]">'+
            '<option value="false">Crop Image (No)</option><option value="true">Crop Image (Yes)</option></select>'+
            '<select name="'+name+'[forceresize]">'+
            '<option value="false">Force Resize (No)</option><option value="true">Force Resize (Yes)</option></select>'+
            '<input type="text" value="/^image\/(gif|jpeg|png)$/" name="'+name+'[validefiletype]" placeholder="Accept File Type">' +
            '<input type="text" value="5000000" name="'+name+'[maxsize]" placeholder="Max File Size"></div>';
        return t;
    }
    function addFieldRow(){

        var contentTypes = $('#contentTypes > select').html();
        var lookupTbls = $('#lookupTbl > select').html();
        var cntntTypes = $('#cntntTypes > select').html();
        var imageProps = getFileProps('fld_'+numOfFlds+'_fileprops','fld['+numOfFlds+']');

        $('#tblFields > tbody').append('<tr><td><input type="text" value="" name="fld['+numOfFlds+'][name]"></td>' +
            '<td><input type="text" value="" name="fld['+numOfFlds+'][hname]"></td><td>' +
            '<select onchange="showLookup(this,'+numOfFlds+');" name="fld['+numOfFlds+'][type]" id="fld['+numOfFlds+'][type]">' +
            '<option value="self">self</option>' +
            contentTypes +
            '</select>' +
            '<select class="hide" name="fld['+numOfFlds+'][lookup]" id="fld_'+numOfFlds+'_lookup">' +
            lookupTbls +
            '</select>' +
            '<select class="hide" name="fld['+numOfFlds+'][contentname]" id="fld_'+numOfFlds+'_contentname">' +
            cntntTypes +
            '</select>' + imageProps +
            '<input style="display: none" type="text" value="" name="fld['+numOfFlds+'][dependson]" id="fld_'+numOfFlds+'_dependson">' +
            '</td><td>' +
            '<select class="input-mini" name="fld['+numOfFlds+'][active]">' +
            '<option value="0">Disable</option>' +
            '<option value="1" selected="selected">Enable</option>' +
            '</select>' +
            '</td><td>' +
            '<select class="input-mini" name="fld['+numOfFlds+'][required]">' +
            '<option value="0">No</option>' +
            '<option value="1" selected="selected">Yes</option>' +
            '</select>' +
            '</td><td><a href="javascript:;" class="btn btn-mini btn-danger" onclick="removeThis(this); return false;">X</a></td></tr>');

        numOfFlds++;
        return null;
    }
    function showLookup(t,n){
        if(($(t).val()=='lookuptbl')||($(t).val()=='multiselect')){
            $("#fld_"+n+"_lookup").show();
            $("#fld_"+n+"_dependson").show();
        }else{
            $("#fld_"+n+"_lookup").hide();
            $("#fld_"+n+"_dependson").hide();
        }
        if(($(t).val()=='contentref')||($(t).val()=='multicontentref')||($(t).val()=='childcontenttype')||($(t).val()=='parentcontenttype')){
            $("#fld_"+n+"_contentname").show();
        }else{
            $("#fld_"+n+"_contentname").hide();
        }
        if(($(t).val()=='filefield')||($(t).val()=='imglist')){
            $('#fld_'+n+'_fileprops').show();
        }else{
            $('#fld_'+n+'_fileprops').hide();
        }
    }
    function showContentTypes(){

    }
    function removeThis(t){
        $(t).parent().parent().remove();
    }
    function addSqlQueries(){
        numOfSqls++;
        $('#tblSqlQueries > tbody').append('<tr><td><textarea name="sql['+numOfSqls+']" class="input-xxlarge" rows="4"></textarea></td><td><a href="#" onclick="removeThis(this)">remove</a></td></tr>');
        return null;
    }


    var editor_template_bn = CodeMirror.fromTextArea(document.getElementById("volt_template_bn"), {
        autoCloseBrackets: true,
        autoCloseTags: true,
        styleActiveLine: true,
        lineWrapping: true,
        lineNumbers: true,
        theme: "night",
        extraKeys: {
            "F11": function(cm) {
                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
            },
            "Esc": function(cm) {
                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
            }
        },
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true
    });
    var editor_template_en = CodeMirror.fromTextArea(document.getElementById("volt_template_en"), {
        autoCloseBrackets: true,
        autoCloseTags: true,
        styleActiveLine: true,
        lineWrapping: true,
        lineNumbers: true,
        theme: "night",
        extraKeys: {
            "F11": function(cm) {
                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
            },
            "Esc": function(cm) {
                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
            }
        },
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true
    });
    var editor_css = CodeMirror.fromTextArea(document.getElementById("css"), {
        autoCloseBrackets: true,
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true,
        theme: "neat",
        matchBrackets: true
    });

    var editor_js = CodeMirror.fromTextArea(document.getElementById("js"), {
        autoCloseBrackets: true,
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true,
        theme: "cobalt",
        matchBrackets: true,
        continueComments: "Enter",
        extraKeys: {"Ctrl-Q": "toggleComment"}
    });
    window.onload = function() {
        var mime = 'text/x-mariadb';
        // get mime type
        if (window.location.href.indexOf('mime=') > -1) {
            mime = window.location.href.substr(window.location.href.indexOf('mime=') + 5);
        }
        window.editor = CodeMirror.fromTextArea(document.getElementById('sql_query[0]'), {
            mode: mime,
            lineWrapping: true,
            indentWithTabs: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets : true
        });
    };
</script>
