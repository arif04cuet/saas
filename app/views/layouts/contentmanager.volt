{{ javascript_include('js/ckeditor/ckeditor.js') }}
{{ javascript_include('js/ckeditor/adapters/jquery.js') }}


<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container" style="width: auto;">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            {{ link_to(null, 'class': 'brand', 'NPF Control Panel') }}
            <div class="nav-collapse">

                <ul class="nav">


                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                            Site Manager<b class="caret"></b></a>
                        <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">

                            <li>{{ link_to('lookups/list', 'Taxonomy') }}</li>
                            <li>{{ link_to('contenttype/list', 'Contents') }}</li>
                            <li>{{ link_to('pageblocks', 'Blocks') }}</li>
                            {% if domainname == 'www.pmo.portal.gov.bd' or 'www.pmo.gov.bd' %}
                                <li>{{ link_to('feedback/list', 'Feedback Forms') }}</li>
                            {% endif %}
                            {% if domainname == 'nimc.portal.gov.bd' or 'www.nimc.gov.bd' %}
                                <li>{{ link_to('application/list', 'Application List') }}</li>
                            {% endif %}
                            <li class="divider"></li>
                            <li>{{ link_to('menus', 'Menus') }}</li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                            User Manager<b class="caret"></b></a>
                        <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">

                            <li>{{ link_to('users', 'Users') }}</li>
                        </ul>
                    </li>


                </ul>
                <!--            <form class="navbar-form pull-left">-->
                <!--                <select id="domain-switcher" onchange="switchDomain(this)">-->
                <!--                    <option value="cabinet.gov.bd">cabinet.gov.bd</option>-->
                <!--                    <option value="dpe.gov.bd">dpe.gov.bd</option>-->
                <!--                </select>-->
                <!--            </form>-->
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth.getName() }} <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('users/changePassword', 'Change Password') }}</li>
                        </ul>
                    </li>
                    <li>{{ link_to('session/logout', 'Logout') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:40px">
    {{ content() }}
</div>

<script>
    function switchDomain(select) {
        var selected_host = $(select).val();
        //var url = window.location;
        var protocol = window.location.protocol;
        var host = window.location.host;
        var uri = window.location.pathname;
        //console.debug(url);
        var url = protocol + "//" + selected_host + uri;
        window.location = url;

    }

    $(document).ready(function () {
        var host = window.location.host;
        $("#domain-switcher").val(host);
    });
</script>