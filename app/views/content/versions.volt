{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
    </li>
</ul>

{% if page %}
{% for content in page['data'] %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Id</th>
        <th>title</th>
        <th>version</th>
        <th>publish</th>
        <th>active</th>
        <th>Created At</th>
        <th>Last Modified At</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ content.id }}</td>
        <td>{{ content.title_bn }}</td>
        <td>{{ content.version }}</td>
        <td>{{ content.publish }}</td>
        <td>{{ content.active }}</td>
        <td>{{ content.created }}</td>
        <td>{{ content.lastmodified }}</td>
        <td width="12%">{{ link_to("content/"~ contentType ~"/editversion/" ~ content.id ~ "/" ~ content.version, '<i class="icon-pencil"></i> Edit', "class": "btn") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("content/"~ contentType ~"/versions/"~content.id, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                {{ link_to("content/"~ contentType ~"/versions/"~content.id~"?page=" ~ page['before'], '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                {{ link_to("content/"~ contentType ~"/versions/"~content.id~"?page=" ~ page['next'], '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                {{ link_to("content/"~ contentType ~"/versions/"~content.id~"?page=" ~ page['last'], '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
