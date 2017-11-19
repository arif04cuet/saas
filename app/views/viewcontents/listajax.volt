
{% for val in page.items %}
{% if loop.first %}
<table id="modal-view-list" class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>View Name</th>
            <th>View Human Name</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td class="view-id">{{ val.name }}</td>
            <td>{{ val.human_name }}</td>
        </tr>
    </tbody>
{% if loop.last %}
</table>
{% endif %}
{% else %}
    No views are recorded
{% endfor %}
