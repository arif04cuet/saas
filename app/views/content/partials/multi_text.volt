
<table id="tbl-{{ fldname }}" style="width:100%">
    <thead>
    <tr>
        <th>Text (bn)</th>
        <th>Text (en)</th>
    </tr>
    </thead>
    <tbody>

<?php $i = 0 ?>

<?php if(isset($fldval)){ ?>

    {% for fldv  in fldval %}
    <tr>

        <td>{{ text_field(fldname~"["~i~"][text_bn]","value":fldv['text_bn'],"style":"width:95%") }}</td>
        <td>{{ text_field(fldname~"["~i~"][text_en]","value":fldv['text_en'],"style":"width:95%") }}</td>
        <td>
            <a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>
        </td>
    </tr>
    <?php $i++ ?>
    {% endfor %}
<?php }else{ ?>
    <tr>
        <td>{{ text_field(fldname~"[0][text_bn]") }}</td>
        <td>{{ text_field(fldname~"[0][text_en]") }}</td>
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
        var t =     '<tr>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][text_bn]"></td>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][text_en]"></td>' +
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