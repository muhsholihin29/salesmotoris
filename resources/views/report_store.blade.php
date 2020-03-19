<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Laporan Toko</h3>

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
          <h2><small>Filter Stok Sales</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="item form-group row ">
              <label class="control-label col-md-3 col-sm-3 label-align">Tanggal</label>
              <div class="col-md-4 col-sm-3">                  
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                  <span id="tanggal">{{$data['date_picker']}}</span> <b class="caret"></b>
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><small>Filter berdasarkan</small></h2>
          <div class="clearfix"></div>
        </div>

        
        <table class="table table-bordered table-striped" id="mytable">
          <thead>
            <tr><th width="80px"><center>No<center></th>
              <th><center>Toko</center></th>
              <th width="250px"><center>Total Transaksi</center></th>
            </tr>
          </thead>

          @foreach ($data['report_store'] as $key=>$st)
          <tr>
            <td><center>{{$key+1}}</center></td>
            <td><center>{{$st['store']}}</center></td>
            <td><center>
              @if($st['transactions'] <= 0)
              Tidak ada transaksi
              @else
              {{$st['transactions']}}
              @endif
            </center></td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Map Modal -->
<div class="modal fade modal-map" id="modal-edit-visit" tabindex="-1" role="dialog" aria-hidden="true">
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
      <form action="{{url('/')}}/visit/crud/approve" method="post" accept-charset="utf-8">
        @csrf
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Setujui Toko</h4>
        </div>
        <div class="modal-body body-confi" id="md-body-confi">
        </div>
        <input type="hidden" name="id" id="visitId">
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

<script src="{{asset('resources/js/views/report.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"
async defer></script>
<script type="text/javascript">

  function tgl(a, b) {
    // document.body.innerHTML += '<form id="btn-number-action" action="pendaftaran" method="post">{{csrf_field()}}<input type="hidden" id="jtgl_start" name="tgl_start" value=""><input type="hidden" id="jtgl_end" name="tgl_end" value=""></form>';
    
    
    $('#jtgl_start').val(a); 
    $('#jtgl_end').val(b);     
    // document.getElementById("btn-number-action").submit(); 
  }

  function funTglStart(){
    console.log('funTglStart');
    var start = $('#tgl_start').val();
    if (start == 0) {
      return 0;
    }
    var datearrayA = start.split("-");
    // console.log("aaaaaaaa" + datearrayA[1] + '/' + datearrayA[0] + '/' + datearrayA[2]);
    return datearrayA[1] + '/' + datearrayA[0] + '/' + datearrayA[2];
  }

  function funTglEnd(){    
    var end = $('#tgl_start').val();
    if (end == 0) {
      return 0;
    }
    var datearrayB = end.split("-");    
    return datearrayB[1] + '/' + datearrayB[0] + '/' + datearrayB[2];
  }

  @if (Session::has('approve'))
  console.log("ini approve");
  setTimeout(function() {
    pnotify('Sukses', 'Toko berhasil disetujui','success');
    console.log('aaaa');
  }, 2000);
  @endif


</script>