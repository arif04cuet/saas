<table id="tbl-{{ fldname }}">
    <thead>
    <tr>
        <th>Latitude</th>
        <th>Longitude</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($fldval)){ ?>
        <tr>
            <td>{{ text_field(fldname~"[0][lat]","value":fldval[0]['lat']) }}</td>
            <td>{{ text_field(fldname~"[0][lng]","value":fldval[0]['lng']) }}</td>
        </tr>
    <?php }else{ ?>
        <tr>
            <td>{{ text_field(fldname~"[0][lat]") }}</td>
            <td>{{ text_field(fldname~"[0][lng]") }}</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div id="map-canvas"></div>
<style>
    #map-canvas {
        border:1px solid #000000;
        width: 100%;
        height: 350px;
    }
    #map-canvas img {
        max-width: none;
    }
</style>
<script>
    var map;
    var marker;
    function initialize() {
        var mapOptions = {
            zoom: 12,
            center: new google.maps.LatLng(23.709921000000000000, 90.407143000000020000)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);
        });
        var lat = $("input[name='{{fldname~"[0][lat]"}}']").val();
        var lng = $("input[name='{{fldname~"[0][lng]"}}']").val();
        if(lat && lng){
            drawMarker(lat,lng);
        }
    }
    function drawMarker(lat,lng){
        var location = new google.maps.LatLng(lat,lng);
        placeMarker(location);
    }
    function placeMarker(location) {
        if (marker == undefined) {
            marker = new google.maps.Marker({
                position: location,
                map: map,
                animation: google.maps.Animation.DROP,
                draggable: true
            });
            google.maps.event.addListener(marker, 'dragend', function () {
                var pos = marker.getPosition();
                $("input[name='{{fldname~"[0][lat]"}}']").val(pos.lat());
                $("input[name='{{fldname~"[0][lng]"}}']").val(pos.lng());
            }.bind(this));
            $("input[name='{{fldname~"[0][lat]"}}']").val(location.lat());
            $("input[name='{{fldname~"[0][lng]"}}']").val(location.lng());
        }
        else {
            marker.setPosition(location);
        }
        map.setCenter(location);

    }
    function loadScript() {
        if (typeof google === 'object' && typeof google.maps === 'object'){
            console.debug('ok');
            initialize();
        }else{
            console.debug('not ok');
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
                'callback=initialize';
            document.body.appendChild(script);
        }
    }
    $(document).ready(function () {
        loadScript();
    });
//    window.onload = loadScript;
</script>