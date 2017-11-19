<div class="input-append">
    {{ hidden_field(fldname,"value":did) }}
    <input class="input-xxlarge" type="text" value="{{ dname }}" id="{{ fldname }}_txt" <?php echo $required?"required":""?>/>
    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="clearDomainSelection{{ fldname }}('#{{ fldname }}'); return false;"><i class="icon-remove"></i></a>
    <a id="btn-contentref" href="javascript:;" role="button" class="btn" onclick="OpenModalDomainSel('{{ fldname }}'); return false;"><i class="icon-search"></i></a>
</div>

<script>
    $(document).ready(function(){
        $( "#{{ fldname }}" ).keypress(function( event ) {
            event.preventDefault();
        });
    });
    function clearDomainSelection{{ fldname }}(t){
        clearFldVal(t);
        clearFldVal(t+'_txt');
    }
</script>
