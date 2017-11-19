
<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>Link</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($fldval)){ ?>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname,"value":fldval,'readonly':'readonly') }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent2(this,'{{ fldrefname }}'); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
        </tr>
    <?php }else{ ?>
        <tr>
            <td>
                <div class="input-append">
                    {{ text_field(fldname,'readonly':'readonly') }}
                    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="showSelectContent2(this,'{{ fldrefname }}'); return false;"><i class="icon-search"></i></a>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>