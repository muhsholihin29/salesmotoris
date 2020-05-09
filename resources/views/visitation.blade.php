<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
</head>
<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Kunjungan</h3>

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
          <h2><small>Filter Stok Sales</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="form-group row">
          <label class="control-label col-md-2 col-sm-2 label-align">Sales</label>
          <div class="input-group col-md-3 col-sm-12">   
            <div style="width: 170px">
              <select class="form-control" style="width: 100%" id="filSales" name="id_store" required>
                <option value="">-Pilih Sales-</option>
                @foreach($data['sales'] as $i)
                <option value="{{$i->id}}">{{$i->name}}</option>
                @endforeach 
              </select>
            </div>        
            <div class="input-group-btn">
              <button type="button" class="btn btn-primary" onclick="return filSearch();">Cari</button>
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
          <h2><small></small></h2>
          <div class="clearfix"></div>
        </div>
        @if(!empty($data['visit']))
        <button class="btn btn-secondary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-visit" onclick="return add();"><span class="glyphicon glyphicon-plus"></span> Tambah Kunjungan Baru</button>
        @endif
        
        <table class="table table-bordered table-striped" id="mytable">
          <thead>
            <tr><th width="80px"><center>No<center></th>
              <th><center>Toko</center></th>
              <th width="100px"><center>Senin</center></th>
              <th width="100px"><center>Selasa</center></th>
              <th width="100px"><center>Rabu</center></th>
              <th width="100px"><center>Kamis</center></th>
              <th width="100px"><center>Jumat</center></th>
              <th width="200px"><center>Aksi</center></th>
            </tr>
          </thead>

          @foreach ($data['visit'] as $key=>$visit)
          <tr>
            <td><center>{{$key+1}}</center></td>
            <td><center>{{$visit->store}}</center></td>
            <td><center>
              @if($visit->days == 'Senin')
              ✔
              @endif
            </center></td>
            <td><center>
              @if($visit->days == 'Selasa')
              ✔
              @endif
            </center></td>
            <td><center>
              @if($visit->days == 'Rabu')
              ✔
              @endif
            </center></td>
            <td><center>
              @if($visit->days == 'Kamis')
              ✔
              @endif
            </center></td>
            <td><center>
              @if($visit->days == 'Jumat')
              ✔
              @endif
            </center></td>
            <td>
              <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-visit" onclick="return edit('{{$visit->id}}');">Ubah</button>
              <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-confi" onclick="return delConfirm('{{$visit->id}}','{{$visit->store}}');">Hapus</button>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Visit Modal -->
<div class="modal fade modal-visit" id="modal-visit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="update-label">Kunjungan </h4><span> </span>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"> 
        <form action="{{url('/')}}/visitation" class="form-horizontal form-label-left" method="POST">
          {{csrf_field()}}            
          <input type="hidden" id="visitId" name="id"> 
          <input type="hidden" name="id_sales" id="salesId">
          <div class="form-group row">                
            <label class="control-label col-md-3 col-sm-1 label-align">Toko</label>
            <div class="col-md-9 col-sm-6">               
              @if(!empty($data['store']))
              <select class="form-control" style="width: 100%" id="sel_store" name="id_store" required>
                <option value="">-Pilih Toko-</option>
                @foreach($data['store'] as $i)
                <option value="{{$i->id}}">{{$i->name}}</option>
                @endforeach 
              </select>
              @endif
              <span id="error_kode_unit_edit"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-2 label-align" style="margin-right: 30px">Hari</label>
            <div class="row">
              <div class="col-md-3 col-sm-2 custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="Senin" id="chSenin" name="days" required>
                <label class="custom-control-label" for="chSenin">Senin</label>
              </div>
              <div class="col-md-3 col-sm-2 custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="Selasa" id="chSelasa" name="days" required>
                <label class="custom-control-label" for="chSelasa">Selasa</label>
              </div>
              <div class="col-md-3 col-sm-2 custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="Rabu" id="chRabu" name="days" required>
                <label class="custom-control-label" for="chRabu">Rabu</label>
              </div>
            </div>
            <div class="row">              
              <div class="col-md-3 col-sm-2 custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="Kamis" id="chKamis" name="days" required>
                <label class="custom-control-label" for="chKamis">Kamis</label>
              </div>
              <div class="col-md-3 col-sm-2 custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="Jumat" id="chJumat" name="days" required>
                <label class="custom-control-label" for="chJumat">Jumat</label>
              </div>
            </div>
          </div>        
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" name="" value="Simpan">
            <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
          </div>
        </form>
      </div> 
      <div class="spinner-border" role="status" id="load">
        <span class="sr-only">Loading...</span>
      </div>    
    </div>
  </div>
