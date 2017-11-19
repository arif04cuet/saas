{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        <a onclick="goBack(); return false;" href="javascript:;">&larr; Go Back</a>
    </li>
    <li class="pull-right">
        {{ link_to("domaininfos/create", "Create Domain", "class": "btn btn-primary") }}
    </li>
</ul>

{% for domain in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Domain Type</th>
            <th>Domain Name</th>
            <th>Sitename</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ domain.npfdomaintypes.name }}</td>
            <td>{{ domain.subdomain }}</td>
            <td>{{ domain.sitename_bn }}</td>
            <td width="">
                {{ link_to("domaininfos/edit/" ~ domain.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("domaininfos/delete/" ~ domain.id, '<i class="icon-remove"></i>', "class": "btn") }}
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("domaininfos/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("domaininfos/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("domaininfos/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("domaininfos/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No domaininfos are recorded
{% endfor %}
