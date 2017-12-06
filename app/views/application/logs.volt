{{ content() }}
<META HTTP-EQUIV="refresh" CONTENT="15">
<?php $m=1;?>
{% for log in logs %}
    {% if loop.first %}
    <table class="table table-bordered table-striped feedbacks" align="center">
    <thead>
    <tr>
        <th>User</th>
        <th class="span5">Activity</th>
        <th class="">Portal</th>
        <th>IP</th>
        <th class="span2">Date</th>
    </tr>
    </thead>
    <tbody>
    {% endif %}


<tr>

    <td><?php echo $log->user->name ?></td>
    <td><?php echo $log->changes ?></td>
    <td><?php echo $log->getDomainName()->sitename_bn ?></td>
    <td><?php echo $log->ipAddress ?></td>
    <td><?php echo $log->change_time ?></td>

</tr>

<?php $m++;?>
<?php $pageNo = isset($_GET['page']) ?$_GET['page']:1;$next = $pageNo+1;$prev=($pageNo-1)?$pageNo-1:1?>
{% if loop.last %}
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("application/logs?page=" ~ prev, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                {{ link_to("application/logs?page=" ~ next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}

            </div>
        </td>
    </tr>
    </tfoot>
    </table>
{% endif %}
{% else %}
    No Records found.
{% endfor %}


