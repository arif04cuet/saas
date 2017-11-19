
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>Link</th>
        <th>Caption (bn)</th>
        <th>Caption (en)</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($fldval)){ ?>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][link]","value":fldval['link'],'readonly':'readonly') }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent(this,'{{ fldrefname }}'); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
            <td>{{ text_field(fldname~"[0][caption_bn]","value":fldval['caption_bn']) }}</td>
            <td>{{ text_field(fldname~"[0][caption_en]","value":fldval['caption_en']) }}</td>
        </tr>
    <?php }else{ ?>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname~"[0][link]",'readonly':'readonly') }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent(this,'{{ fldrefname }}'); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
            <td>{{ text_field(fldname~"[0][caption_bn]") }}</td>
            <td>{{ text_field(fldname~"[0][caption_en]") }}</td>
        </tr>
    <?php } ?>
    </tbody>
</table>