{{ content() }}
{{ javascript_include('js/jquery.tablednd.js') }}

<div align="right">
    <a href="javascript:;" onclick="saveBlocks(); return false;" class="btn btn-success"><i class="icon-inbox"></i> Save Blocks</a>
    {{ link_to("pageblocks/create", "<i class='icon-plus-sign'></i> Create Block", "class": "btn btn-primary") }}
</div>
<div class="tableDemo clearfix">
    <table id="tbl_blocks" class="table" cellspacing="0" cellpadding="2">
        {% set i=0 %}
        {% for region  in regions %}
            {% if i == 0 %}
        <thead>
            <tr id="region-{{ region.id }}" class="nodrag" style="text-align: left;"><th colspan="3">{{ region.description }}</th></tr>
        </thead>
        <tbody>
        {% set i=1 %}
            {% else %}
                <tr id="region-{{ region.id }}" class="nodrag" style="text-align: left;"><th colspan="3">{{ region.description }}</th></tr>
            {% endif %}

            {% for bblock  in bblocks %}
                {% if bblock.region_id == region.id %}
                    <tr id="{{ bblock.id }}"><td class="draggable"><div></div></td><td>{{ bblock.title_bn }}</td><td><a class="menu-edit btn btn-mini btn-warning" href="{{ url }}pageblocks/edit/{{ bblock.id }}"><i class="icon-edit"></i></a></td></tr>
                {% endif %}
            {% endfor %}
        {% endfor %}
        <tr id="region-0" class="nodrag" style="text-align: left;"><th colspan="3">No Region</th></tr>
        {% for bblock  in bblocks %}
            {% if bblock.region_id == 0 %}
                <tr id="{{ bblock.id }}"><td class="draggable"><div></div></td><td>{{ bblock.title_bn }}</td><td><a class="menu-edit btn btn-mini btn-warning" href="{{ url }}pageblocks/edit/{{ bblock.id }}"><i class="icon-edit"></i></a></td></tr>
            {% endif %}
        {% endfor %}
        </tbody>
    </table>
</div>
<style>
    tr{
        background-color: #fff;
    }
    tr.nodrag{
        background-color: #eee;
    }
    td.draggable{
        width: 23px;
    }
    td.draggable > div{
        background: url("img/draggable.png") no-repeat scroll 6px 9px rgba(0, 0, 0, 0);
        height: 13px;
        margin: -0.4em 0.5em;
        padding: 0.42em 0.5em;
        width: 13px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl_blocks').tableDnD(); // no options currently
    });
    function saveBlocks(){
        var tbl_block = $("#tbl_blocks tr");
        var t = new Array();
        var w = 0;
        var rgn = 0;
        $.each(tbl_block,function(index){
            var id = $(this).attr('id');
            var rg = ifRegion(id);
            if(rg>=0){
                rgn = rg;
            }else{
                var tmp = [parseInt(id),parseInt(rgn),w];
                t.push(tmp);
                w++;
            }
        });
        function ifRegion(id){
            if(id.substring(0,6)=='region'){
                return id.substring(7);
            }
            return -1;
        }
        console.debug(t);
        $.post("{{ url }}pageblocks/saveAjax",
            {"blcks":t},
            function(data,status){
                console.debug(data);
                // reload the
                if(data.result=="success"){
                    location.reload(true);
                }
            });
    }
</script>



