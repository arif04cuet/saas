<table id="tbl-{{ fldname }}">
    <tbody>

    <tr>
        <td>
            <select id="{{ fldname }}" name="{{ fldname }}" <?php echo $required?"required":""?> ></select>
            <span style="display: none" id="{{ fldname }}_value">{{ fldval }}</span>
        </td>
    </tr>

    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {

        loadData("{{ fldrefname }}", "{{ fldname }}", "{{ title }}");

        function loadData(table, fildname, titleField) {

            $.getJSON("/npfadmin/domains/loaddata", {table: table,})
                    .done(function (json) {

                        if (json.length > 0) {
                            var opts = '<option value="">Select</option>';
                            $.each(json, function () {
                                opts += '<option value="' + this.id + '">' + this.name + '</option>';
                            });
                            $("#{{ fldname }}").html(opts);
                            $("#{{ fldname }} option[value='{{ fldval }}']").attr('selected', 'selected');
                        }

                    })
                    .fail(function (jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;

                    });
        }
    });
</script>