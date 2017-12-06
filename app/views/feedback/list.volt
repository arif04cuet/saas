{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("feedback/", "&larr; Go Back") }}
    </li>
</ul>
<?php $m=1;?>
{% for feedback in page.items %}
    {% if loop.first %}
        <table class="table table-bordered table-striped feedbacks" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th class="span2">Name</th>
            <th>Email</th>
            <th class="span5">Message</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}
    <?php
    $type = $feedback->form_name;
    $form_fields = unserialize($feedback->form_fields);
    ?>

    <tr>
        <td><?php echo ($_GET['page'])?(($_GET['page']-1)*20)+$m:$m;?></td>
        <td><?php echo $feedback->created;?></td>
        <td><?php echo $form_fields['name']?></td>
        <td><?php echo $form_fields['email']?></td>
        <td><?php echo substr($form_fields['message'],0,100)?></td>
        <td width="">
            {{ link_to("feedback/show/" ~ feedback.id, '<i class="icon-comment"></i>', "class": "btn") }}
            {{ link_to("feedback/delete/" ~ feedback.id, '<i class="icon-remove"></i>', "class": "btn delete") }}
        </td>
    </tr>

    <?php $m++;?>
    {% if loop.last %}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("feedback/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("feedback/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("feedback/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("feedback/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
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
