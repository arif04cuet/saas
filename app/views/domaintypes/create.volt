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

    <h2>Create Domain Type</h2>

    <div class="clearfix">
        <label for="name">Domain Type Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="name">Domain Type</label>
        {{ form.render("parent_id") }}
    </div>

</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("domaintypes", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>

<script type="text/javascript">
    $(document).ready(function(){
    });
</script>