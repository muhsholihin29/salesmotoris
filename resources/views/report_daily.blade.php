<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('resources/css/report.css') }}">  
</head>
<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Laporan Harian</h3>
    </div>

    <div class="title_right">
      <div class="col-md-9 col-sm-9 form-group pull-right top_search">

      </div>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><small>Filter berdasarkan tanggal</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <button type="button" class="btn btn-success" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-store-visit" onclick="return mappingStore({{json_encode($data['visited_store'])}});">Harian Toko</button>
          <div class="item form-group row ">
            <label class="control-label col-md-3 col-sm-3 label-align">Tanggal</label>
            <div class="col-md-4 col-sm-3">                  
              <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="fa fa-calendar"></i>
                <span id="tanggal">{{$data['date_picker']}}</span> <b class="caret"></b>
              </div>
            </div>
          </div>
          <?php if ($data['error'] == 'empty') { ?>
            <button type="button" class="btn btn-success" data-backdrop="static" data-keyboard="false" data-toggle="tooltip" data-placement="top" title="Data Kosong">Export Excel</button>
          <?php } ?>
          <?php if ($data['error'] == 'date_invalid') { ?>
            <button type="button" class="btn btn-success" data-backdrop="static" data-keyboard="false" data-toggle="tooltip" data-placement="top" title="Jangka waktu harus 1 hari" >Export Excel</button>
          <?php } ?>
          <?php if ($data['error'] == '') { ?>
            <button type="button" class="btn btn-success" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-excel">Export Excel</button>
          <?php } ?>
        </div>

      </div>
    </div>
  </div>
  <?php 
  if(count($data['report']) == null){
    echo("Tidak ada data");
  }
  ?>

  @foreach ($data['report'] as $daily)
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="x_title">
                <table style="width: 100%; border-collapse: collapse; border-style: hidden;">
                  <tbody>
                    <tr style="height: 21px;">
                      <td style="width: 17.2505%; height: 39px;" rowspan="2">
                        <a href="#" class="pop">
                          <img src="{{url('/public/transaction_image/').'/'.$daily->image}}" class="img-thumbnail rounded" style="width:204px;height:auto;">
                        </a>
                      </td>
                    </tr>
                    <tr></tr>
                    <tr style="height: 21px;">
                      <td style="width: 17.2505%; height: 21px; padding-left: 30px;"><b>{{$daily->name}}</b></td>
                    </tr>
                    <tr style="height: 21px;">
                      <td style="width: 17.2505%; height: 21px;"><i class="fas fa-store"></i>{{ $daily->store}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6">
              <p></p>
              <hr class="solid">
              @foreach ($daily->product as $product)
              <table style="height: 40px; width: 100%; border-collapse: collapse; border-style: hidden; margin-left: 50px">
                <tbody>
                  <tr style="height: 10px;">
                    <td style="width: 55.414%; height: 15px;" colspan="2">{{$product->product}}</td>
                  </tr>
                  <tr style="height: 10px;">
                    <td style="width: 1%; height: 15px;">x</td>
                    <td style="width: 48.9889%; height: 15px;">{{$product->quantity}}</td>
                    <td style="width: 30.441%; height: 15px;">Rp{{$product->sub_total}}</td>
                  </tr>
                </tbody>
              </table>
              <p></p>
              <hr class="solid">
              @endforeach
            </div>
            <div class="col-md-3">
              <center>{{$daily->date}}</center>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
  @endforeach 
</div>

<!-- Excel Modal -->
<div class="modal fade modal-excel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="update-label">Export Excel </h4><span> </span>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> 
        <table class="table table-bordered table-striped" id="tableExcel" border="1px">
          <thead>
            <tr>
              <th><center>Nama Sales</center></th>
              <th><center>Toko</center></th>         
              <th width="200px"><center>Barang</center></th>
              <th width="200px"><center>Omset</center></th>
            </tr>
          </thead>

          @foreach ($data['expExcel'] as $key=>$expExcel)
            @foreach ($expExcel->transactions as $keyTrx=>$trx)
          <tr>
            <?php if ($keyTrx == 0) { ?>
              <td rowspan="{{count($data['expExcel'])+1}}" valign="top"><center>{{$expExcel->name}}</center></td>
            <?php } ?>            
            <td valign="top"><center>{{$trx->store}}</center></td>
            <td valign="top"><center>
              @foreach ($trx->products as $keyProd=>$prod)
                {{$prod->product->name}}: {{$prod->quantity}} {{$prod->product->unit}}; <br>
              @endforeach
            </center></td>
            <td valign="top"><center>{{$trx->income}}</center></td>
          </tr>
            @endforeach
          @endforeach
        </table>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="button" class="btn btn-success" id="btnExpExcel" name="" value="Unduh Excel">
          <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        </div>
      </div>        
    </div>
  </div>
</div>
<!-- /excel Modal -->  
<!-- Store Visitation Modal -->
<div class="modal fade modal-store-visit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="update-label">Mapping Kunjungan Toko </h4><span> </span>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> 
      <div id="map_canvas" style="width: 100%; height:500px;"></div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="button" class="btn btn-success" id="btnExpExcel" name="" value="Unduh Excel">
          <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        </div>
      </div>        
    </div>
  </div>
</div>
<!-- /Store Visitation Modal -->  
</div>
</div>

<!-- /page content-->

<script src="{{asset('resources/js/views/report.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"></script>
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