{{ content() }}
<form method="post" autocomplete="off" action="<?php echo $this->url->get('webforms/saveform') ?>">
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("webforms", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            <!--{{ submit_button("Save", "class": "btn btn-success") }}-->
        </li>
    </ul>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
    {{ javascript_include('js/jquery.formbuilder.js') }}

    {{ stylesheet_link('css/jquery.formbuilder.css') }}

    <style type="text/css">
        a, body {
            font-family: "Tahoma", "Verdana", sans-serif;
            font-size: 12px;
        }
    </style>
    <script>
        $(function () {

            var dt = "";//JSON.parse('{"t":"t"}');
            var $t = $('#my-form-builder').formbuilder({
                'save_url': '<?php echo $this->url->get("webforms/saveform") ?>',
                'load_url': false,
                'dt': dt,
                'useJson': true
            });
            $("#my-form-builder ul").sortable({ opacity: 0.6, cursor: 'move'});


        });
    </script>

    <div class="center scaffold">

        <h2>Create Webform</h2>

        <div class="clearfix">
            <label for="name">Machine Name</label>
            {{ form.render("machine_name") }}
        </div>

        <div class="clearfix">
            <label for="name">Active</label>
            {{ form.render("active") }}
        </div>

        <div class="clearfix">
            <label for="name">Form title</label>
            {{ form.render("form_title") }}
        </div>

       {# <div class="clearfix">
            <label for="name">Action Type</label>
            {{ form.render("action_type") }}
        </div>

        <div class="clearfix">
            <label for="name">Action Path</label>
            {{ form.render("action_path") }}
        </div>#}
        <div class="clearfix">
            <label for="name">Message After Form Submission</label>
            {{ form.render("form_msg") }}
        </div>
        <div class="clearfix">
            <label for="name">Email (Optional)</label>
            {{ form.render("form_email") }}
        </div>
        <div class="clearfix">
            <label for="name">Header Note</label>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#header_bn" data-toggle="tab">Bn</a></li>
                <li><a href="#header_en" data-toggle="tab">En</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="header_bn">
                    {{ form.render("header_bn") }}
                </div>
                <div class="tab-pane" id="header_en">
                    {{ form.render("header_en") }}
                </div>
            </div>
        </div>

        <div class="clearfix">
            <label for="name">Footer Note</label>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#footer_bn" data-toggle="tab">Bn</a></li>
                <li><a href="#footer_en" data-toggle="tab">En</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="footer_bn">
                    {{ form.render("footer_bn") }}
                </div>
                <div class="tab-pane" id="footer_en">
                    {{ form.render("footer_en") }}
                </div>
            </div>
        </div>

        <div class="clearfix" id="my-form-builder"></div>

    </div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("webforms", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            <!--{{ submit_button("Save", "class": "btn btn-success") }}-->
        </li>
    </ul>
</form>

<script type="text/javascript">

    $(document).ready(function () {
        $('.ck-editor').ckeditor({
        });

    });

</script>