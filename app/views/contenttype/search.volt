{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
    </li>
    <li class="pull-right">
        {{ link_to("contenttype/create", "Create Content Type", "class": "btn btn-primary") }}
    </li>
</ul>

{% for contentType in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Content Type</th>
            <th>Created At</th>
            <th>Last Modified At</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ contentType.id }}</td>
            <td>{{ contentType.human_name }}</td>
            <td>{{ contentType.created }}</td>
            <td>{{ contentType.lastmodified }}</td>
            <td width="">
                {{ link_to("content/" ~ contentType.name, '<i class="icon-list"></i>', "class": "btn") }}
                {{ link_to("contenttype/edit/" ~ contentType.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("contenttype/delete/" ~ contentType.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("contenttype/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("contenttype/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("contenttype/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("contenttype/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No users are recorded
{% endfor %}
