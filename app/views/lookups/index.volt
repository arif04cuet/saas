{{ content() }}

<div align="right">
    {{ link_to("lookups/create", "<i class='icon-plus-sign'></i> Create Lookup", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("lookups/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Taxonomy</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name_bn") }}
        </div>
        <div class="clearfix">
            <label for="name">Lookup Type</label>
            {{ form.render("lookuptype_id") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>