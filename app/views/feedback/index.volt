{{ content() }}

<form method="post" action="{{ url("feedback/search") }}" autocomplete="off">

    <div class="center scaffold">

        <h2>Feedback</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("form_name") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Search", "class": "btn btn-primary") }}
        </div>

    </div>

</form>