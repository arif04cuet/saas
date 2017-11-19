{{ content() }}

<div align="right">
    {{ link_to("domaininfos/create", "<i class='icon-plus-sign'></i> Create Domain", "class": "btn btn-primary") }}
</div>

<form method="post" action="{{ url("domaininfos/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Search Domain</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("sitename_bn") }}
        </div>
        <div class="clearfix">
            <label for="name">Domain Name</label>
            {{ form.render("subdomain") }}
        </div>
        <div class="clearfix">
            <label for="name">Domain Type</label>
            {{ form.render("domain_type_id") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>