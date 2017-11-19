{{ content() }}

<div align="right">
    {{ link_to("regions/create", "<i class='icon-plus-sign'></i> Create Region", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("regions/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Region</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>