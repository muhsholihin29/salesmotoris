<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/table_horz_scroll/vendor/bootstrap/css/bootstrap.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
</head>
<!-- page content -->
<body>
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
            <h2><small></small></h2>
            <div class="clearfix"></div>
          </div>

          <button class="btn btn-secondary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-product" onclick="return add();"><span class="glyphicon glyphicon-plus"></span> Tambah Produk Baru</button>

          <table class="table table-bordered table-striped" id="mytable">
            <thead>
              <tr><th width="80px"><center>No<center></th>
                <th><center>Produk</center></th>
                <th><center>Harga</center></th>         
                <th width="100px"><center>Unit</center></th>
                <th width="100px"><center>Stok</center></th>
                <th width="200px"><center>Aksi</center></th>
              </tr>
            </thead>

            @foreach ($data['product'] as $key=>$product)
            <tr>
              <td><center>{{$key+1}}</center></td>
              <td><center>{{$product->name}}</center></td>
              <td><center>{{$product->price}}</center></td>
              <td><center>{{$product->unit}}</center></td>
              <td><center>{{$product->stock}}</center></td>
              <td>
                <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-product" onclick="return update({{$product->id}});">Ubah</button>
                <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-confi" onclick="return delConfirm('{{$product->id}}','{{$product->name}}');">Hapus</button>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Product Modal -->
  <div class="modal fade modal-product" id="modal-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="update-label">Tambah Produk </h4><span> </span>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"> 
          <form action="{{url('/')}}/product" class="form-horizontal form-label-left" method="POST">
            {{csrf_field()}}            
            <input type="hidden" id="storeId" name="id"> 
            <div class="form-group row">                
              <label class="control-label col-md-2 col-sm-1 label-align">Nama Produk</label>
              <div class="col-md-6 col-sm-6">               
                <input type="text" class="form-control" name="name" id="name" value="" placeholder="" required="required">
                <span id="error_kode_unit_edit"></span>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Harga</label>
              <div class="col-md-6 col-sm-6">           
                <input type="number" class="form-control" name="price" id="price" value="" placeholder=""  required>
              </div>                
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Unit</label>
              <div class="col-md-6 col-sm-6">  
                <input type="text" class="form-control" name="unit" id="unit" value="" placeholder=""  required>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Stok</label>
              <div class="col-md-6 col-sm-6">  
                <input type="number" class="form-control" name="stock" id="stock" value="0" placeholder=""  required>
              </div>
            </div>            
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" name="" value="Simpan" onclick="return validateFormUpdate();">
              <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
            </div>
          </form>
        </div>        
      </div>
    </div>
  </div>
  <!-- /Update Modal --> 
  <!-- Confirm Del Modal -->   
  <div class="modal fade modal-confi"tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form action="{{url('/')}}/product/" method="delete" accept-charset="utf-8">
          @csrf
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Hapus Produk</h4>
          </div>
          <div class="modal-body body-confi" id="md-body-confi">
          </div>
          <input type="text" name="id" id="delProductId">
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
<script src="{{asset('resources/js/views/product.js')}}"></script>
@endstack
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpgqgMyPGWmhiw8yXyJJ7UuNAOpBWBSDA"
async defer></script>
<script type="text/javascript">
  function update(id) {
    jQuery.ajax({
      url: '{{ url('/')}}'.concat('/product/',id,'/edit'),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (result) {
        if (result != '[]') {
          document.getElementById('update-label').innerHTML = 'Ubah Produk ' + result.name;
          $('#storeId').val(result.id);
          $('#name').val(result.name);
          $('#price').val(result.price);
          $('#unit').val(result.id);
          $('#stock').val(result.stock);
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
    pnotify('Sukses', 'Produk berhasil ditambahkan','success');
    console.log('aaaa');
  }, 2000);
  @endif
  @if (Session::has('update'))  
  setTimeout(function() {
    pnotify('Sukses', 'Produk berhasil diperbarui','success');
    console.log('aaaa');
  }, 2000);
  @endif
  @if (Session::has('del'))  
  setTimeout(function() {
    pnotify('Sukses', 'Produk berhasil dihapus','success');
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
</body>
