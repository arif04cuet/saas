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
    <?php if(isset($fldval)){ ?>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][name]","id":fldname~"_0_name","class":"input-medium","readonly":"readonly","value":fldval['name']) }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalSingleFileUpload.showModal(this); return false;"><i class="icon-folder-open"></i></a>
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="clearFldVal('#{{ fldname }}_0_name'); return false;"><i class="icon-remove"></i></a>
                </div>
            </td>
            <td>{{ text_field(fldname~"[0][caption_bn]","value":fldval['caption_bn']) }}</td>
            <td>{{ text_field(fldname~"[0][caption_en]","value":fldval['caption_en']) }}</td>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][link]","value":fldval['link']) }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent(this,''); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
        </tr>
    <?php }else{ ?>
        <tr>
        </tr>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][name]","id":fldname~"_0_name", "class":"input-medium","readonly":"readonly") }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="ModalSingleFileUpload.showModal(this); return false;"><i class="icon-folder-open"></i></a>
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="clearFldVal('#{{ fldname }}_0_name'); return false;"><i class="icon-remove"></i></a>
                </div>
            </td>
            <td>{{ text_field(fldname~"[0][caption_bn]") }}</td>
            <td>{{ text_field(fldname~"[0][caption_en]") }}</td>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][link]") }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent(this,''); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>