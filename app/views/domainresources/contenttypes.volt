<form method="post" autocomplete="off">
    <h2>Domain Content Types</h2>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
    {{ content() }}
    <div class="row">
        <div class="cnt_types">
            {% for cntType  in contentTypes %}

            <?php if(in_array($cntType['id'],$selCntTypes)){?>
                <label class="selected">
                    {{ check_field(cntType['id'],"checked":"checked") }}
                    {{ cntType['hname']}}
                </label>
            <?php }else{ ?>
                <label>
                    {{ check_field(cntType['id']) }}
                    {{ cntType['hname']}}
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