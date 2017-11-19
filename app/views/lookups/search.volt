{{ content() }}

<ul class="pager">
    <li class="previous pull-left">

        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>

    </li>
    <li class="pull-right">
        {{ link_to("lookups/create?lookuptype_id="~lookuptype_id, "Create Taxonomy", "class": "btn btn-primary") }}
    </li>
</ul>

{% for lookup in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name (bn)</th>
            <th>Name (en)</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ lookup.id }}</td>
            <td>{{ lookup.name_bn }}</td>
            <td>{{ lookup.name_en }}</td>
            <td width="">
                {{ link_to("lookups/edit/" ~ lookup.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("lookups/delete/" ~ lookup.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("lookups/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("lookups/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("lookups/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("lookups/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}

{% endfor %}
