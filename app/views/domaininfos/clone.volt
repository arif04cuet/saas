<form method="post" autocomplete="off">
    <h2>Clone Domain</h2>
    {{ content() }}
    <div class="center scaffold">

        <div class="clearfix">
            <label for="name">Source Domain</label>
            {{ text_field("src_domain") }}
        </div>
        <div class="clearfix">
            <label for="name">Clean Destination Domain before Clone</label>
            {{ check_field("clean_domain",'value':'1','checked':'checked') }}
        </div>
        <div class="clearfix">
            <label for="name">Destination Domain</label>
            {{ text_field("dest_domain") }}
        </div>
    </div>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>