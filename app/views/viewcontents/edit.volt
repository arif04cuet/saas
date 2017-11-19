

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("viewcontents", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}
    <h3>Edit View</h3>
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
        <label for="name">Disable Right Side-bar</label>
        {{ form.render("is_right_side_bar") }}
    </div>
    <div class="clearfix">
        <label for="name">Apply Pagination</label>
        {{ form.render("is_pagination") }}
    </div>
    <div class="clearfix">
        <label for="name">Header</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#header-bn-tab" data-toggle="tab">Bn</a></li>
            <li><a href="#header-en-tab" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="header-bn-tab">
                {{ form.render("header_bn") }}
            </div>
            <div class="tab-pane" id="header-en-tab">
                {{ form.render("header_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Footer</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#footer-bn-tab" data-toggle="tab">Bn</a></li>
            <li><a href="#footer-en-tab" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="footer-bn-tab">
                {{ form.render("footer_bn") }}
            </div>
            <div class="tab-pane" id="footer-en-tab">
                {{ form.render("footer_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">View Template (BN)</label><i>(press F11 for fullscreen & Esc to back)</i>
        {{ form.render("template_bn") }}
    </div>
    <div class="clearfix">
        <label for="name">View Template (EN)</label><i>(press F11 for fullscreen & Esc to back)</i>
        {{ form.render("template_en") }}
    </div>
    <div class="clearfix">
        <label for="name">Query</label>
        {{ form.render("sql_query") }}
    </div>

    <div class="clearfix">
        <label for="name">CSS</label>
        {{ form.render("css") }}
    </div>
    <div class="clearfix">
        <label for="name">js</label>
        {{ form.render("js") }}
    </div>

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("viewcontents", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>

<script type="text/javascript">
    $(document).ready(function()
    {
        $( '.ck-editor' ).ckeditor( {
            filebrowserBrowseUrl : '/uploader?ckeditor=1&uppth={{ uploadPath }}'
        } );

    });
    var editor_template_bn = CodeMirror.fromTextArea(document.getElementById("template_bn"), {
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
    var editor_template_en = CodeMirror.fromTextArea(document.getElementById("template_en"), {
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
        window.editor = CodeMirror.fromTextArea(document.getElementById('sql_query'), {
            mode: mime,
            indentWithTabs: true,
            smartIndent: true,
            lineWrapping: true,
            lineNumbers: true,
            matchBrackets : true
        });
    };
</script>
