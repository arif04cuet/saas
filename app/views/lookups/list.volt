{{ content() }}

<div class="center scaffold">
    <h2>Taxonomy Types</h2>

{% for lookuptype in lookupTypes %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Name</th>
        <th>Action</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ lookuptype.description }}</td>
        <td width="">
            {{ link_to("lookups/search?lookuptype_id=" ~ lookuptype.id, '<i class="icon-list"></i>', "class": "btn") }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
</table>
{% endif %}
{% else %}
No lookup types are recorded
{% endfor %}
</div>
