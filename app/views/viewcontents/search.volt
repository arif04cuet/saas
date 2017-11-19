{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("viewcontents/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("viewcontents/create", "Create View", "class": "btn btn-primary") }}
    </li>
</ul>

{% for val in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>View Name</th>
            <th>View Human Name</th>
            <th>Actions</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ val.name }}</td>
            <td>{{ val.human_name }}</td>
            <td width="">
                {{ link_to("viewcontents/edit/" ~ val.id, '<i class="icon-pencil"></i>', "class": "btn") }}
                {{ link_to("viewcontents/delete/" ~ val.id, '<i class="icon-remove"></i>', "class": "btn") }}
                <a class="btn" onclick="OpenInNewTab(this);return false;" href="/site/view/{{ val.name }}"><i class="icon-list"></i> view </a>
            </td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("viewcontents/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("viewcontents/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("viewcontents/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("viewcontents/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No views are recorded
{% endfor %}
<script>
    function OpenInNewTab(a )
    {
        var url = $(a).attr('href');
        var win=window.open(url, '_blank');
        win.focus();
        return false;
    }
</script>