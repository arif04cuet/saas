{{ content() }}

<div class="center scaffold">
    <h2>Forms List</h2>

{% for formspay in formspay %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ formspay.id }}</td>
        <td>{{ formspay.form_name }}</td>
        <td width="">
            {{ link_to("formspay/show/" ~ formspay.id, '<i class="icon-pencil"></i>', "class": "btn") }}
            {{ link_to("formspay/delete/" ~ formspay.id, '<i class="icon-remove"></i>', "class": "btn") }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
</table>
{% endif %}
{% else %}
No forms are recorded
{% endfor %}
</div>