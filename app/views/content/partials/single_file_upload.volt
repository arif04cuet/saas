{{ stylesheet_link('css/jquery.fileupload.css') }}

{{ javascript_include('js/vendor/jquery.ui.widget.js') }}
{{ javascript_include('js/jquery.iframe-transport.js') }}
{{ javascript_include('js/jquery.fileupload.js') }}



<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<!--<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>-->
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<!--<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>-->
<!-- The File Upload processing plugin -->
<!--<script src="/npfadmin/js/jquery.fileupload-process.js"></script>-->
<!-- The File Upload image preview & resize plugin -->
<!--<script src="/npfadmin/js/jquery.fileupload-image.js"></script>-->


<!-- Modal -->
<div id="Modal-Single-File-Upload" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Select a File</h3>
    </div>
    <div class="modal-body">
        <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>

    </span>
        <br>
        <!-- The global progress bar -->
        <div id="progress" class="progress">
            <div class="bar bar-success"></div>
        </div>
        <div id="files" class="files"></div>
        <!-- The container for the uploaded files -->

    </div>
    <div class="modal-footer">
<!--        <button class="btn" onclick="ModalSingleFileUpload.onClickOk()" aria-hidden="true">Ok</button>-->
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    </div>
</div>

<script>
    var ModalSingleFileUpload={
        inputBox: '',
        onClickOk: function(){
            //console.debug(ModalSingleFileUpload.inputBox);
            $("input[name='"+ModalSingleFileUpload.inputBox+"']").val($('#files').html());
            $('#Modal-Single-File-Upload').modal('hide');
        },
        showModal: function(t){
            var s = $(t).siblings();
            ModalSingleFileUpload.inputBox = $(s).attr('name');
            $('#Modal-Single-File-Upload').modal('show');
            $('#progress .bar').css('width','0%');
            $('#files').html($(s).val());
        }
    };
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === 'blueimp.github.io' ?
            '//jquery-file-upload.appspot.com/' : '/uploader/server/?uppth={{ uppth }}';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            //imageMaxWidth: 960,
//            imageMaxHeight: 250,
//            imageCrop: true,
//            imageForceResize: true,
//            disableImageResize: false,
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').html(file.name);
                });
                $("input[name='"+ModalSingleFileUpload.inputBox+"']").val($('#files').html());
                $('#Modal-Single-File-Upload').modal('hide');
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

</script>
