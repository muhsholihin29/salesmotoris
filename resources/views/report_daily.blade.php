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

<!-- Image Modal -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>
<!-- /Image Modal -->

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