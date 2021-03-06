<form method="post" autocomplete="off">
    <h2>Taxonomy Mapping</h2>
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
                <th>Taxonomy</th>
                {% for domainType in domainTypes %}
                <th>{{ domainType.name }}</th>
                {% endfor %}
            </tr>
            </thead>
            <tbody>
                {% for lookupType in lookupTypes %}
                    <tr>
                        <td>{{ lookupType.name }}</td>
                        {% for domainType in domainTypes %}
                        <td>
                            <?php if(in_array($lookupType->id,$taxonomyMap[$domainType->id])){?>
                                {{ check_field(domainType.id~"["~lookupType.id~"]","checked":"checked") }}
                            <?php }else{ ?>
                                {{ check_field(domainType.id~"["~lookupType.id~"]") }}
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