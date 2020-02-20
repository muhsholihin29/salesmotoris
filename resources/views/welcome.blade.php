<html>
<head>
    <title>Google Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>          
      #map { 
        height: 300px;    
        width: 600px;            
    }          
</style>        
</head>    
<body>
    <div id="latclicked"></div>
    <div id="longclicked"></div>

    <div id="latmoved"></div>
    <div id="longmoved"></div>

    <div style="padding:10px">
        <div id="map"></div>
    </div>

    <?php 

function distance($lon1,$lat1,  $lon2, $lat2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    
      return ($miles * 1609.344);
  }
}

echo distance(112.563917, -6.991889, 112.565368, -6.992441, "K") . " M<br>";

?>

    <script type="text/javascript">
        var map;
        
        function initMap() {                            
            var latitude = 27.7172453; // YOUR LATITUDE VALUE
            var longitude = 85.3239605; // YOUR LONGITUDE VALUE
            
            var myLatLng = {lat: latitude, lng: longitude};

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 6
            });
            infoWindow = new google.maps.InfoWindow;

            
          //   map = new google.maps.Map(document.getElementById('map'), {
          //     center: myLatLng,
          //     zoom: 14,
          //     disableDoubleClickZoom: true, // disable the default map zoom on double click
          // });


          var markerCurrent;
          var mapCurrent;
            // Try HTML5 geolocation.
            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    // mapCurrent = new google.maps.Map(document.getElementById('map'), {
                    //     center: pos,
                    //     zoom: 16
                    // });
                    // markerCurrent = new google.maps.Marker({
                    //     position: pos,

                    //     map: mapCurrent,
                    //     title: latitude + ', ' + longitude 
                    // });  
                    infoWindow.setPosition(pos);
                    // infoWindow.setContent('Location found.');
                    // infoWindow.open(map);
                    map.setCenter(pos);
                    markerCurrent = new google.maps.Marker({
                                position: pos, 
                                map: map, 
                                // title: event.latLng.lat()+', '+event.latLng.lng()
                            });

                }, function() {
                    // handleLocationError(true, infoWindow, map.getCenter());
                    
                });
            } else {
                // Browser doesn't support Geolocation
                // handleLocationError(false, infoWindow, map.getCenter());
                
            }
            var marker;
                    // Create new marker on double click event on the map
                    google.maps.event.addListener(map,'click',function(event) {
                        if (marker) {
                            marker.setPosition(event.latLng);
                            marker.setDraggable(true);
                        }else{
                            marker = new google.maps.Marker({
                                position: event.latLng, 
                                map: map, 
                                draggable: true,
                                // title: event.latLng.lat()+', '+event.latLng.lng(),
                                icon: "http://maps.google.com/mapfiles/kml/paddle/O.png"
                            });
                        }
                        // Update lat/long value of div when the marker is clicked
                        marker.addListener('click', function() {
                            document.getElementById('latclicked').innerHTML = event.latLng.lat();
                            document.getElementById('longclicked').innerHTML =  event.latLng.lng();
                        });   
                        // Update lat/long value of div when anywhere in the map is clicked    
                        google.maps.event.addListener(map,'click',function(event) {                
                            document.getElementById('latclicked').innerHTML = event.latLng.lat();
                            document.getElementById('longclicked').innerHTML =  event.latLng.lng();
                        });

                        // Update lat/long value of div when you move the mouse over the map
                        google.maps.event.addListener(map,'mousemove',function(event) {
                            document.getElementById('latmoved').innerHTML = event.latLng.lat();
                            document.getElementById('longmoved').innerHTML = event.latLng.lng();
                        });

                    });
            // Update lat/long value of div when the marker is clicked
            // markerCurrent.addListener('click', function(event) {              
            //     document.getElementById('latclicked').innerHTML = event.latLng.lat();
            //     document.getElementById('longclicked').innerHTML =  event.latLng.lng();
            // });

            
            
            // Create new marker on single click event on the map
            /*google.maps.event.addListener(map,'click',function(event) {
                var marker = new google.maps.Marker({
                  position: event.latLng, 
                  map: map, 
                  title: event.latLng.lat()+', '+event.latLng.lng()
                });                
            });*/
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA&callback=initMap"
    async defer></script>
</body>    
</html>