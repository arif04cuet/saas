{{ content() }}

<div align="right">
    {{ link_to("templateblocks/create", "<i class='icon-plus-sign'></i> Create Template Blocks", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("templateblocks/search") }}" autocomplete="off">

<div class="center scaffold">

    <h2>Search Template Blocks</h2>

    <div class="clearfix">
        <label for="name">View Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>

</div>

</form>