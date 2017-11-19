
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>

    <?php $i = 0 ?>
    <?php if(isset($fldval)){ ?>

        {% for fldv  in fldval %}
        <tr>
            <td>
                <div class="input-append">
                    <input type="hidden" value="{{ fldv['id'] }}" name="{{ fldname~'['~i~'][id]' }}" id="{{ fldname~'_'~i }}">
                    <input readonly="readonly" class="input-xxlarge" type="text" value="{{ fldv['name'] }}" name="{{ fldname~'['~i~'][name]' }}" id="{{ fldname~'_'~i }}_txt" />
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="OpenModalDomainSel('{{ fldname~'_'~i }}'); return false;"><i class="icon-search"></i></a>
                </div>

            </td>
            <td>
                <a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>
            </td>
        </tr>
        <?php $i++ ?>
        {% endfor %}
    <?php }else{ ?>
        <tr>
            <td>
                <div class="input-append">
                    <input type="hidden" value="" name="{{ fldname~'[0][id]' }}" id="{{ fldname }}_0">
                    <input class="input-xxlarge" type="text" value="" name="{{ fldname~'[0][name]' }}" id="{{ fldname }}_0_txt" readonly="readonly"/>
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="OpenModalDomainSel('{{ fldname~"_0" }}'); return false;"><i class="icon-search"></i></a>
                </div>

            </td>
            <td>
                <a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="javascript:;" class="btn" onclick="addRow{{fldname}}(); return false;">Add</a>
<script>
    var i_{{fldname}} = <?php echo $i+1 ?>;
    function addRow{{fldname}}(){
        var t =     '<tr><td>' +

            '<div class="input-append">' +
            '<input type="hidden" id="{{fldname}}_'+i_{{fldname}}+'" name="{{fldname}}['+i_{{fldname}}+'][id]" value="">' +
            '<input type="text" readonly="readonly" id="{{fldname}}_'+i_{{fldname}}+'_txt" name="{{fldname}}['+i_{{fldname}}+'][name]" value="" class="input-xxlarge">' +
            '<a onclick="OpenModalDomainSel(\'{{fldname}}_'+i_{{fldname}}+'\'); return false;" class="btn" role="button" href="javascript:;" id="btn-contentref" data-original-title=""><i class="icon-search"></i></a>' +
            '</div>' +

            '<td>' +
            '<a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>' +
            '</td>' +

        '</tr>';
        $("#tbl-{{fldname}} > tbody").append(t);
        i_{{fldname}}++;
    }
    function deleteRow(t){
        $(t).parent().parent().remove();
    }
</script>


<script>
    $(document).ready(function(){
//        $( "#{{ fldname }}" ).keypress(function( event ) {
//            event.preventDefault();
//        });
    });
</script>
