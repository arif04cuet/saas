{{ content() }}

<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contenttype/list", "<< Back", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("content/"~ contentType ~"/create", "Add Content", "class": "btn btn-primary") }}
    </li>
</ul>

<table id="data" class="officerList table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th class="search">Name</th>
        <th class="search">Parent</th>
        <th class="">Updated</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>

    </tbody>
</table>


<script type="application/javascript">
    $(document).ready(function () {

        $('#data thead th.search').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" class="searchTitle" placeholder=" Search ' + title + '" />');
        });

        var $contentType = "{{ contentType }}";
        var $domainId = "{{ domainId }}";
        // for taxonomy, taxonomy.jointableColumnName.ContentTableColumnName
        // for content Table , ReferentTableName.ReferenceShowingTableName.localColumnName
        var $columns = 'id,publish,version,lastmodified,title_en,mopa_department.title_en.parent_dept';

        var t = $('#data').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 20,
            "order": [[2, "desc"]],
            "dom": '<"top">rt<"bottom"ip><"clear">',
            "ajax": {
                url: '/api/datatable/join.php',
                type: 'POST',
                "data": {
                    "content_type": $contentType,
                    "fields": $columns,
                    "domain_id": $domainId
                }
            },
            "columns": [

                {
                    "data": "title_en",
                    "width": "30%",
                    "orderable": false,
                },
                {
                    "data": "parent_dept",
                    "width": "25%",
                    "orderable": false,
                },

                {

                    "data": "lastmodified",
                    "width": "5%",
                    "render": function (data, type, full, meta) {
                        return data.split(' ')[0];
                    }
                },
                {

                    "data": "publish",
                    "width": "5%",
                    "searchable": false,
                    "render": function (data, type, full, meta) {
                        if (data == 1)
                            return '<span class="label label-success">published</span>'
                        else
                            return '<span class="label label-important">unpublished</span>'
                    }
                },
                {

                    "data": "publish",
                    "width": "25%",
                    "searchable": false,
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        $file = '';
                        if (data !== false && typeof data[0] !== 'undefined') {
                            $id = full.id;
                            $html = '<div style="text-align: right"><a href="/npfadmin/public/content/' + $contentType + '/edit/' + $id + '/' + full.version + '" class="btn btn-primary btn-small" rel="tooltip" data-placement="bottom" data-original-title="Edit"><i class="icon-pencil"></i></a>' +
                                    '<a href="/npfadmin/public/content/' + $contentType + '/delete/' + $id + '" class="btn btn-danger btn-small" rel="tooltip" data-placement="bottom" data-original-title="Delete" onclick="return confirm_delete();"><i class="icon-remove"></i></a> ' +
                                    '<a href="/npfadmin/public/content/' + $contentType + '/versions/' + $id + '" class="btn btn-info  btn-small" rel="tooltip" data-placement="bottom" data-original-title="History"><i class="icon-calendar"></i></a>   ' +
                                    '<a class="btn btn-success  btn-small" onclick="OpenInNewTab(this);return false;" href="/site/' + $contentType + '/' + $id + '" data-original-title="View" data-placement="bottom" rel="tooltip"><i class="icon-share"></i> </a></div>'

                            return $html;
                        }
                        return '';

                    }
                },
            ],
        });

        // Apply the search
        t.columns().every(function () {
            var that = this;

            $('input', this.header()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

    })
    ;
</script>


<style>
    .dataTables_length {
        float: right !important;
    }

    .dataTables_filter {
        float: left !important;
        text-align: left;
        width: 80%;
    }

    .dataTables_filter label {
        text-align: left;
    }

    .dataTables_filter input {
        width: 80%
    }

    th.search {
        text-align: left;
        padding: 0 !important;
        width: 100px;
    }

    th.search input {
        width: 180px;
    }

</style>

<script type="application/javascript">
    function OpenInNewTab(a) {
        var url = $(a).attr('href');
        var win = window.open(url, '_blank');
        win.focus();
        return false;
    }
    $('#example').tooltip();
    function confirm_delete() {
        var r = confirm("Are you sure to delete the record?");
        if (r == true) {
            return true;
        }
        else {
            return false;
        }
    }
</script>