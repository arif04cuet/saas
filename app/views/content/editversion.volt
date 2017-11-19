{{ content() }}
<link href="/npfadmin/js/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
<link href="/npfadmin/js/colorpicker/css/colorpicker.css" rel="stylesheet">
<script src="/npfadmin/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/npfadmin/js/colorpicker/js/bootstrap-colorpicker.js"></script>


{{ partial("content/partials/domain_selector_picker") }}
<div class="row">
    <form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <h2>Edit  {{ formHName }}</h2>
        {{ partial("content/partials/image_uploader", ['uppth': uploadPath]) }}
        {{ partial("content/partials/single_file_upload", ['uppth': uploadPath]) }}
        {{ partial("content/partials/select_content") }}

    {{ hidden_field("form_name","value":formName) }}
    {{ hidden_field("id","value":contentValues['id']) }}
    {{ hidden_field("created","value":contentValues['created']) }}
    {{ hidden_field("createdby","value":contentValues['createdby']) }}
    {{ hidden_field("version","value":version) }}
    {{ hidden_field("uploadpath","value":contentValues['uploadpath']) }}

    {% if isTitle == 1 %}
    <div class="clearfix">
        <label for="name">Title</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#title_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#title_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="title_bn">
                {{ text_field("title_bn","class":"input-xxlarge","value":contentValues['title_bn']) }}
            </div>
            <div class="tab-pane" id="title_en">
                {{ text_field("title_en","class":"input-xxlarge","value":contentValues['title_en']) }}
            </div>
        </div>
    </div>
    {% else %}
    {{ hidden_field("title_bn","value":contentValues['title_bn']) }}
    {{ hidden_field("title_en","value":contentValues['title_en']) }}
    {% endif %}

    {% if isBody == 1 %}
    <div class="clearfix">
        <label for="name">Body</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#body_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#body_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="body_bn">
                {{ text_area("body_bn","class":"ck-editor","value":contentValues['body_bn']) }}
            </div>
            <div class="tab-pane" id="body_en">
                {{ text_area("body_en","class":"ck-editor","value":contentValues['body_en']) }}
            </div>
        </div>
    </div>
    {% else %}
    {{ hidden_field("body_bn","value":contentValues['body_bn']) }}
    {{ hidden_field("body_en","value":contentValues['body_en']) }}
    {% endif %}

    {% for fld  in formFields %}
        <div class="clearfix">

            <label for="name">{{ fld['hname'] }}</label>
            {% if fld['type'] == "text" or fld['type'] == "htmltext" %}
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#{{fld['name']}}_bn" data-toggle="tab">Bn</a></li>
                  <li><a href="#{{fld['name']}}_en" data-toggle="tab">En</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="{{fld['name']}}_bn">
                      <?php $t = $fld['name']."_bn";?>
                    {{ text_area(t,"class":"ck-editor","value":contentValues[t]) }}
                  </div>
                  <div class="tab-pane" id="{{fld['name']}}_en">
                      <?php $t = $fld['name']."_en";?>
                    {{ text_area(t,"class":"ck-editor","value":contentValues[t]) }}
                  </div>
                </div>
            {% elseif fld['type'] == "bool" %}
            {{ partial("content/partials/pickers", ['fldtype': 'bool','fldname': fld['name'],'fldval':contentValues[fld['name']]]) }}

            {% elseif fld['type'] == "color" %}
                {{ partial("content/partials/pickers", ['fldtype': 'color','fldname': fld['name'],'fldval': contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "date" %}
                {{ partial("content/partials/pickers", ['fldtype': 'date','fldname': fld['name'],'required':fld['required'],'fldval': contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "lookuptbl" %}
                {{ partial("content/partials/pickers", ['fldtype': 'lookuptbl','lookupData':lookupData[fld['name']], 'fldname': fld['name'], 'flddependson': fld['dependson'],'fldval':contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "multiselect" %}
                {{ partial("content/partials/pickers", ['fldtype': 'multiselect','lookupData':lookupData[fld['name']], 'fldname': fld['name'], 'flddependson': fld['dependson'],'fldval':contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "multitext" %}
                {{ partial("content/partials/multi_text", ['fldname': fld['name'],'fldval':contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "geocode" %}
                {{ partial("content/partials/geocode", ['fldname': fld['name'],'fldval':contentValues[fld['name']]]) }}
				
            {% elseif fld['type'] == "childcontenttype" %}
                {{ partial("content/partials/child_content_ref", ['show': true, 'fldname': fld['name'],'cntname': formName, 'id':contentValues['id']]) }}
            {% elseif fld['type'] == "parentcontenttype" %}			
                {{ partial("content/partials/parent_content_ref", ['fldname': fld['name'],'fldrefname': fld['contentname'],'fldval': contentValues[fld['name']]]) }}

			{% elseif fld['type'] == "nodereference" %}
                {{ partial("content/partials/single_link", ['fldname': fld['name'],'fldval': contentValues[fld['name']][0]]) }}
            {% elseif fld['type'] == "linklist" %}
                {{ partial("content/partials/multi_links", ['fldname': fld['name'],'fldval': contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "filefield" %}
                {{ partial("content/partials/single_file", ['fldname': fld['name'],'fldval': contentValues[fld['name']][0]]) }}
            {% elseif fld['type'] == "imglist" %}
                {{ partial("content/partials/multi_files", ['fldname': fld['name'],'fldval': contentValues[fld['name']]]) }}
            {% elseif fld['type'] == "domainselector" %}
                {{ partial("content/partials/domain_selector", ['fldname': fld['name'],'required':fld['required'],'did': contentValues[fld['name']]['id'],'dname': contentValues[fld['name']]['name']]) }}
            {% elseif fld['type'] == "email" %}
            {{ partial("content/partials/pickers", ['fldtype': 'email', 'fldname': fld['name'],'fldval':contentValues[fld['name']],'required':fld['required']]) }}
            {% elseif fld['type'] == "number_integer" %}
            {{ partial("content/partials/pickers", ['fldtype': 'number', 'fldname': fld['name'],'fldval':contentValues[fld['name']],'required':fld['required']]) }}
            {% elseif fld['type'] == "number_long" %}
            {{ partial("content/partials/pickers", ['fldtype': 'number', 'fldname': fld['name'],'fldval':contentValues[fld['name']],'required':fld['required']]) }}
            {% elseif fld['type'] == "number_decimal" %}
            {{ partial("content/partials/pickers", ['fldtype': 'decimal', 'fldname': fld['name'],'fldval':contentValues[fld['name']],'required':fld['required']]) }}
            {% else %}
            {{ partial("content/partials/pickers", ['fldtype': '', 'fldname': fld['name'],'fldval':contentValues[fld['name']],'required':fld['required']]) }}
            {% endif %}
        </div>
    {% endfor %}

    <div class="clearfix">
        <label for="name">Publish</label>
        {% if contentValues['publish']=='1' %}
            {{ check_field('publish',"value":"1",'checked':'checked') }}
        {% else %}
            {{ check_field('publish',"value":"0") }}
        {% endif %}
    </div>

<!--    <div class="clearfix">-->
<!--        <label for="name">Active</label>-->
<!--        {% if contentValues['active']=='1' %}-->
<!--            {{ check_field('active',"value":"1",'checked':'checked') }}-->
<!--        {% else %}-->
<!--            {{ check_field('active',"value":"0") }}-->
<!--        {% endif %}-->
<!--    </div>-->

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("content/"~formName, "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    </form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $( '.ck-editor' ).ckeditor( {
            filebrowserBrowseUrl : '/uploader?ckeditor=1&uppth={{ uploadPath }}'
        } );
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    });
</script>

