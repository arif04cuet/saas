

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("offices", "&larr; Go Back") }}
        </li>
    </ul>
    {{ content() }}
    <div class="center scaffold">
        <h2>Edit Office</h2>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#A" data-toggle="tab">Office Info</a></li>
            <li><a href="#B" data-toggle="tab">Office Users</a></li>
        </ul>

        <div class="tabbable">
            <div class="tab-content">
                <div class="tab-pane active" id="A">

                    <div class="center scaffold">
                        <form method="post" autocomplete="off">
                        {{ form.render("id") }}

                        <div class="clearfix">
                            <label for="name">Domain</label>
                            {{ form.render("domain_id") }}
                        </div>
                        <div class="clearfix">
                            <label for="name">Office Name</label>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#name_bn" data-toggle="tab">Bn</a></li>
                                <li><a href="#name_en" data-toggle="tab">En</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="name_bn">
                                    {{ form.render("name_bn") }}
                                </div>
                                <div class="tab-pane" id="name_en">
                                    {{ form.render("name_en") }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="name">Office Address</label>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#address_bn" data-toggle="tab">Bn</a></li>
                                <li><a href="#address_en" data-toggle="tab">En</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="address_bn">
                                    {{ form.render("address_bn") }}
                                </div>
                                <div class="tab-pane" id="address_en">
                                    {{ form.render("address_en") }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="name">Phone</label>
                            {{ form.render("phone") }}
                        </div>

                        <div class="clearfix">
                            <label for="name">Email</label>
                            {{ form.render("email") }}
                        </div>
                        <div class="clearfix">
                            {{ submit_button("Save", "class": "btn btn-success") }}
                        </div>

                        </form>
                    </div>
                </div>

                <div class="tab-pane" id="B">
                   {{ form('offices/assignuser', 'method': 'post') }}
                    {{ form.render("id") }}
                        <div class="clearfix">
                            <label for="name">User</label>
                            {{ form.render("user_id") }}
                        </div>
                        <div class="clearfix">
                            {{ submit_button("Assign", "class": "btn btn-success") }}
                        </div>
                    </form>
                    <p>
                    <table class="table table-bordered table-striped" align="center">
                        <thead>
                        <tr>
                            <th>User</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for user in office.npfusers %}
                        <tr>
                            <td>{{ link_to("users/edit/"~user.user.id, user.user.email) }}</td>
                        </tr>
                        {% else %}
                        <tr><td colspan="3" align="center">No user assinged.</td></tr>
                        {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

            </div>
        </div>


    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("offices", "&larr; Go Back") }}
        </li>
    </ul>



<script type="text/javascript">
    $(document).ready(function()
    {
        $( '.ck-editor' ).ckeditor( {
        } );

    });
</script>