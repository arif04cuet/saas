<!-- Modal -->
<div id="Modal-Domain-Selector" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Select Domain</h3>
    </div>
    <div class="modal-body">
        <div id="selection_div">
            <div>
                <select onchange="Domain_Selector.get_subdomains_by_cat(this)" id="master_select">
                    <option value="">বাছাই করুন</option>
                    <option value="2">মন্ত্রণালয়</option>
                    <option value="3">অধিদপ্তর</option>
                    <option value="4">বিভাগ</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
</div>

<script>
    $(document).ready(function(){
    });
    function OpenModalDomainSel(fldName){
        Domain_Selector.fldName = fldName;
        
        $('#Modal-Domain-Selector').modal('show');
    }
</script>
