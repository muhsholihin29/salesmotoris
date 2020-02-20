<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/table_horz_scroll/vendor/bootstrap/css/bootstrap.min.css') }}"> -->
</head>
<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Data Asesor</h3>

    </div>

    <div class="title_right">

      <div class="col-md-9 col-sm-9 form-group pull-right top_search">
        <span>Edit hapus data Asesor</span>  
      </div>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><small>Filter berdasarkan tanggal dan export excel</small></h2>
          <div class="clearfix"></div>
        </div>
        
        <table class="table table-bordered table-striped" id="mytable">
          <thead>
            <tr><th width="80px"><center>No<center></th>
              <th><center>Nama Toko</center></th>
              <th><center>Alamat</center></th>         
              <th width="200px"><center>Lokasi Map</center></th>
              <th width="200px"><center>Aksi</center></th>
            </tr>
          </thead>

          @foreach ($data['store'] as $key=>$store)
          <tr>
            <td><center>{{$key+1}}</center></td>
            <td><center>{{$store->name}}</center></td>
            <td><center>{{$store->address}}</center></td>
            <td>
              <button type="button" class="btn transparent btn-grey" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-map" onclick="return approve('');">Lihat Map</button>
            </td>
            <td><button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-edit-store" onclick="return approve('');">Setujui</button>
              <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-delete-store" onclick="return delete('');">Hapus</button>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Map Modal -->
<div class="modal fade modal-map" id="modal-edit-store" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Map </h4><span> </span>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div style="padding:10px">
          <div id="map"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" name="" value="Simpan" onclick="return validateFormUpdate();">
          <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        </div>
      </div>        
    </div>
  </div>
</div>
<!-- /Map Modal -->   
</div>
</div>

<!-- /page content-->
<!-- <script src="{{asset('js/views/store.js')}}"></script> -->
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA&callback=initMap"
async defer></script>