{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
    </li>
    <li class="pull-right">
        {{ link_to("lookuptypes/create", "Create Taxonomy Type", "class": "btn btn-primary") }}
    </li>
</ul>

{% for lookuptype in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ lookuptype.name }}</td>
            <td>{{ lookuptype.description }}</td>
            <td width="">
                {{ link_to("lookuptypes/edit/" ~ lookuptype.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("lookuptypes/delete/" ~ lookuptype.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("lookuptypes/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("lookuptypes/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("lookuptypes/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("lookuptypes/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No lookup types are recorded
{% endfor %}
