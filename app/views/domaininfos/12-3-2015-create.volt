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

    <h2>Create Domain</h2>

    <div class="clearfix">
        <label for="name">Full Qualified Domain Name</label>
        {{ form.render("subdomain") }}
    </div>
    <div class="clearfix">
        <label for="name">Full Qualified Alias Name</label>
        {{ form.render("alias") }}
    </div>
    <div class="clearfix">
        <label for="name">Site Name</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#sitename_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#sitename_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="sitename_bn">
                {{ form.render("sitename_bn") }}
            </div>
            <div class="tab-pane" id="sitename_en">
                {{ form.render("sitename_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Site Default Language</label>
        {{ form.render("site_default_language") }}
    </div>
    <div class="clearfix">
        <label for="name">Site Template</label>
        {{ form.render("template") }}
    </div>


    <div class="clearfix">
        <label for="name">Domain Type</label>
        {{ form.render("domain_type_id") }}
    </div>

    <div class="clearfix">
        <label for="name">Parent Domain</label>
        {{ form.render("parent_id") }}
    </div>

    <div class="clearfix">
        <label for="name">Site Offline</label>
        {{ form.render("site_offline") }}
    </div>

    <div class="clearfix">
        <label for="name">Active</label>
        {{ form.render("active") }}
    </div>

    <div class="clearfix">
        <label for="name">Is site hosted in the current server?</label>
        {{ form.render("is_hosted") }}
    </div>

    <div class="clearfix">
        <label for="name">Site Status</label>
        {{ form.render("site_status") }}
    </div>
    <div class="clearfix">
        <label for="name">External Link</label>
        {{ form.render("external_link") }}
    </div>





    <div class="clearfix">
        <label for="name">Site Frontpage</label>
        {{ form.render("site_frontpage") }}
    </div>
    <div class="clearfix">
        <label for="name">Site Email</label>
        {{ form.render("site_mail") }}
    </div>

    <div class="clearfix">
        <label for="name">Site Slogan </label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#site_slogan_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#site_slogan_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="site_slogan_bn">
                {{ form.render("site_slogan_bn") }}
            </div>
            <div class="tab-pane" id="site_slogan_en">
                {{ form.render("site_slogan_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Site Mission</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#site_mission_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#site_mission_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="site_mission_bn">
                {{ form.render("site_mission_bn") }}
            </div>
            <div class="tab-pane" id="site_mission_en">
                {{ form.render("site_mission_en") }}
            </div>
        </div>
    </div>
    <div class="clearfix">
        <label for="name">Site Footer</label>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#site_footer_bn" data-toggle="tab">Bn</a></li>
            <li><a href="#site_footer_en" data-toggle="tab">En</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="site_footer_bn">
                {{ form.render("site_footer_bn") }}
            </div>
            <div class="tab-pane" id="site_footer_en">
                {{ form.render("site_footer_en") }}
            </div>
        </div>
    </div>
</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("domaininfos", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>

<script type="text/javascript">
    $(document).ready(function()
    {
        $( '.ck-editor' ).ckeditor( {
        } );

    });
</script>