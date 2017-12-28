<ul class="pager">
    <li class="previous pull-left">
        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
    </li>
    <li class="pull-right">
        {{ link_to("content/"~ contentType ~"/create", "Add Content", "class": "btn btn-primary") }}
    </li>
</ul>

{% if page %}
{% for content in page['data'] %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th style="display: none">Id</th>

        {% for fldName in fldNames %}
        <th>{{ fldName }}</th>
        {% endfor %}
        <th></th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <?php $content = get_object_vars($content);?>
        <td  style="display: none">{{ content['id'] }}</td>


        {% for fld in fldLst %}
        <td>{{ content[''~fld] }}</td>
        {% endfor %}
        <td>{% if content['publish'] %}
            <span class="label label-success">published</span>
            {% else %}
            <span class="label label-important">unpublished</span>
            {% endif %}
        </td>

        <td width="150">
        {{ link_to("content/"~ contentType ~"/edit/" ~ content['id'] ~ "/" ~ content['version'], '<i class="icon-pencil"></i>', "class": "btn btn-primary btn-small", "rel":"tooltip", "data-placement":"bottom", "data-original-title":"Edit") }}
        {{ link_to("content/"~ contentType ~"/delete/" ~ content['id'], '<i class="icon-remove"></i>', "class": "btn btn-danger btn-small", "rel":"tooltip", "data-placement":"bottom", "data-original-title":"Delete","onclick":"return confirm_delete();") }}
        {{ link_to("content/"~ contentType ~"/versions/" ~ content['id'], '<i class="icon-calendar"></i>', "class": "btn btn-info  btn-small", "rel":"tooltip", "data-placement":"bottom", "data-original-title":"History") }}
        <a class="btn btn-success  btn-small" onclick="OpenInNewTab(this);return false;" href="/site/{{ contentType ~"/" ~ content['id']}}" data-original-title="View" data-placement="bottom" rel="tooltip"><i class="icon-share"></i> </a></td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("content/"~ contentType ~"", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                {{ link_to("content/"~ contentType ~"?page=" ~ page['before'], '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                {{ link_to("content/"~ contentType ~"?page=" ~ page['next'], '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                {{ link_to("content/"~ contentType ~"?page=" ~ page['last'], '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                <span class="help-inline">{{ page['current'] }}/{{ page['total_pages'] }}</span>
            </div>
        </td>
    </tr>
    <tbody>
</table>
{% endif %}
{% else %}
No users are recorded
{% endfor %}
{% endif %}

<script>
    function OpenInNewTab(a )
    {
        var url = $(a).attr('href');
        var win=window.open(url, '_blank');
        win.focus();
        return false;
    }
    $('#example').tooltip();
    function confirm_delete(){
        var r=confirm("Are you sure to delete the record?");
        if (r==true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
