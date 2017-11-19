{% if fldtype == "bool" %}
    {{ set_default(fldname,fldval) }}
    {{ select_static(fldname, ['0':'No','1':'Yes'],'class':'input-small') }}
{% elseif fldtype == "color" %}
<input type="text"  id="{{ fldname }}" name="{{ fldname }}" value="{{ fldval }}" class="span2">
<script type="text/javascript">
    $(document).ready(function(){
        $('#{{ fldname }}').colorpicker()
    });
</script>
{% elseif fldtype == "date" %}
<div class="input-append">
    <input type="text" id="{{ fldname }}" name="{{ fldname }}" value="{{ fldval }}" <?php echo $required?"required":""?>>
    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="clearFldVal('#{{ fldname }}'); return false;"><i class="icon-remove"></i></a>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#{{ fldname }}').datepicker({
            format: "yyyy-mm-dd",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            defaultDate: new Date()
        });
        $( "#{{ fldname }}" ).keypress(function( event ) {
            event.preventDefault();
        });
    });
    //document.getElementById("{{ fldname }}").readOnly = true;
</script>
{% elseif fldtype == "lookuptbl" %}
    {% if flddependson == "" %}
        {{ set_default(fldname,fldval) }}
        {{ select(fldname, lookupData, 'using': ['id', 'name_bn'],'useEmpty' : true) }}
    {% else %}
        {% if fldval == "" %}
        <select id="{{ fldname }}" name="{{ fldname }}">
            <option value=""></option>
        </select>
        {% else %}
        {{ set_default(fldname,fldval) }}
        {{ select(fldname, lookupData, 'using': ['id', 'name_bn'],'useEmpty' : true) }}
        {% endif %}
        <script type="text/javascript">
            $(document).ready(function(){
                $( "#{{ flddependson }}" ).change(function() {
                    var t = $(this).val();
                    load_taxonomy_{{ fldname }}(t);
                });
                //var t = $('#{{ flddependson }}').val();
                //load_taxonomy_{{ fldname }}(t);
                function load_taxonomy_{{ fldname }}(t){
                    $("#{{ fldname }}").html('<option value=""></option>');
                    $.getJSON( "/npfadmin/domains/getvalsbyparent", { pid: t } )
                        .done(function( json ) {
                            console.log( "JSON Data: " + json.length);
                            if(json.length>0){
                                var opts = '<option value=""></option>';
                                $.each(json,function(){
                                    opts += '<option value="'+this.id+'">'+this.name+'</option>';
                                });
                                $("#{{ fldname }}").html(opts);
//                                $("#{{ fldname }}").val('{{ fldval }}');
                                $("#{{ fldname }} option[value='{{ fldval }}']").attr('selected', 'selected');
                            }
                        })
                        .fail(function( jqxhr, textStatus, error ) {
                            var err = textStatus + ", " + error;
                            console.log( "Request Failed: " + err );
                        });
                }
            });
        </script>
    {% endif %}
{% elseif fldtype == "multiselect" %}
    {{ select(fldname, lookupData, 'using': ['id', 'name_bn'],'multiple':'', 'name':fldname~'[]', 'class':'populate','style':'width:300px') }}
    {% if flddependson == "" %}
    <script type="text/javascript">
        $(document).ready(function(){
            $("#{{ fldname }}").select2();
            $("#{{ fldname }}").select2("val", [{{fldval}}]);
        });
    </script>
    {% else %}

    {% endif %}
{% elseif fldtype == "email" %}
<input type="email" id="{{ fldname }}" name="{{ fldname }}" value="{{ fldval }}" <?php echo $required?"required":""?>>

{% elseif fldtype == "number" %}
<input id="{{ fldname }}" type="number" value="{{ fldval }}" name="{{ fldname }}" <?php echo $required?"required":""?>>
<script>
    $(document).ready(function(){
        $("input[name='{{ fldname }}']").TouchSpin({
            min: -1000000,
            max: 10000000,
            step: 1,
            decimals: 0
        });
    });
</script>
{% elseif fldtype == "decimal" %}
<input id="{{ fldname }}" type="number" value="{{ fldval }}" name="{{ fldname }}" <?php echo $required?"required":""?>>
<script>
    $(document).ready(function(){
        $("input[name='{{ fldname }}']").TouchSpin({
            min: -1000000,
            max: 10000000,
            step: 0.01,
            decimals: 2
        });
    });
</script>
{% else %}
<input type="text" id="{{ fldname }}" name="{{ fldname }}" value="{{ fldval }}" <?php echo $required?"required":""?>>
{% endif %}