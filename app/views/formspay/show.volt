    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("formspay/list", "&larr; Go Back") }}
        </li>
    </ul>
    {{ content() }}

    <?php echo $show_val; ?>

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("formspay/list", "&larr; Go Back") }}
        </li>
    </ul>


<script type="text/javascript">
    $(document).ready(function()
    {
    /*
        $( "#lookuptype_id" ).change(function() {
            var t = $(this).val();
            load_taxonomy_vals(t);
        });
        var t = $("#lookuptype_id").val();
        load_taxonomy_vals(t);
        function load_taxonomy_vals(t){
            $("#parent_id").html('<option value="NULL"></option>');
            $.getJSON( "/npfadmin/domains/getvalsbytype", { tp: t } )
                .done(function( json ) {
                    //console.log( "JSON Data: " + json);
                    console.log( "JSON Data: " + json.length);
                    if(json.length>0){
                        $("#div-parent-id").show();
                        var opts = "";
                        $.each(json,function(){
                            opts += '<option value="'+this.id+'">'+this.name+'</option>';
                        });
                        $("#parent_id").html(opts);
                        $("#parent_id option[value='{{ parentid }}']").attr('selected', 'selected');
                    }else{
                        $("#div-parent-id").hide();
                    }
                })
                .fail(function( jqxhr, textStatus, error ) {
                    var err = textStatus + ", " + error;
                    console.log( "Request Failed: " + err );
                });
        }
    */
    });

</script>