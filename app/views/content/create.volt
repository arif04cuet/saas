
{{ stylesheet_link('js/bootstrap-datepicker/css/datepicker.css') }}
{{ stylesheet_link('js/colorpicker/css/colorpicker.css') }}

{{ javascript_include('js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
{{ javascript_include('js/colorpicker/js/bootstrap-colorpicker.js') }}


{{ partial("content/partials/single_file_upload", ['uppth': uploadPath]) }}
{{ partial("content/partials/select_content") }}
{{ partial("content/partials/domain_selector_picker") }}

<div class="row">
    <form method="post" autocomplete="on">

    <ul class="pager">
        <li class="previous pull-left">
            <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <h2>Create  {{ formHName }}</h2>
        {{ partial("content/partials/image_uploader", ['uppth': uploadPath]) }}

    {{ hidden_field("form_name","value":formName) }}
    {{ hidden_field("id","value":id) }}
    {{ hidden_field("version","value":"0") }}
    {{ hidden_field("uploadpath","value":uuid) }}


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
                {{ text_field("title_bn","class":"input-xxlarge","required":"required") }}
            </div>
            <div class="tab-pane" id="title_en">
                {{ text_field("title_en","class":"input-xxlarge","required":"required") }}
            </div>
        </div>
    </div>
        {% else %}
        {{ hidden_field("title_bn","value":"") }}
        {{ hidden_field("title_en","value":"") }}
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
                {{ text_area("body_bn","class":"ck-editor") }}
            </div>
            <div class="tab-pane" id="body_en">
                {{ text_area("body_en","class":"ck-editor") }}
            </div>
        </div>
    </div>
        {% else %}
        {{ hidden_field("body_bn","value":"") }}
        {{ hidden_field("body_en","value":"") }}
        {% endif %}

    {% for fld  in formFields %}
        <?php $t = $fld['name'];?>
        <div class="clearfix">
            <label for="name">{{ fld['hname'] }}</label>
            {% if fld['type'] == "htmltext" %}
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#{{fld['name']}}_bn" data-toggle="tab">Bn</a></li>
                  <li><a href="#{{fld['name']}}_en" data-toggle="tab">En</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="{{fld['name']}}_bn">
                      <?php $ttt = $fld['name']."_bn";?>
                    {{ text_area(ttt,"class":"ck-editor") }}
                  </div>
                  <div class="tab-pane" id="{{fld['name']}}_en">
                      <?php $ttt = $fld['name']."_en";?>
                    {{ text_area(ttt,"class":"ck-editor") }}
                  </div>
                </div>
            {% elseif fld['type'] == "text" %}
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#{{fld['name']}}_bn" data-toggle="tab">Bn</a></li>
                  <li><a href="#{{fld['name']}}_en" data-toggle="tab">En</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="{{fld['name']}}_bn">
                      <?php $ttt = $fld['name']."_bn";?>
                    {{ text_area(ttt,"class":"input-xxlarge") }}
                  </div>
                  <div class="tab-pane" id="{{fld['name']}}_en">
                      <?php $ttt = $fld['name']."_en";?>
                    {{ text_area(ttt,"class":"input-xxlarge") }}
                  </div>
                </div>

            {% elseif fld['type'] == "bool" %}
                {{ partial("content/partials/pickers", ['fldtype': 'bool','fldname': fld['name'],'fldval':'0']) }}
            {% elseif fld['type'] == "color" %}
                {{ partial("content/partials/pickers", ['fldtype': 'color','fldname': fld['name'],'fldval':'#000000']) }}
            {% elseif fld['type'] == "date" %}
                {{ partial("content/partials/pickers", ['fldtype': 'date','fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% elseif fld['type'] == "lookuptbl" %}
                {{ partial("content/partials/pickers", ['fldtype': 'lookuptbl','lookupData':lookupData[fld['name']], 'fldname': fld['name'], 'flddependson': fld['dependson'],'fldval':'']) }}
            {% elseif fld['type'] == "filefield" %}
                {{ partial("content/partials/single_file", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "imglist" %}
                {{ partial("content/partials/multi_files", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "nodereference" %}
                {{ partial("content/partials/single_link", ['fldname': fld['name']]) }}
				
            {% elseif fld['type'] == "childcontenttype" %}
                {{ partial("content/partials/child_content_ref", ['show': false]) }}
            {% elseif fld['type'] == "parentcontenttype" %}
                {{ partial("content/partials/parent_content_ref", ['fldname': fld['name'],'fldrefname': fld['contentname']]) }}
            {% elseif fld['type'] == "contentefselect2" %}
                {{ partial("content/partials/contentefselect2", ['fld':fld,'fldname': fld['name'],'fldrefname': fld['contentname'],'title':fld['title'],'required':fld['required']]) }}
            {% elseif fld['type'] == "dependentcontent" %}
                {{ partial("content/partials/dependentcontent", ['fldname': fld['name'],'dependson': fld['dependson'],'required':fld['required']]) }}
            
			{% elseif fld['type'] == "contentref" %}
                {{ partial("content/partials/single_ref", ['fldname': fld['name'],'fldrefname': fld['contentname']]) }}
            {% elseif fld['type'] == "multicontentref" %}
                {{ partial("content/partials/multi_ref", ['fldname': fld['name'],'fldrefname': fld['contentname']]) }}
            {% elseif fld['type'] == "linklist" %}
                {{ partial("content/partials/multi_links", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "multitext" %}
                {{ partial("content/partials/multi_text", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "multihtmltext" %}
                {{ partial("content/partials/multi_htmltext", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "geocode" %}
                {{ partial("content/partials/geocode", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "multiselect" %}
                {{ partial("content/partials/pickers", ['fldtype': 'multiselect','lookupData':lookupData[fld['name']], 'fldname': fld['name'], 'flddependson': fld['dependson'],'fldval':'']) }}
            {% elseif fld['type'] == "domainselector" %}
            {{ partial("content/partials/domain_selector", ['fldname': fld['name'],'did': '','dname':'','required':fld['required']]) }}
            {% elseif fld['type'] == "multidomainselector" %}
            {{ partial("content/partials/multi_domain_selector", ['fldname': fld['name']]) }}
            {% elseif fld['type'] == "email" %}
            {{ partial("content/partials/pickers", ['fldtype': 'email', 'fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% elseif fld['type'] == "number_integer" %}
            {{ partial("content/partials/pickers", ['fldtype': 'number', 'fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% elseif fld['type'] == "number_long" %}
            {{ partial("content/partials/pickers", ['fldtype': 'number', 'fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% elseif fld['type'] == "number_decimal" %}
            {{ partial("content/partials/pickers", ['fldtype': 'decimal', 'fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% else %}
                {{ partial("content/partials/pickers", ['fldtype': '', 'fldname': fld['name'],'fldval':'','required':fld['required']]) }}
            {% endif %}


        </div>
            {% endfor %}
        <div class="clearfix">
            <label for="name">Turn off Right Side Bar</label>

            {{ check_field('is_right_side_bar',"value":"0") }}

        </div>
        <div class="clearfix">
            <label for="name">Publish</label>

            {{ check_field('publish',"value":"1",'checked':'checked') }}

        </div>

        {% if latest_news %}

            <div class="clearfix">
                <label for="name">Publish To Latest News</label>

                {{ check_field('in_latest_news',"value":"0") }}

            </div>

        {% endif %}


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

//        $("form").submit(function (e) {
//            e.preventDefault();
//        });
    });
</script>
