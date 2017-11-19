<div class="center scaffold">
    <h2>Content Types</h2>

{% for contentType in contentTypes %}
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
        <td>{{ contentType.human_name }}</td>
        <td width="">
            <a href="{{ contentType.name }}" class="btn content-type-link"><i class="icon-list"></i></a>

        </td>
    </tr>
    </tbody>
    {% if loop.last %}
</table>

{% endif %}
{% else %}
No content types are recorded
{% endfor %}
