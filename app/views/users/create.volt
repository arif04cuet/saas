
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("users", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Create a User</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>
    <div class="clearfix">
        <label for="profilesId">Profile</label>
        {{ form.render("profilesId") }}
    </div>
    <div class="clearfix">
        <label for="email">E-Mail</label>
        {{ form.render("email") }}
    </div>
    <div class="clearfix">
        <label for="email">Designation</label>
        {{ form.render("designation") }}
    </div>
    <div class="clearfix">
        <label for="email">ID Number</label>
        {{ form.render("id_number") }}
    </div>
    <div class="clearfix">
        <label for="email">Description</label>
        {{ form.render("description") }}
    </div>

</div>

</form>