<?php
//------------Use when running on local test server.
include "local_db_connect.php";
//$locations = "Select city,pop2013,county,store FROM City_info WHERE city LIKE :userCity '%'";

//------------Use when running on ONID server
//include "ONIDdbConnect.php";
//$locations = "Select city,pop2013,county,store FROM City_Info WHERE city LIKE :userCity '%'";
//------------------------------------------
if (is_string($_GET["q"])) {
    $uCity = $_GET["q"];
} else {
    $uCity = "Bend";
}
;

//Number of Oregon cities
$numORcities = 243;
?>

    <script>
        var geocoder;
        var map;
        //Initializes map at Bend Oregon cordinates
        function initialize() {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 8,
                center: latlng
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        }
        //Geocodes address
        function codeAddress() {
            var address = document.getElementById('address').value;
            geocoder.geocode({ "Bend,Oregon"}, function (results, status) {
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

<?php
//Query database with city info.
function getStoreLocations($userCity, $dbh)
{
    $locations = "Select city,pop2013,county,store FROM City_info WHERE city LIKE :userCity '%'";
    $locations_preped = $dbh->prepare($locations);
    $locations_preped->bindParam(':userCity', $userCity, PDO::PARAM_STR, 50);
    $locations_preped->execute();
    $locations_result = $locations_preped->fetchAll();
    return $locations_result;
}

$user_locations = getStoreLocations($uCity, $dbh);

$cityCount = sizeof($user_locations);

if ($cityCount == 0 || $cityCount == $numORcities) {
    echo "Try a different search";
} else {
//Populate table with matching cities and associated info.
    echo "<table>";
    echo "<tr><th>City</th><th>County</th><th>Population</th><th>Store?</th></tr>";
    for ($i = 0; $i < $cityCount; $i++) {
        ?>
        <tr><td><a href="storeMap.php?uCity=<?php echo $user_locations[$i]['city'] ?>" target="_blank">
        <?php echo $user_locations[$i]['city'] . "</a></td><td>" . $user_locations[$i]['county'] . "</td>"
            . "<td>" . $user_locations[$i]['pop2013'] . "</td><td>" . $user_locations[$i]['store'] . "</td></tr>";

    }
    ?>
<?php
}

echo "</table>";
?>-
<?php

?>