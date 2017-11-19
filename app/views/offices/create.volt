<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("offices", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2>Create Office</h2>
    <div class="clearfix">
        <label for="name">Domain</label>
        {{ form.render("domain_id") }}
    </div>
    <div class="clearfix">
        <label for="name">Office Name</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#name_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#name_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="name_bn">
                {{ form.render("name_bn") }}
            </div>
            <div class="tab-pane" id="name_en">
                {{ form.render("name_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Office Address</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#address_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#address_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="address_bn">
                {{ form.render("address_bn") }}
            </div>
            <div class="tab-pane" id="address_en">
                {{ form.render("address_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Phone</label>
        {{ form.render("phone") }}
    </div>

    <div class="clearfix">
        <label for="name">Email</label>
        {{ form.render("email") }}
    </div>

</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("offices", "&larr; Go Back") }}
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