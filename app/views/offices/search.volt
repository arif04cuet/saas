{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("offices/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("offices/create", "Create Office", "class": "btn btn-primary") }}
    </li>
</ul>

{% for office in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Office Name</th>
            <th>Address</th>
            <th>Domain</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ office.name_bn }}</td>
            <td>{{ office.address_bn }}</td>

            <td>{{ office.domain_id?office.npfdomains.sitename_bn:"" }}</td>
            <td width="">
                {{ link_to("offices/edit/" ~ office.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("offices/delete/" ~ office.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("offices/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("offices/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("offices/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("offices/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No domains are recorded
{% endfor %}
