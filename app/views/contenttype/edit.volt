{{ javascript_include('js/codemirror/mode/markdown/markdown.js') }}
{{ javascript_include('js/codemirror/addon/wrap/hardwrap.js') }}

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

    <h2>Edit a Content Type</h2>
    {{ form.render("id") }}


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
        <label for="name">Active</label>
        {{ form.render("active") }}
    </div>

    <div class="clearfix">
        <label for="name">Fields</label>
        <div class="">
            <label for="name">Use Title <?php if(in_array('title_bn',$list_fields)){?>
                    {{ check_field('chkfld[title_bn]',"checked":"checked") }}
                <?php }else{ ?>
                    {{ check_field('chkfld[title_bn]') }}
                <?php } ?></label>
            {{ form.render("use_title") }}
        </div>
        <div class="">
            <label for="name">Use Body </label>
            {{ form.render("use_body") }}
        </div>
        <table  id="tblFields" class="table table-striped table-bordered sorted_table">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Human Name</th>
                <th>Type</th>
                <th>Active</th>
                <th>Required</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $num_flds=0 ?>
            {% set i = -1 %}
            {% for fld in flds %}
            {% set i = i +1 %}

            <tr>
                <td><i class="icon-move"></i></td>
                <td>
                    <?php if(($fld['type']=='parentcontenttype') ||($fld['type']=='childcontenttype') ||($fld['type']=='text') || ($fld['type']=='string')){?>
                        <?php if(in_array($fld['name'].'_bn',$list_fields)){?>
                            {{ check_field('chkfld['~fld['name']~'_bn]',"checked":"checked") }}
                        <?php }else{ ?>
                        {{ check_field('chkfld['~fld['name']~'_bn]') }}
                        <?php } ?>
                    <?php } ?>
                </td>
                <td>{{ text_field('fld['~i~'][name]','value':fld['name'],'readonly':'readonly','class':'input-small') }}</td>
                <td>{{ text_field('fld['~i~'][hname]','value':fld['hname']) }}</td>
                <td>
                    {{ hidden_field('fld['~i~'][type]','value':fld['type'],'readonly':'readonly') }}
                    <?php
                        $typename = '';
                        if(!isset($fld['typename'])){
                            foreach($sys_fld_types as $t){
                                if($t['name']==$fld['type']){
                                    $typename = $t['hname'];
                                }
                            }
                        }else{
                            $typename = $fld['typename'];
                        }
                    ?>
                    {{ text_field('fld['~i~'][typename]','value':typename,'readonly':'readonly') }}

                    {% if fld['type'] == "lookuptbl" or fld['type'] == "multiselect" %}
                    {{ hidden_field('fld['~i~'][lookup]','value':fld['lookup'],'readonly':'readonly') }}
                    {{ hidden_field('fld['~i~'][dependson]','value':fld['dependson'],'readonly':'readonly') }}
                    {% endif %}
                    {% if fld['type'] == "parentcontenttype" or fld['type'] == "childcontenttype" or fld['type'] == "contentref" or fld['type'] == "multicontentref" %}
                    {{ text_field('fld['~i~'][contentname]','value':fld['contentname'],'readonly':'readonly') }}
                    {% endif %}
                    {% if fld['type'] == "filefield" or fld['type'] == "imglist" %}
                    {{ text_field('fld['~i~'][maxwidth]','value':fld['maxwidth'],'readonly':'readonly') }}
                    {{ text_field('fld['~i~'][maxheight]','value':fld['maxheight'],'readonly':'readonly') }}
                    {{ text_field('fld['~i~'][cropimage]','value':fld['cropimage'],'readonly':'readonly') }}
                    {{ text_field('fld['~i~'][forceresize]','value':fld['forceresize'],'readonly':'readonly') }}
                    {{ text_field('fld['~i~'][validefiletype]','value':fld['validefiletype'],'readonly':'readonly') }}
                    {{ text_field('fld['~i~'][maxsize]','value':fld['maxsize'],'readonly':'readonly') }}
                    {% endif %}
                </td>
                <td>
                    {{ set_default('fld['~i~'][active]',fld['active']) }}
                    {{ select('fld['~i~'][active]', ['0':'Disable','1':'Enable'],'class':'input-mini') }}
                </td>
                <td>
                    {{ set_default('fld['~i~'][required]',fld['required']) }}
                    {{ select('fld['~i~'][required]', ['0':'No','1':'Yes'],'class':'input-mini') }}
                </td>
                <td></td>
            </tr>
            <?php $num_flds++ ?>
            {% endfor %}
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
            <?php $numOfSqls=0 ?>
            {% set i = 0 %}
            {% for sql in sql_query %}


            <tr>
                <td>{{ text_area('sql_query['~i~']','value':sql,'class':'input-xxlarge','rows':'10') }}</td>
                <td></td>
            </tr>
            {% set i = i +1 %}
            <?php $numOfSqls++ ?>
            {% endfor %}
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

    var numOfFlds =  <?php echo $num_flds ?>;
    var numOfSqls = <?php echo $numOfSqls ?>;
    function getFileProps(id,name){
        // ---:  /\/(pdf|xml)$/i
        // ---:  /^image\/(gif|jpeg|png)$/
        // ---:  /(\.|\/)(gif|jpe?g|png)$/i
        var t = '<div style="display:none" id="'+id+'">' +
            '<input type="text" value="" name="" placeholder="Max Width">' +
            '<input type="text" value="" name="'+name+'[maxheight]" placeholder="Max Height">' +
            //'<input type="text" value="" name="'+name+'[maxwidth]" placeholder="Min Width">' +
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

        $('#tblFields > tbody').append('<tr><td></td><td></td><td><input class="input-small" type="text" value="" name="fld['+numOfFlds+'][name]"></td>' +
            '<td><input type="text" value="" name="fld['+numOfFlds+'][hname]"></td><td>' +
            '<select onchange="showLookup(this,'+numOfFlds+');" name="fld['+numOfFlds+'][type]" id="fld['+numOfFlds+'][type]">' +
            contentTypes +
            '</select>' +
            '<select class="hide" name="fld['+numOfFlds+'][lookup]" id="fld_'+numOfFlds+'_lookup">' +
            lookupTbls +
            '</select>' +
            '<select class="hide" name="fld['+numOfFlds+'][contentname]" id="fld_'+numOfFlds+'_contentname">' +
            cntntTypes +
            '</select>' +  imageProps +
            '<input style="display: none" type="text" value="" name="fld['+numOfFlds+'][dependson]" id="fld_'+numOfFlds+'_dependson">' +
            '</td><td>' +
            '<select class="input-small" name="fld['+numOfFlds+'][active]">' +
            '<option value="0">Disable</option>' +
            '<option value="1" selected="selected">Enable</option>' +
            '</select>' +
            '</td><td>' +
            '<select class="input-mini" name="fld['+numOfFlds+'][required]">' +
            '<option value="0">No</option>' +
            '<option value="1" selected="selected">Yes</option>' +
            '</select>' +
            '</td><td><a href="javascript:;" class="btn btn-mini btn-danger" onclick="removeThis(this); return false;">X</a></tr>');
        numOfFlds++;
        $('#tblFields select').bind('click.sortable mousedown.sortable',function(ev){
            ev.target.focus();
        });

//        jQuery('#tblFields select').click(function(){ jQuery(this).focus(); });
        return null;
    }
    function showLookup(t,n){
        if(($(t).val()=='lookuptbl')||($(t).val()=='multiselect')){
            $("#fld_"+n+"_lookup").show();
        }else{
            $("#fld_"+n+"_lookup").hide();
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

    function removeThis(t){
        $(t).parent().parent().remove();
    }
    function addSqlQueries(){
        $('#tblSqlQueries > tbody').append('<tr><td><textarea name="sql_query['+numOfSqls+']" class="input-xxlarge" rows="10"></textarea></td><td><a href="#" onclick="removeThis(this)">remove</a></td></tr>');
        numOfSqls++;
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
            indentWithTabs: true,
            lineWrapping: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets : true
        });

    };
    $(function () {
        $('#tblFields').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            connectWith: ".sortable",
//            disable: true,
            placeholder: '<tr class="placeholder"/>'
        });
//        $("#tblFields").sortable().disableSelection();
        $('#tblFields select').bind('click.sortable mousedown.sortable',function(ev){
            ev.target.focus();
        });
//        jQuery('#tblFields select').click(function(){ jQuery(this).focus(); });
    });

</script>
<style>
    .sorted_table tr {
        cursor: pointer;
    }
</style>
