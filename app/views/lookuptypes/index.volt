{{ content() }}

<div align="right">
    {{ link_to("lookuptypes/create", "<i class='icon-plus-sign'></i> Create Taxonomy Type", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("lookuptypes/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Taxonomy Types</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>
        <div class="clearfix">
            <label for="name">Description</label>
            {{ form.render("description") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>