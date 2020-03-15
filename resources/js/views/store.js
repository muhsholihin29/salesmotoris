function initMap(coordinate) {       
    // console.log(coordinate);
    var coor = coordinate.split(', ');
    var latitude = parseFloat(coor[0]);
    var longitude = parseFloat(coor[1]);
    // console.log(longitude);

    var myLatLng = {lat: latitude, lng: longitude};

    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 18
    });
    var marker = new google.maps.Marker({
        position: myLatLng, 
        map: map, 
        draggable: false,
        icon: "http://maps.google.com/mapfiles/kml/paddle/O.png"
    });

    // if (map) {
    //     map.setCenter(myLatLng);
    //     map.setPosition(event.latLng);
    // }
    var panorama = new google.maps.StreetViewPanorama(
      document.getElementById('pano'), {
        position: myLatLng,
        pov: {
          heading: 34,
          pitch: 10
      }
  });
    map.setStreetView(panorama);
}

function approveConfirm(id, name) {
    console.log(name);
    document.getElementById('md-body-confi').innerHTML = 'Apakah anda yakin menyetujui ' + name + '?';
    $('#storeId').val(id);
}

function pnotify(title, text, type) {
    new PNotify({
      title: title,
      text: text,
      type: type,
      styling: 'bootstrap3'
  });
}

function delConfirm(id, name) {
  var url = document.URL;
  var idSales = url.substring(url.lastIndexOf('/') + 1);
  document.getElementById('md-body-confi-del').innerHTML = 'Apakah anda yakin menghapus ' + name + '?';
  $('#delStoreId').val(id);
}