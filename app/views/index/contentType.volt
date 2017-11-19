<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("users", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2>Create a Conten Type</h2>

    <div class="clearfix">
        <label for="name">Machine Name</label>
        {{ text_field('name') }}
    </div>

    <div class="clearfix">
        <label for="name">Human Name</label>
        {{ text_field('human_name') }}
    </div>

    <div class="clearfix">
        <label for="name">Fields</label>
        <table  id="tblFields">
            <thead>
            <tr>
                <th>Name</th>
                <th>Human Name</th>
                <th>Type</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ text_field('fld[0][name]') }}</td>
                <td>{{ text_field('fld[0][hname]') }}</td>
                <td>{{ select('fld[0][type]', ['date':'date', 'datetime':'datetime', 'email':'email', 'emvideo':'emvideo', 'filefield':'filefield', 'nodereference':'nodereference', 'number_integer':'number_integer', 'text':'text']) }}</td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <a href="javascript:;" onclick="addFieldRow()">Add</a>
    </div>

    <div class="clearfix">
        <label for="name">Volt Template</label>
        {{ text_area('name') }}
    </div>

    <div class="clearfix">
        <label for="name">Queries</label>
        <table id="tblSqlQueries">
            <tbody>
            <tr><td>{{ text_area('sql[0]') }}</td><td></td></tr>
            </tbody>
        </table>
        <a href="javascript:;" onclick="addSqlQueries()">Add</a>
    </div>

</div>
</form>
<script>
    var numOfFlds = 0;
    var numOfSqls = 0;
    function addFieldRow(){
        numOfFlds++;
        $('#tblFields > tbody').append('<tr><td><input type="text" value="" name="fld['+numOfFlds+'][name]"></td>' +
            '<td><input type="text" value="" name="fld['+numOfFlds+'][hname]"></td><td><select name="fld['+numOfFlds+'][type]">' +
            '<option value="date" selected="selected">date</option>' +
            '<option value="datetime">datetime</option>' +
            '<option value="email">email</option>' +
            '<option value="emvideo">emvideo</option>' +
            '<option value="filefield">filefield</option>' +
            '<option value="nodereference">nodereference</option>' +
            '<option value="number_integer">number_integer</option>' +
            '<option value="text">text</option>' +
            '</select></td><td><a href="#" onclick="removeThis(this)">remove</a></td></tr>');
        return null;
    }
    function removeThis(t){
        $(t).parent().parent().remove();
    }
    function addSqlQueries(){
        numOfSqls++;
        $('#tblSqlQueries > tbody').append('<tr><td><textarea name="sql['+numOfSqls+']"></textarea></td><td><a href="#" onclick="removeThis(this)">remove</a></td></tr>');
        return null;
    }

</script>
