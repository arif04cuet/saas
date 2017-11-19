<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

<div class="container">
    <div class="row">

        <div class="col-lg-12">
            <form class="form-inline" id="searchForm" action="http://www.saas.dev/solr.php">
                <div class="form-group">
                    <input type="text" class="form-control col-lg-8" id="q" name="q" placeholder="Search..">
                </div>
                <div class="form-group">
                    <select class="form-control" id="category" name="category">
                        <option value="all">All</option>
                        <option value="news">News</option>
                        <option value="notices">Notices</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="lng" name="lang">
                        <option value="bn">bn</option>
                        <option value="en">en</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="submit">Search</button>
            </form>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div id="results">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var form = $('#searchForm');

        $("#submit").click(function () {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {

                    var response = data.response;
                    //console.log(response.numFound);
                    var $list = '<b>Total : ' + response.numFound + '</b><ul>';
                    $.each(response.docs, function (idx, item) {
                        $list += '<li>' + item.title_bn + '</li>';
                    })
                    $list = $list + '</ul>';
                    $('#results').empty().html($list);
                }

            });
            return false;
        });
    });
</script>