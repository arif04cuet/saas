<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}

    <div class="center scaffold">

        <h2>Create Taxonomy Type</h2>
        {{ form.render("id") }}


        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>

        <div class="clearfix">
            <label for="name">Description</label>
            {{ form.render("description") }}
        </div>
        <div class="clearfix">
            <label for="name">Parent</label>
            {{ form.render("lookuptype_id") }}
        </div>
        <div class="clearfix">
            <label for="name">Is Common</label>
            {{ form.render("is_common") }}
        </div>
    </div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("lookuptypes", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>