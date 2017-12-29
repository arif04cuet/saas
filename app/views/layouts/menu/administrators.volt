
  

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container" style="">

      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      {{ link_to(null, 'class': 'brand', 'NPF Control Panel')}}
        <div class="nav-collapse">

          <ul class="nav">

            <?php //if($profile['profile'] == 'Administrators' || $profile['profile'] == 'Master Trainers'):?>
              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                      Domain Manager<b class="caret"></b></a>
                  <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">
                      <li>{{ link_to('domaintypes', 'Domain Types') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('domaininfos', 'Domain Control') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('domaininfos/migrate', 'Migrate Domain') }}</li>
                      <li>{{ link_to('domaininfos/clone', 'Clone Domain') }}</li>
                      <li>{{ link_to('domaininfos/clean', 'Clean Domain') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('domainresources/setupcontenttypes', 'Default Domain Content Types') }}</li>
                      <li>{{ link_to('domainresources/setupviews', 'Default Domain Views') }}</li>
                      <li>{{ link_to('domainresources/setuptaxonomy', 'Default Domain Taxonomy') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('domainresources/contenttypes', 'Domain Content Types') }}</li>
                      <li>{{ link_to('domainresources/views', 'Domain Views') }}</li>
                      <li>{{ link_to('domainresources/taxonomy', 'Domain Taxonomy') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('offices', 'Domain Offices') }}</li>
                  </ul>
              </li>
              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                      Site Setup<b class="caret"></b></a>
                  <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">


                      <li>{{ link_to('lookuptypes', 'Taxonomy Types') }}</li>

                      <li class="divider" role="presentation"></li>
                      <li>{{ link_to('contenttype', 'Content Types') }}</li>
                      <li>{{ link_to('templateblocks', 'Template Blocks') }}</li>
                      <li>{{ link_to('regions', 'Regions') }}</li>
                      <li class="divider" role="presentation"></li>
                      <li>{{ link_to('hitstat', 'Hit Status') }}</li>
                  </ul>
              </li>
              <?php //endif;?>
              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                      Site Manager<b class="caret"></b></a>
                  <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">

                      <li>{{ link_to('lookups/list', 'Taxonomy') }}</li>
                      <li>{{ link_to('contenttype/list', 'Contents') }}</li>
                      <li>{{ link_to('viewcontents', 'Views') }}</li>
                      <li>{{ link_to('pageblocks', 'Blocks') }}</li>
                      <li>{{ link_to('webforms', 'Web Forms') }}</li>
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
                      <li>{{ link_to('profiles', 'Profiles') }}</li>
                      <li>{{ link_to('permissions', 'Permissions') }}</li>
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
                <li><a href="http://{{ domainname }}" target="_blank" > View Site </a></li>
                <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth.getName() }} <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>{{ link_to('users/changePassword', 'Change Password') }}</li>
            </ul>
          </li>
          <li>{{ link_to('session/logout', 'Logout','style':'color:#fff') }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<br><br>
<div class="container">
    {{content()}}
</div>

