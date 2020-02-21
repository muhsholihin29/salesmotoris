<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/table_horz_scroll/vendor/bootstrap/css/bootstrap.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
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
              <button type="button" class="btn transparent btn-grey" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-map" onclick="return initMap('{{$store->coordinate}}');">Lihat Map</button>
            </td>
            <td>
              <?php if ($store->status == 0) { ?>
                <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-confi" onclick="return approveConfirm('{{$store->id}}','{{$store->name}}');">Setujui</button>
                <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-delete-store" onclick="return reject($store->id);">Tolak</button>
                <?php 
              } else { ?>
                <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-edit-store" onclick="return delete($store->id);">Hapus</button>
                <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-delete-store" onclick="return reject($store->id);">Tolak</button>
                <?php 
              } ?>
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
        <div class="row" id="maps">
          <div class="col" id="map"></div>
          <div class="col" id="pano"></div>
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
<!-- Confirm Approve Modal -->   
<div class="modal fade modal-confi"tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form action="{{url('/')}}/store/crud/approve" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Setujui Toko</h4>
        </div>
        <div class="modal-body body-confi" id="md-body-confi">
        </div>
        <input type="hidden" name="id" id="storeId">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <input type="submit" class="btn btn-success" name="" value="Ya">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /Confirm Approve Modal -->   
</div>
</div>

<!-- /page content-->

<script src="{{asset('js/views/store.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"
async defer></script>
<script type="text/javascript">
  
@if (Session::has('approve'))
  console.log("ini approve");
    setTimeout(function() {
        pnotify('Sukses', 'Toko berhasil disetujui','success');
        console.log('aaaa');
    }, 2000);
@endif
</script>