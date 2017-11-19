{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("webforms/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("webforms/create", "Create Web Forms", "class": "btn btn-primary") }}
    </li>
</ul>

{% for webforms in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Form Title</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ webforms.form_title }}</td>
        <td>{{ webforms.active==0?"Inactive":"Active" }}</td>
        <td width="">
            {{ link_to("webforms/edit/" ~ webforms.id, '<i class="icon-pencil"></i>', "class": "btn") }}
            {{ link_to("webforms/delete/" ~ webforms.id, '<i class="icon-remove"></i>', "class": "btn") }}
            {{ link_to('http://'~domainname~"/forms/form/" ~ webforms.machine_name, '<i class="icon-share"></i>', "class": " btn btn-success  btn-small","target":"_blank") }}
            {{ link_to("webform/" ~ webforms.machine_name~"/list", '<i class="icon-list"></i>Data', "class": " btn btn-success") }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("webforms/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("webforms/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("webforms/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("webforms/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        <tbody>
        </table>
    {% endif %}
{% else %}
    No forms are recorded
{% endfor %}