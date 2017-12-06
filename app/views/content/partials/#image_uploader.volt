<link href="/npfadmin/css/bootstrap-modal.css" rel="stylesheet" />
<script src="/npfadmin/js/bootstrap-modalmanager.js"></script>
<script src="/npfadmin/js/bootstrap-modal.js"></script>

<a href="#" class="btn" id="openBtn">Content File Manager</a>

<div id="uploader" class="modal container hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>File Uploader</h3>
    </div>
    <div class="modal-body">
        <div style="height: 400px; overflow: hidden;">
            <iframe id="iframe-uploader" src="" style="zoom:0.60" width="99.6%" height="100%" frameborder="0"></iframe>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>

<script>
    $(document).ready(function()
    {
        var frameSrc = "/uploader?uppth={{uppth}}";
        $('#openBtn').click(function(){
            $('#uploader').on('show', function () {

                $('iframe#iframe-uploader').attr("src",frameSrc);

            });
            $('#uploader').modal({show:true})
        });
    });
</script>