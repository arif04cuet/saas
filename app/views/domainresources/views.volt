<form method="post" autocomplete="off">
    <h2>Domain Views</h2>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}
    <div class="row">
    <div class="cnt_types">
{% for view  in views %}

        <?php if(in_array($view['id'],$selViews)){?>
            <label class="selected">
                {{ check_field(view['id'],"checked":"checked") }}
                {{ view['hname']}}
            </label>
        <?php }else{ ?>
            <label>
            {{ check_field(view['id']) }}
            {{ view['hname']}}
        </label>
        <?php } ?>

{% endfor %}
    </div>
    </div>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>

<style>
    .cnt_types {
        width: 100%;
    }
    .cnt_types label{
        float: left;
        padding: 10px;
        margin: 10px;
        background-color: #eee;
    }
    .cnt_types label.selected{
        background-color: #aaa;
    }
</style>