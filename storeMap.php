<html>
<head>

    <link rel="stylesheet" type="text/css" href="cssStoreMap.css">

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

    <?php
    if (is_string($_GET["uCity"])) {
        $uCity= $_GET["uCity"];
        $userCity = $uCity . ",OR";
    }
    ?>

</head>

<body>
<header>
    <h1>Equip All Recreational</h1>

    <ul>
        <li><a href="#">Home </a></li>
        <li><a href="#">Fall Gear </a></li>
        <li><a href="#">Winter Gear</a></li>
        <li><a href="#">Spring Gear</a></li>
        <li><a href="#">Summer Gear</a></li>
        <li><a href="#">Login</a></li>
    </ul>

</header>
<h1>Store Location</h1>
<input type="hidden" id="userChoice" value=<?php echo $userCity ?> >
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<script>
    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(44.0583333, -121.3141667);
        var mapOptions = {
            zoom: 8,
            center: latlng
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    }


    function codeAddress() {
        var address = document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
<div id="findStore">
    <input id="address" type="textbox" value=<?php echo $userCity ?> >
    <input type="button" value="Find Store" onclick="codeAddress()"></div>
<div id="map-canvas">

</div>
<footer>
    <ul id="ulFooter">
        <li><a href="#">About Us</a></li>
        <li><a href="#">Customer Support</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Employment</a></li>
        <li><a href="#">FAQs</a></li>
    </ul>
</footer>

</body>

</html>