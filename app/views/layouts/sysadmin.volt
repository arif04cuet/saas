{{ javascript_include('js/ckeditor/ckeditor.js') }}
{{ javascript_include('js/ckeditor/adapters/jquery.js') }}

{{ stylesheet_link('js/codemirror/lib/codemirror.css') }}
{{ stylesheet_link('js/codemirror/addon/display/fullscreen.css') }}
{{ stylesheet_link('js/codemirror/theme/night.css') }}


{{ javascript_include('js/codemirror/lib/codemirror.js') }}
{{ javascript_include('js/codemirror/addon/edit/matchbrackets.js') }}
{{ javascript_include('js/codemirror/addon/display/fullscreen.js') }}
{{ javascript_include('js/codemirror/addon/selection/active-line.js') }}
{{ javascript_include('js/codemirror/addon/edit/closebrackets.js') }}
{{ javascript_include('js/codemirror/addon/edit/closetag.js') }}


{{ javascript_include('js/codemirror/mode/xml/xml.js') }}
{{ javascript_include('js/codemirror/mode/javascript/javascript.js') }}
{{ javascript_include('js/codemirror/mode/css/css.js') }}
{{ javascript_include('js/codemirror/mode/clike/clike.js') }}
{{ javascript_include('js/codemirror/mode/htmlmixed/htmlmixed.js') }}

{{ javascript_include('js/codemirror/mode/php/php.js') }}
{{ javascript_include('js/codemirror/mode/sql/sql.js') }}

<style>
    .CodeMirror-fullscreen{
        z-index: 1040!important;
    }
    .CodeMirror {
        border-top: 1px solid black; border-bottom: 1px solid black;
    }
</style>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container" style="width: auto;">
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
          <li>{{ link_to('session/logout', 'Logout') }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="container" style="margin-top:45px">
  {{ content() }}
</div>

<script>
    function switchDomain(select){
        var selected_host = $(select).val();
        //var url = window.location;
        var protocol = window.location.protocol;
        var host = window.location.host;
        var uri = window.location.pathname;
        //console.debug(url);
        var url = protocol+"//"+selected_host+uri;
        window.location = url;

    }

    $(document).ready(function(){
        var host = window.location.host;
        $("#domain-switcher").val(host);
    });
</script>