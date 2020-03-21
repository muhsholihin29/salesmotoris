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
  <<div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><small>Filter berdasarkan tanggal dan export excel</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">  
          <form action="pendaftaran" method="POST">
            {{csrf_field()}}
            <input type="hidden" id="jtgl_start" name="tgl_start">
            <input type="hidden" id="jtgl_end" name="tgl_end">
            <div class="item form-group row ">
              <label class="control-label col-md-3 col-sm-3 label-align">Tanggal</label>
              <div class="col-md-3 col-sm-3">                  
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                  <span id="tanggal">December 30, 2018 - January 28, 2019</span> <b class="caret"></b>
                </div>
              </div>
            </div>
            <div class="item form-group row ">
              <label class="control-label col-md-3 col-sm-3 label-align">Status Uji</label>
              <div class="col-md-3 col-sm-4">                  
                <select class="form-control" id="status_uji" name="status_uji">
                  <option value="0">-Semua-</option>
                  <option value="kompeten">Kompeten</option>
                  <option value="tidak">Tidak Kompeten</option>            
                </select>

              </div>
              <input type="submit" class="btn btn-primary" value="Cari">
            </div>
          </form>          
          <div class="item form-group row ">
            <div class="col-md-4 col-sm-4">                  

            </div>
          </div>
          <div class="item form-group row ">
            <div class="col-md-6 col-sm-6">                
              <form action="pendaftaran/export" method="POST">
                {{csrf_field()}} 
                <input type="hidden" name="pendaftar" value="" placeholder="">
                <button type="submit" class="btn btn-success">Export Excel</button>
              </form>
            </div> 
          </div>
          <a id="download" href="javascript:void(0);" download="cropped.png"></a>
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
              <th><center>Nama</center></th>
              <th width="130px"><center>Transaksi</center></th>
            </tr>
          </thead>

          <?php foreach(json_encode($data['report_store']) as $st){ ?>
            <tr>
              <td><center><?php echo $st->store ?></center></td>
              <td><center></center></td>
              <td><center>

              </center></td>
            </tr>
          <?php } ?>
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

<script src="{{asset('resources/js/views/visit.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"
async defer></script>
<script type="text/javascript">

</script>