<form method="post" autocomplete="off">
    <h2>Migrate Domain</h2>
    {{ content() }}
    <div class="center scaffold">

        <div class="clearfix">
            <label for="name">Source Domain</label>
            {{ text_field("src_domain") }}
        </div>
        <div class="clearfix">
            <label for="name">Source DB</label>
            {{ text_field("src_db") }}
        </div>
    </div>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Run", "class": "btn btn-success") }}
        </li>
    </ul>
</form>