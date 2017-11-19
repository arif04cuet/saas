
<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("pageblocks", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}



<div class="center scaffold">
    <h2>Create Blocks</h2>

    {{ partial("content/partials/select_content") }}

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

    <div id="div-block-body" class="clearfix">
        <label for="name">Body</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#body_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#body_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="body_bn">
                {{ form.render("body_bn") }}
            </div>
            <div class="tab-pane" id="body_en">
                {{ form.render("body_en") }}
            </div>
        </div>
    </div>

    <div  id="block-content-ref" class="clearfix">
        <label for="name">More Button Reference</label>
        <div class="input-append">
            {{ form.render("more") }}
            <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent(this,''); return false;"><i class="icon-search"></i></a>

        </div>
    </div>

    <div id="div-block-template" class="clearfix">
        <label for="name">Template Block</label>
        {{ form.render("template_block_name") }}
    </div>



</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("pageblocks", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>

<script>
    $(document).ready(function(){
        $( '.ck-editor' ).ckeditor( {
            filebrowserBrowseUrl : '/uploader?ckeditor=1&uppth={{ uploadPath }}'
        } );

    });


</script>