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
{{ javascript_include('js/codemirror/addon/comment/continuecomment.js') }}
{{ javascript_include('js/codemirror/addon/comment/comment.js') }}


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

              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                      Site Setup<b class="caret"></b></a>
                  <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">

                      <li>{{ link_to('domaintypes', 'Domain Types') }}</li>
                      <li>{{ link_to('domaininfos', 'Domains') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('domainresources/contenttypes', 'Domain Content Types') }}</li>
                      <li>{{ link_to('domainresources/views', 'Domain Views') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('offices', 'Offices') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('lookuptypes', 'Taxonomy Types') }}</li>

                      <li class="divider" role="presentation"></li>
                      <li>{{ link_to('contenttype', 'Content Types') }}</li>
                      <li>{{ link_to('regions', 'Regions') }}</li>
                  </ul>
              </li>
              <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">
                      Site Manager<b class="caret"></b></a>
                  <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">

                      <li>{{ link_to('lookups', 'Taxonomy') }}</li>
                      <li>{{ link_to('contenttype', 'Contents') }}</li>
                      <li>{{ link_to('viewcontents', 'Views') }}</li>
                      <li>{{ link_to('pageblocks', 'Blocks') }}</li>
                      <li>{{ link_to('webforms', 'Web Forms') }}</li>
                      <li class="divider"></li>
                      <li>{{ link_to('menus', 'Menus') }}</li>
                      <li class="divider" role="presentation"></li>
                      <li>{{ link_to('hitstat', 'Hit Status') }}</li>
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

<div class="container" style="margin-top:50px">
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