{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("formspay/list", "&larr; Go Back") }}
    </li>
</ul>

{% for formspay in page.items %}
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
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("formspay/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("formspay/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("formspay/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("formspay/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No formspay are recorded
{% endfor %}
