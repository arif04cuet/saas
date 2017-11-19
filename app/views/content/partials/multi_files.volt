
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>File Name</th>
        <th>Caption (bn)</th>
        <th>Caption (en)</th>
        <th>Link</th>
    </tr>
    </thead>
    <tbody>

<?php $i = 0 ?>
<?php if(isset($fldval)){ ?>

    {% for fldv  in fldval %}
    <tr>
        <td>
            <div class="input-append">
                {{ text_field(fldname~"["~i~"][name]","class":"input-medium","readonly":"readonly","value":fldv['name']) }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalSingleFileUpload.showModal(this); return false;"><i class="icon-folder-open"></i></a>
            </div>
        </td>
        <td>{{ text_field(fldname~"["~i~"][caption_bn]","value":fldv['caption_bn']) }}</td>
        <td>{{ text_field(fldname~"["~i~"][caption_en]","value":fldv['caption_en']) }}</td>
        <td>
            <div class="input-append">
                {{ text_field(fldname~"["~i~"][link]","value":fldv['link']) }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="return showSelectContent(this,''); return false;"><i class="icon-search"></i></a>
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
                {{ text_field(fldname~"[0][name]","class":"input-medium","readonly":"readonly") }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalSingleFileUpload.showModal(this); return false;"><i class="icon-folder-open"></i></a>
            </div>
        </td>
        <td>{{ text_field(fldname~"[0][caption_bn]") }}</td>
        <td>{{ text_field(fldname~"[0][caption_en]") }}</td>
        <td>
            <div class="input-append">
                {{ text_field(fldname~"[0][link]") }}
                <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="return showSelectContent(this,''); return false;"><i class="icon-search"></i></a>
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
        var t =     '<tr>' +
                    '<td>' +
                    '<div class="input-append">' +
                    '<input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][name]" readonly="readonly" class="input-medium">' +
                    '<a onclick="ModalSingleFileUpload.showModal(this); return false;" class="btn" role="button" href="javascript:;" id="btn-contentref">' +
                    '<i class="icon-folder-open"></i></a>' +
                    '</div>' +
                    '</td>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][caption_bn]"></td>' +
                    '<td><input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][caption_en]"></td>' +
                    '<td><div class="input-append">' +
                    '<input type="text" value="" name="{{fldname}}['+i_{{fldname}}+'][link]">' +
                    '<a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="return showSelectContent(this,\'\'); return false;"><i class="icon-search"></i></a>' +
                    '</div></td>' +
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