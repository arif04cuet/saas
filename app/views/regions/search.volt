{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("regions/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("regions/create", "Create Region", "class": "btn btn-primary") }}
    </li>
</ul>

{% for region in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Last Modified</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ region.name }}</td>
            <td>{{ region.description }}</td>
            <td>{{ region.created }}</td>
            <td>{{ region.lastmodified }}</td>
            <td width="">
                {{ link_to("regions/edit/" ~ region.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("regions/delete/" ~ region.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("regions/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("regions/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("regions/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("regions/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No regions are recorded
{% endfor %}
