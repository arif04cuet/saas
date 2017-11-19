
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>Link</th>
        <th>Caption (bn)</th>
        <th>Caption (en)</th>
    </tr>
    </thead>
    <tbody>

<?php $i = 0 ?>
<?php if(isset($fldval)){ ?>

    {% for fldv  in fldval %}
    <tr>
        <td>
            <div class="input-append">
                {{ text_field(fldname~"["~i~"][link]","value":fldv['link']) }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalContentSelector.openContentSel(this); return false;"><i class="icon-search"></i></a>
            </div>
        </td>
        <td>{{ text_field(fldname~"["~i~"][caption_bn]","value":fldv['caption_bn']) }}</td>
        <td>{{ text_field(fldname~"["~i~"][caption_en]","value":fldv['caption_en']) }}</td>
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
                {{ text_field(fldname~"[0][link]") }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalContentSelector.openContentSel(this); return false;"><i class="icon-search"></i></a>
            </div>
        </td>
        <td>{{ text_field(fldname~"[0][caption_bn]") }}</td>
        <td>{{ text_field(fldname~"[0][caption_en]") }}</td>
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
                    '<td><div class="input-append">' +
                    '<input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][link]">' +
                    '<a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalContentSelector.openContentSel(this); return false;"><i class="icon-search"></i></a>' +
                    '</div></td>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][caption_bn]"></td>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][caption_en]"></td>' +
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