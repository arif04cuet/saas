{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("application/list", "&larr; Go Back") }}
    </li>
</ul>
<?php $m=1;?>
{% for application in list %}
    {% if loop.first %}
        <table class="table table-bordered table-striped feedbacks" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th class="span3">Course Name</th>
            <th>Applicant Name</th>
            <th class="span2">Phone</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}


    <tr>
        <td><?php echo $m;?></td>
        <td><?php echo $application['courseName']?></td>
        <td><?php echo $application['txtStuName']?></td>
        <td><?php echo $application['txtRPhoneNo']?></td>
        <td><?php echo $application['created']?></td>
        <td width="">
            {{ link_to("application/show/" ~ application[0], '<i class="icon-comment"></i> Details', "class": "btn") }}
            {{ link_to("application/delete/" ~ application[0], '<i class="icon-remove"></i>', "class": "btn delete") }}
        </td>
    </tr>

    <?php $m++;?>
    <?php $pageNo = isset($_GET['page']) ?$_GET['page']:1;$next = $pageNo+1;$prev=($pageNo-1)?$pageNo-1:1?>
    {% if loop.last %}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("application/list?page=" ~ prev, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("application/list?page=" ~ next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}

                </div>
            </td>
        </tr>
        </tfoot>
        </table>
    {% endif %}
{% else %}
    No records;
{% endfor %}

<script type="text/javascript">
    $(document).ready(function () {
        $('.feedbacks a.delete').click(function () {
            return confirm("Are you sure");
        });
    });
</script>
