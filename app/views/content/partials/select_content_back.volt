<!-- Modal -->
<div id="Modal-Content-Selector" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Select Content</h3>
    </div>
    <div class="modal-body">
        <div class="clearfix3">
            <div class="input-append">
                <input type="text" class="typeahead" value="" id="modal-content-type" name="modal-content-type" placeholder="Content Type">
                <a href="javascript:;" class="btn"  onclick="return ModalContentSelector.searchContentByType();"><i class="icon-search"></i></a>
            </div>
            <!--
            <div class="input-append">
                <input type="text" value="" id="modal-content-title" name="modal-content-title" placeholder="Content Title">
                <a href="javascript:;" class="btn"><i class="icon-search"></i></a>
            </div> -->
        </div>
        <div class="clearfix3">
        </div>
        <table id="modal-content-list" class="table table-bordered table-striped" align="center">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Active</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" align="right">
                        <div class="btn-group">
                            <a id="btn-tbl-f" onclick="ModalContentSelector.goto('f');" href="javascript:;" class="btn"><i class="icon-fast-backward"></i> First</a>
                            <a id="btn-tbl-p" onclick="ModalContentSelector.goto('p');" href="javascript:;" class="btn "><i class="icon-step-backward"></i> Previous</a>
                            <a id="btn-tbl-n" onclick="ModalContentSelector.goto('n');" href="javascript:;" class="btn"><i class="icon-step-forward"></i> Next</a>
                            <a id="btn-tbl-l" onclick="ModalContentSelector.goto('l');" href="javascript:;" class="btn"><i class="icon-fast-forward"></i> Last</a>
                            <span  id="spn-hlp-inline" class="help-inline">1/140</span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
</div>

<script>
    var ModalContentSelector={
        populateText: "",
        contentType: '',
        page: null,
        init: function(input_id){
            ModalContentSelector.populateText = input_id;
            contentType = '';
            page = null;
            $( "#modal-content-list > tbody").html('<tr><td colspan="3">No record selected.</td></tr>');
            $('#modal-content-type').val('');
            ModalContentSelector.bindClickEventOnTableRow();
        },
        onRowClick: function(tr){
            var contentTypeName = $('#modal-content-type').val();
//            var contentTypeName = $("ul.typeahead.dropdown-menu").find('li.active').data('value');;
            if(contentTypeName == ''){
                alert('Please type a content type...')
                return false;
            }
            var id = $(tr).children('td.content-id').html();
            $("input[name='"+ModalContentSelector.populateText+"']").val("/site/"+contentTypeName+"/"+id);
            $('#Modal-Content-Selector').modal('hide');
        },
        bindClickEventOnTableRow: function(){
            $( "#modal-content-list > tbody > tr" ).unbind('click');
            $( "#modal-content-list > tbody > tr" ).bind( "click", function() {
                ModalContentSelector.onRowClick(this);
            });
        },
        openContentSel: function(t){
            var id = $(t).siblings().attr('name');
            ModalContentSelector.init(id);
            $('#Modal-Content-Selector').modal('show');
        },
        showOnTable:function(result){
            $( "#modal-content-list > tbody").html('');
            ModalContentSelector.page = result.page;
            var data = result.data;
            $.each(data,function(i){
                //console.debug(this);
                var r = '<tr>' +
                    '<td class="content-id">'+this.id+'</td>' +
                    '<td>'+this.title_bn+'</td>' +
                    '<td>'+this.active+'</td>' +
                    '</tr>';
                $( "#modal-content-list > tbody").append(r);
            });
            ModalContentSelector.bindClickEventOnTableRow();
        },
        goto:function(page){
            if(page=='f'){
                ModalContentSelector.searchContentByType(ModalContentSelector.page.first)
            }else if(page=='p'){
                ModalContentSelector.searchContentByType(ModalContentSelector.page.before)
            }else if(page=='n'){
                ModalContentSelector.searchContentByType(ModalContentSelector.page.next)
            }else if(page=='l'){
                ModalContentSelector.searchContentByType(ModalContentSelector.page.last)
            }
        },
        searchContentByType:function(page){
            var val = $('#modal-content-type').val();
            var url = '/npfadmin/content/'+val+'?page='+page;
            $.post(url,
                function(data,status){
                    //console.debug(data);
                    ModalContentSelector.showOnTable(data.result);
                });
        }
    };
    $(document).ready(function(){
        $('.typeahead').typeahead({
            source: function (query, process) {
                return $.get('/npfadmin/contenttype/typeahead', { query: query }, function (data) {
                    return process(data.options);
                });
            },
            onselect: function(obj) { console.debug(obj) }
        });
    });



</script>
