
<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("templateblocks", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}



<div class="center scaffold">
    <h2>Create Template Blocks</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div id="block-content" class="clearfix">
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
                    {{ form.render("title_bn") }}
                </div>
                <div class="tab-pane" id="title_en">
                    {{ form.render("title_en") }}
                </div>
            </div>
        </div>
    </div>




        <div class="clearfix">
            <label for="name">Block View Template (BN)</label><i>(press F11 for fullscreen & Esc to back)</i>
            {{ form.render("volt_bn") }}
        </div>
        <div class="clearfix">
            <label for="name">Block View Template (EN)</label><i>(press F11 for fullscreen & Esc to back)</i>
            {{ form.render("volt_en") }}
        </div>
        <div class="clearfix">
            <label for="name">Block View Query</label>
            {{ form.render("sql") }}
        </div>

        <div class="clearfix">
            <label for="name">Block View CSS</label>
            {{ form.render("css") }}
        </div>
        <div class="clearfix">
            <label for="name">Block View JS</label>
            {{ form.render("js") }}
        </div>


</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("templateblocks", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>

<script>
    $(document).ready(function(){

    });

    var editor_template_bn = CodeMirror.fromTextArea(document.getElementById("volt_bn"), {
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
    var editor_template_en = CodeMirror.fromTextArea(document.getElementById("volt_en"), {
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
        window.editor = CodeMirror.fromTextArea(document.getElementById('sql'), {
            mode: mime,
            indentWithTabs: true,
            lineWrapping: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets : true
        });
    };
</script>