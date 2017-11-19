

{% if page %}
{% for content in page['data'] %}
{% if loop.first %}
<table id="modal-content-list" class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Id</th>

        {% for fldName in fldNames %}
        <th>{{ fldName }}</th>
        {% endfor %}
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <?php $content = get_object_vars($content);?>
        <td class="content-id">{{ content['id'] }}</td>


        {% for fld in fldLst %}
        <td>{{ content[''~fld] }}</td>
        {% endfor %}
        <td>{% if content['publish'] %}
            <span class="label label-success">published</span>
            {% else %}
            <span class="label label-important">unpublished</span>
            {% endif %}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    
    <tbody>
</table>
{% endif %}
{% else %}
No users are recorded
{% endfor %}
{% endif %}

