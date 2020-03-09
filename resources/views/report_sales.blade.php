<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/table_horz_scroll/vendor/bootstrap/css/bootstrap.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
</head>
<!-- page content -->
<body>
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Target</h3>
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
            <h2><small></small></h2>
            <div class="clearfix"></div>
          </div>

          <table class="table table-bordered table-striped" id="myTable">
            <thead>
              <tr><th width="80px"><center>No<center></th>
                <th>
                  <div class="row">
                    <div class="col">
                      <center>Sales</center>
                    </div>
                    <div class="col">
                      <div class="input-group-sm">
                        <div class="input-group-sm-prepend">
                          <!-- <span class="input-group-text" id="inputGroupPrepend">✎</span> -->
                        </div>
                        <input type="text" class="form-control form-control-sm" id="myInput" onkeyup="myFunction()" placeholder="Search">
                      </div>

                    </div>
                  </div>
                </th>
                <th width="130px"><center>Target Omset</center></th>         
                <th width="130px"><center>Omset</center></th>
                <th width="130px"><center>Transaksi</center></th>
                <th width="200px"><center>Aksi</center></th>
              </tr>
            </thead>

            @foreach ($data['target_transaction'] as $key=>$target)

            <tr>
              <td><center>{{$key+1}}</center></td>
              <td><center>{{$target->name}}</center></td>
              <td><center>Rp{{number_format($target->target_omset,2,',','.')}}</center></td>
              <td><center>Rp{{number_format($target->income,2,',','.')}}</center></td>
              <td><center>{{$target->eff_call}}</center></td>
              <td>
                <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-target" onclick="return edit({{$target->id}});">Ubah</button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- target Modal -->
  <div class="modal fade modal-target" id="modal-target" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="update-label">Ubah Target </h4><span> </span>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"> 
          <form action="{{url('/')}}/target" class="form-horizontal form-label-left" method="POST">
            {{csrf_field()}}            
            <input type="hidden" id="targetId" name="id"> 
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-2 label-align">Target Omset</label>
              <div class="col-md-6 col-sm-6">           
                <input type="number" class="form-control" name="target_omset" id="target_omset" value="" placeholder=""  required>
              </div>                
            </div>
            <div class="form-group row">
              <label class="control-label col-md-3 col-sm-2 label-align">Target Effective Call</label>
              <div class="col-md-6 col-sm-6">           
                <input type="number" class="form-control" name="target_eff_call" id="target_eff_call" value="" placeholder=""  required>
              </div>                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" name="" value="Simpan">
              <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
  <!-- /target Modal -->  
  <!-- product focus Modal -->
  <div class="modal fade modal-product-focus" id="modal-product-focus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="product-focus-label">Tambah Produk Fokus </h4><span> </span>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"> 
          <form action="{{url('/')}}/target/product-focus" class="form-horizontal form-label-left" method="POST">
            {{csrf_field()}}            
            <input type="hidden" id="prFocusId" name="id">
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Produk</label>
              <div class="col-md-9 col-sm-12">           
                <select class="form-control" style="width: 100%" id="prFocus" name="id_product" required>
                  <option value="">-Pilih Produk-</option>
                  @foreach($data['product'] as $i)
                  <option value="{{$i->id}}">{{$i->name}}</option>
                  @endforeach 
                </select>
              </div>                
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Target</label>
              <div class="col-md-9 col-sm-12">           
                <input type="number" class="form-control" id="prFocusTarget" name="target" required>
              </div>                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" name="" value="Simpan">
              <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
  <!-- /product focus Modal --> 
  <!-- Confirm Del Modal -->   
  <div class="modal fade modal-confi"tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form action="{{url('/')}}/target/product-focus/del" method="post" accept-charset="utf-8">
          @csrf
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Hapus Produk</h4>
          </div>
          <div class="modal-body body-confi" id="md-body-confi">
          </div>
          <input type="text" name="id" id="delPrFocusId">
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
@stack('scripts')
<script src="{{asset('resources/js/views/target.js')}}"></script>
@endstack
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"
async defer></script>

<script type="text/javascript">
  function add() {
    var sel = document.getElementById('prFocus');
    if (sel.options.length-1 > {{count($data['product'])}}) {
      var sel = document.getElementById('prFocus');
      sel.removeChild( sel.options[sel.options.length-1] ); 
    }
    document.getElementById('update-label').innerHTML = 'Tambah Produk';
    $('#prFocusId').val('');
    $('#prFocusTarget').val('');
    // $('#prFocus').val(null).trigger('change');
  }

  function edit() {
    jQuery.ajax({
      url: '{{ url('/')}}'.concat('/target/edit'),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (result) {
        if (result != '[]') {
          document.getElementById('update-label').innerHTML = 'Ubah Target ';
          $('#targetId').val(result.id);
          $('#target_omset').val(result.target_omset);
          $('#target_eff_call').val(result.target_eff_call);
        }

      },
      error: function (data, textStatus, errorThrown) {
        console.log(data);
        pnotify('Error', textStatus,'error');
      }
    });
  }

  function prFocusEdit(id) {
    jQuery.ajax({
      url: '{{ url('/')}}'.concat('/target/product-focus/',id,'/edit'),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (result) {
        console.log(result);
        if (result != '[]') {
          var sel = document.getElementById('prFocus');
          if (sel.options.length-1 > {{count($data['product'])}}) {
            var sel = document.getElementById('prFocus');
            sel.removeChild( sel.options[sel.options.length-1] ); 
          }
          var opt = document.createElement('option');
          opt.appendChild( document.createTextNode(result.name) );
          opt.value = result.id_product; 
          sel.appendChild(opt);

          document.getElementById('product-focus-label').innerHTML = 'Ubah Target ' + result.name;
          $('#prFocusId').val(result.id);
          $('#prFocusTarget').val(result.target);
          $('#prFocus').select2("val", String(result.id_product));

          
        }

      },
      error: function (data, textStatus, errorThrown) {
        console.log(data);
        pnotify('Error', textStatus,'error');
      }
    });
  }

  function editOmset(id) {
    jQuery.ajax({
      url: '{{ url('/')}}'.concat('/target/',id,'/edit'),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (result) {
        console.log(result);
        if (result != '[]') {
          var sel = document.getElementById('prFocus');
          if (sel.options.length-1 > {{count($data['product'])}}) {
            var sel = document.getElementById('prFocus');
            sel.removeChild( sel.options[sel.options.length-1] ); 
          }
          var opt = document.createElement('option');
          opt.appendChild( document.createTextNode(result.name) );
          opt.value = result.id_product; 
          sel.appendChild(opt);

          document.getElementById('product-focus-label').innerHTML = 'Ubah Target ' + result.name;
          $('#prFocusId').val(result.id);
          $('#prFocusTarget').val(result.target);
          $('#prFocus').select2("val", String(result.id_product));
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
    pnotify('Sukses', 'Target berhasil ditambahkan','success');
  }, 2000);
  @endif
  @if (Session::has('update'))  
  setTimeout(function() {
    pnotify('Sukses', 'Target berhasil diperbarui','success');
  }, 2000);
  @endif
  @if (Session::has('del'))  
  setTimeout(function() {
    pnotify('Sukses', 'Target berhasil dihapus','success');
  }, 2000);
  @endif
  @if (Session::has('error'))  
  setTimeout(function() {
    pnotify('Gagal', 'Terjadi kesalahan sistem','error');
  }, 2000);
  @endif
</script>
</body>
