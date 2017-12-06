<!-- Modal -->
<div id="Modal-Content-Selector" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Select Content</h3>
    </div>
    <div class="modal-body">
        <div id="modal-placeholder">

        </div>
        <table id="content-view-sel" class="table table-bordered table-striped" align="center">
            <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Content</td>
                <td width="">
                    <a href="#" class="btn" onclick="return selectContent('');"><i class="icon-list"></i></a>
                </td>
            </tr>
            <tr>
                <td>View</td>
                <td width="">
                    <a href="#" class="btn" onclick="return selectView();"><i class="icon-list"></i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
</div>

<script>
    var contentTypeName = '';
    var contentRefId = '';
    var callbackFldName = '';
    function showSelectContent(t,contentType){
        $('#content-view-sel').show();
        $('#Modal-Content-Selector').modal('show');
        callbackFldName = $(t).siblings().attr('name');
        if(contentType!=''){
            get_contents(contentType);
        }
//        console.debug(callbackFldName);
    }
    function showSelectContent2(t,contentType){
        $('#content-view-sel').show();
        $('#Modal-Content-Selector').modal('show');
        callbackFldName = $(t).siblings().attr('name');
        if(contentType!=''){
            get_contents2(contentType);
        }
//        console.debug(callbackFldName);
    }

    function selectContent(contentType){

        if(contentType==''){
            get_content_types();
        }else{
            get_contents(content_type);
        }
    }
    function selectView(){
        var url = '/npfadmin/viewcontents/listajax';
        $.post(url,
            function(html,status){
                //console.debug(data);
                $('#content-view-sel').hide();
                $('#modal-placeholder').html(html);
                $( "#modal-view-list > tbody > tr " ).bind( "click", function() {
                    var id = $(this).children('td.view-id').html();
//                    var id = $(this).html();
                    console.debug("/site/view/"+id);
                    $("input[name='"+callbackFldName+"']").val("/site/view/"+id);
                    hideModal();
                });
            });
    }
    function get_content_types(){
        //var val = $('#modal-content-type').val();
        //$('#Modal-Content-Selector').modal('show');
        var url = '/npfadmin/contenttype/listajax';
        $.post(url,
            function(html,status){
                $('#content-view-sel').hide();
                //console.debug(data);
                $('#modal-placeholder').html(html);
                $( ".content-type-link" ).bind( "click", function() {
                    get_contents( $(this).attr('href') );
                    return false;
                });
            });
    }
    function get_contents(content_type){

        var url = '/npfadmin/content/'+content_type+'/listajax';
        $.post(url,
            function(html,status){
                $('#content-view-sel').hide();
                //console.debug(data);
                $('#modal-placeholder').html(html);
                $( "#modal-content-list > tbody > tr " ).bind( "click", function() {
                    var id = $(this).children('td.content-id').html();
//                    var id = $(this).html();
                    console.debug("/site/"+content_type+"/"+id);
                    $("input[name='"+callbackFldName+"']").val("/site/"+content_type+"/"+id);
//                    console.debug(callbackFldName);
                    hideModal();
                });
            });
    }
    function get_contents2(content_type){

        var url = '/npfadmin/content/'+content_type+'/listajax';
        $.post(url,
            function(html,status){
                $('#content-view-sel').hide();
                //console.debug(data);
                $('#modal-placeholder').html(html);
                $( "#modal-content-list > tbody > tr " ).bind( "click", function() {
                    var id = $(this).children('td.content-id').html();
//                    var id = $(this).html();
//                    console.debug("/site/"+content_type+"/"+id);
                    $("input[name='"+callbackFldName+"']").val(id);
//                    console.debug(callbackFldName);
                    hideModal();
                });
            });
    }

    function hideModal(){
        contentTypeName = '';
        contentRefId = '';
        callbackFldName = '';
        $('#modal-placeholder').html('');
        $('#Modal-Content-Selector').modal('hide');
    }
    $(document).ready(function(){
        //get_content_types();


    });



</script>
