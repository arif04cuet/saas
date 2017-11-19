<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("lookups/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>
{{ content() }}

<div class="center scaffold">

    <h2>Create Taxonomy</h2>

    <div class="clearfix">
        <label for="name">Name</label>
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
        <label for="name">Lookup Type</label>
        {{ form.render("lookuptype_id") }}
    </div>
    <div id="div-parent-id" class="clearfix hide">
        <label for="name">Parent</label>
        <select id="parent_id" name="parent_id"><option value=""></option></select>
    </div>

    <div class="clearfix">
        <label for="name">Weight</label>
        {{ form.render("weight") }}
    </div>


</div>
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("lookups/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

</form>

<script type="text/javascript">
    $(document).ready(function()
    {
        $( "#lookuptype_id" ).change(function() {
            var t = $(this).val();
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
                    }else{
                        $("#div-parent-id").hide();
                    }
                })
                .fail(function( jqxhr, textStatus, error ) {
                    var err = textStatus + ", " + error;
                    console.log( "Request Failed: " + err );
                });
        });
    });

</script>