{{ content() }}
<?php  $route = 'webform/'.$mn.'/list'; ?>
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to(route, "&larr; Go Back") }}
    </li>
</ul>

<table class="table table-bordered">
    <?php foreach($item as $key=>$value):?>
    <tr>
        <td class="span2"><b><?php echo ucfirst($key);?></b></td>
        <td><?php echo$value;?></td>
    </tr>
    <?php endforeach;?>
</table>

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to(route, "&larr; Go Back") }}
    </li>
</ul>


