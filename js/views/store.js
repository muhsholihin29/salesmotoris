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

    var markerCurrent;
    var mapCurrent;
    // Try HTML5 geolocation.
    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            }; 
            infoWindow.setPosition(pos);
            map.setCenter(pos);
            markerCurrent = new google.maps.Marker({
                position: pos, 
                map: map, 
            });

        }, function() {

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
}