{{ content() }}

<div align="right">
    {{ link_to("offices/create", "<i class='icon-plus-sign'></i> Create Office", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("offices/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Office</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name_bn") }}
        </div>
        <div class="clearfix">
            <label for="name">Domain</label>
            {{ form.render("domain_id") }}
        </div>


        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>