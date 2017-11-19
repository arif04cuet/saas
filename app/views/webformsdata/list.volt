{{ content() }}
<?php  $route = 'webform/'.$machine_name.'/list'; ?>
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to('/webforms', "&larr; Go Back") }}
    </li>
</ul>
<?php $m=1;?>
{% for item in page.items %}

    {% if loop.first %}
        <table class="table table-bordered table-striped feedbacks" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th class="span2">Form Name</th>
            <?php foreach($item->getFields() as $key=>$value):?>
            <th class="span2"><b><?php echo ucfirst($key);?></b></th>
            <?php endforeach;?>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}


    <?php  $routeToView = 'webform/'.$machine_name.'/show/'; ?>

    <tr>
        <td><?php echo $m;?></td>
        <td>{{ item.machine_name }}</td>
        <?php foreach($item->getFields() as $key=>$value):?>
        <td><?php echo$value;?></td>
        <?php endforeach;?>
        <td width="">
            {{ link_to(routeToView ~ item.id, '<i class="icon-comment"></i>', "class": "btn") }}
        </td>
    </tr>

    <?php $m++;?>
    {% if loop.last %}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to(route, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to(route~"?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to(route~"?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to(route~"?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
        </tfoot>
        </table>
    {% endif %}
{% else %}
    No feedback are recorded
{% endfor %}

<script type="text/javascript">
    $(document).ready(function () {
        $('.feedbacks a.delete').click(function () {
            return confirm("Are you sure");
        });
    });
</script>
