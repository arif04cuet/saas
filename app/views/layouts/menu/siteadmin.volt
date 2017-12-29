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
							
                             {% if domainname == 'pmo.portal.gov.bd' %}
                                <li>{{ link_to('feedback/list', 'Feedback Forms') }}</li>
						   {% endif %}
						   
							{% if domainname == 'nimc.portal.gov.bd' %}
								 <li>{{ link_to('application/list', 'Application List') }}</li>
							{% else %}
								<li>{{ link_to('application/listForm', 'Application List') }}</li>
							{% endif %}
							
                            <li class="divider"></li>
                            <li>{{ link_to('menus', 'Menus') }}</li>
                            <li>{{ link_to('application/logs', 'Audit Log') }}</li>
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

<br><br>
<div class="container">
    {{content()}}
</div>
