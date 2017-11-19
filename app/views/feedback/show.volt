<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("feedback/list", "&larr; Go Back") }}
    </li>
</ul>

<table class="table table-bordered">
    <tr>
        <td class="span2"><b>Name</b></td>
        <td>{{ feedback['name'] }}</td>
    </tr>
    <tr>
        <td class="span2"><b>Email</b></td>
        <td>{{ feedback['email'] }}</td>
    </tr>
    <tr>
        <td class="span2"><b>Message</b></td>
        <td>{{ feedback['message'] }}</td>
    </tr>

</table>

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("feedback/list", "&larr; Go Back") }}
    </li>
</ul>


