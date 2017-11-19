<form method="post" autocomplete="off">
    <h2>Clean Domain</h2>
    {{ content() }}
    <div class="center scaffold">

        <div class="clearfix">
            <label for="name">Domain</label>
            {{ text_field("domain") }}
        </div>

    </div>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>