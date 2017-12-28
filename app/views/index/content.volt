{{ content() }}

<div class="row">
    <form method="post" autocomplete="off">
        <h2>Create {{ formHName }}</h2>
        {{ hidden_field("form_name","value":formName) }}

        <div class="clearfix">
            <label for="name">Title</label>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#title_bn" data-toggle="tab">Bn</a>
                </li>
                <li>
                    <a href="#title_en" data-toggle="tab">En</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="title_bn">
                    {{ text_field("title_bn","class":"summernote") }}
                </div>
                <div class="tab-pane active" id="title_en">
                    {{ text_field("title_en","class":"summernote") }}
                </div>
            </div>
        </div>


        <div class="clearfix">
            <label for="name">Body</label>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#body_bn" data-toggle="tab">Bn</a>
                </li>
                <li>
                    <a href="#body_en" data-toggle="tab">En</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="title_bn">
                    {{ text_field("body_bn","class":"summernote") }}
                </div>
                <div class="tab-pane active" id="title_en">
                    {{ text_field("body_en","class":"summernote") }}
                </div>
            </div>
        </div>

        {% for fld in formFields %}
        <div class="clearfix">
            <label for="name">{{ fld['hname'] }}</label>
            {% if fld['type'] == "text" %}
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#{{fld['name']}}_bn" data-toggle="tab">Bn</a>
                </li>
                <li>
                    <a href="#{{fld['name']}}_en" data-toggle="tab">En</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="{{fld['name']}}_bn">
                    <?php $t = $fld['name']."_bn";?> {{ text_field(t,"class":"summernote") }}
                </div>
                <div class="tab-pane" id="{{fld['name']}}_en">
                    <?php $t = $fld['name']."_en";?> {{ text_field(t,"class":"summernote") }}
                </div>
            </div>
            {% else %} {{ text_field(fld['name']) }} {% endif %}
        </div>
        {% endfor %}
    </form>
</div>