<form method="post" autocomplete="off">
    <h2>Content Types Mapping</h2>
    {{ content() }}

    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Content Types</th>
                {% for domainType in domainTypes %}
                <th>{{ domainType.name }}</th>
                {% endfor %}
            </tr>
            </thead>
            <tbody>
                {% for contentType in contentTypes %}
                    <tr>
                        <td>{{ contentType.human_name }}</td>
                        {% for domainType in domainTypes %}
                        <td>
                            <?php if(in_array($contentType->id,$contentMap[$domainType->id])){?>
                                {{ check_field(domainType.id~"["~contentType.id~"]","checked":"checked") }}
                            <?php }else{ ?>
                                {{ check_field(domainType.id~"["~contentType.id~"]") }}
                            <?php } ?>
                        </td>
                        {% endfor %}
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
    <ul class="pager">
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
</form>

<style>

</style>