</div>
<!-- /Visit Modal --> 
<!-- Confirm Del Modal -->   
  <div class="modal fade modal-confi"tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form action="{{url('/')}}/visitation/del" method="post" accept-charset="utf-8">
          @csrf
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Hapus Kunjungan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body body-confi" id="md-body-confi">
          </div>
          <input type="hidden" name="id" id="delVisitId">
          <input type="hidden" name="id_sales" id="delSalesId">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-success" name="" value="Ya">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Confirm Del Modal -->   
</div>
</div>

<!-- /page content-->

<script src="{{asset('resources/js/views/visitation.js')}}"></script>
<script type="text/javascript">
  function base_url() {
    var APP_URL = {!! json_encode(url('/')) !!};
    return APP_URL;
  }
  function edit(id) {
    document.getElementById("load").style.visibility = "visible";
    var url = document.URL;
    var idSales = url.substring(url.lastIndexOf('/') + 1);
    $('#salesId').val(idSales);
    $('#visitId').val(id);
    document.getElementById('chSenin').checked = false;
    document.getElementById('chSelasa').checked = false;
    document.getElementById('chRabu').checked = false;
    document.getElementById('chKamis').checked = false;
    document.getElementById('chJumat').checked = false;
    var vt = (<?php echo json_encode($data['visit']) ?>);
    vt.forEach(function(i){
      if (i['id'] == id) {
        if (i['days'] == 'Senin') {
          document.getElementById('chSenin').checked = true;
        }
        if (i['days'] == 'Selasa') {
          document.getElementById('chSelasa').checked = true;
        }
        if (i['days'] == 'Rabu') {
          document.getElementById('chRabu').checked = true;
        }
        if (i['days'] == 'Kamis') {
          document.getElementById('chKamis').checked = true;
        }
        if (i['days'] == 'Jumat') {
          document.getElementById('chJumat').checked = true;
        }
      }
    });
    jQuery.ajax({
      url: '{{ url('/')}}'.concat('/visitation/',id,'/edit'),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (result) {
        if (result != '[]') {
          document.getElementById('update-label').innerHTML = 'Ubah Kunjungan ' + result.store;
          var sel = document.getElementById('sel_store');
          if (sel.options.length-1 > {{count($data['store'])}}) {
            sel.removeChild( sel.options[sel.options.length-1] ); 
          }
          var opt = document.createElement('option');
          opt.appendChild( document.createTextNode(result.store) );
          opt.value = result.id_store; 
          sel.appendChild(opt);
          document.getElementById('sel_store').value = result.id_store;
          document.getElementById("load").style.visibility = "hidden";
        }

      },
      error: function (data, textStatus, errorThrown) {
        console.log(data);
        pnotify('Error', textStatus,'error');
      }
    });
  }
  @if (Session::has('add'))  
  setTimeout(function() {
    pnotify('Sukses', 'Stok berhasil ditambahkan','success');
    console.log('aaaa');
  }, 2000);
  @endif
  @if (Session::has('update'))  
  setTimeout(function() {
    pnotify('Sukses', 'Stok berhasil diperbarui','success');
    console.log('aaaa');
  }, 2000);
  @endif
  @if (Session::has('del'))  
  setTimeout(function() {
    pnotify('Sukses', 'Stok berhasil dihapus','success');
    console.log('aaaa');
  }, 2000);
  @endif
  @if (Session::has('error'))  
  setTimeout(function() {
    pnotify('Gagal', 'Terjadi kesalahan sistem','error');
    console.log('aaaa');
  }, 2000);
  @endif
</script>