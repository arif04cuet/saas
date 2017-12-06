<table id="tbl-{{ fldname }}">
    <tbody>

    <tr>
        <td>

            <select id="{{ fldname }}" name="{{ fldname }}" <?php echo $required?"required":""?> >

            </select>
            <span style="display: none" id="{{ fldname }}_value">{{ fldval }}</span>
        </td>
    </tr>

    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {

        //$('#{{ dependson }}').ajaxComplete(function (e, xhr, settings, exception) {

        var $id = "{{ fldval }}";

        if ($id) {

            parentVal = $("#{{ dependson }}_value").text();
            parentField = "{{ dependson }}";
            table = 'npf_content_' + "{{ fldname }}";
            loadDependentData(table, parentField, parentVal);
        }

        $("#{{ dependson }}").change(function () {
            parentVal = $(this).val();
            parentField = "{{ dependson }}";
            table = 'npf_content_' + "{{ fldname }}";
            loadDependentData(table, parentField, parentVal);
        });


        // });


        function loadDependentData(table, parentField, parentVal) {

            $.getJSON("/npfadmin/domains/loaddependentdata", {
                table: table,
                parentField: parentField,
                parentVal: parentVal
            })
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
                        console.log("Request Failed: " + err);
                    });
        }


    });
</script>