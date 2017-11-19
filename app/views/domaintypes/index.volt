{{ content() }}

<div align="right">
    {{ link_to("domaintypes/create", "<i class='icon-plus-sign'></i> Create Domain Type", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("domaintypes/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Domain Type</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>