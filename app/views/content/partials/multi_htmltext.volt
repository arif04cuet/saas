
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>HtmlText (bn)</th>
        <th>HtmlText (en)</th>
    </tr>
    </thead>
    <tbody>

    <?php $i = 0 ?>
    <?php if(isset($fldval)){ ?>

        {% for fldv  in fldval %}
        <tr>

            <td>{{ text_area(fldname~"["~i~"][text_bn]","value":fldv['text_bn'],"class":"ck-editor") }}</td>
            <td>{{ text_area(fldname~"["~i~"][text_en]","value":fldv['text_en'],"class":"ck-editor") }}</td>
            <td>
                <a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>
            </td>
        </tr>
        <?php $i++ ?>
        {% endfor %}
    <?php }else{ ?>
        <tr>
            <td>{{ text_area(fldname~"[0][text_bn]","class":"ck-editor") }}</td>
            <td>{{ text_area(fldname~"[0][text_en]","class":"ck-editor") }}</td>
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
            '<td><textarea class="ck-editor" name="{{fldname}}['+i_{{fldname}}+'][text_bn]"></textarea></td>' +
            '<td><textarea class="ck-editor" name="{{fldname}}['+i_{{fldname}}+'][text_en]"></textarea></td>' +
            '<td>' +
            '<a class="btn btn-mini btn-danger" href="javascript:;" onclick="deleteRow(this); return false;">X</a>' +
            '</td>' +

        '</tr>';
        $("#tbl-{{fldname}} > tbody").append(t);
        i_{{fldname}}++;
        $( '.ck-editor' ).ckeditor( {
            filebrowserBrowseUrl : '/uploader?ckeditor=1&uppth={{ uploadPath }}'
        } );
    }
    function deleteRow(t){
        $(t).parent().parent().remove();
    }
</script>