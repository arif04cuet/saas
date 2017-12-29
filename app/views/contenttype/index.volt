

<div align="right">
    {{ link_to("contenttype/create", "<i class='icon-plus-sign'></i> Create Content Type", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("contenttype/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Content Type</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>
        <div class="clearfix">
            <label for="name">Human Name</label>
            {{ form.render("human_name") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>