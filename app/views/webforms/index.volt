{{ content() }}

<div align="right">
    {{ link_to("webforms/create", "<i class='icon-plus-sign'></i> Create Web Forms", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("webforms/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Web Forms</h2>

        <div class="clearfix">
            <label for="name">Form Title</label>
            {{ form.render("form_title") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>
    </div>
</form>
