<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
</head>
<!-- page content -->
<body>
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Stok</h3>

      </div>

      <div class="title_right">

        <div class="col-md-9 col-sm-9 form-group pull-right top_search">
          <!-- <span>Edit hapus data Asesor</span>   -->
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
                <select class="form-control" style="width: 100%" id="filSales" name="id_product" required>
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
            <h2><small>Data Stok Sales</small></h2>
            <div class="clearfix"></div>
          </div>
          @if(!empty($data['stock']))
          <button class="btn btn-secondary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-stock" onclick="return add();"><span class="glyphicon glyphicon-plus"></span> Tambah Stok Baru</button>
          @endif

          <table class="table table-bordered table-striped" id="mytable">
            <thead>
              <tr><th width="80px"><center>No<center></th>
                <th><center>Produk</center></th>
                <th width="300px"><center>Kuantitas</center></th>         
                <th width="200px"><center>Aksi</center></th>
              </tr>
            </thead>
            @if(!empty($data['stock']))
            @foreach ($data['stock'] as $key=>$stock)
            <tr>
              <td><center>{{$key+1}}</center></td>
              <td><center>{{$stock->product}}</center></td>
              <td><center>{{$stock->quantity}} {{$stock->unit}}</center></td>
              <td>
                <button type="button" class="btn transparent btn-green" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-stock" onclick="return update({{$stock->id}});">Ubah</button>
                <button type="button" class="btn transparent btn-red" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".modal-confi" onclick="return delConfirm('{{$stock->id}}','{{$stock->product}}');">Hapus</button>
              </td>
            </tr>
            @endforeach
            @endif
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- stock Modal -->
  <div class="modal fade modal-stock" id="modal-stock" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="update-label">Tambah Stok </h4><span> </span>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"> 
          <form action="{{url('/')}}/stock" class="form-horizontal form-label-left" method="POST">
            {{csrf_field()}}            
            <input type="hidden" id="stockId" name="id"> 
            <input type="hidden" name="id_sales" id="salesId">
            <div class="form-group row">                
              <label class="control-label col-md-2 col-sm-1 label-align">Nama Produk</label>
              <div class="col-md-6 col-sm-6">               
                @if(!empty($data['product']))
                <select class="form-control" style="width: 100%" id="product" name="id_product" required>
                  <option value="">-Pilih Produk-</option>
                  @foreach($data['product'] as $i)
                  <option value="{{$i->id}}">{{$i->name}}</option>
                  @endforeach 
                </select>
                @endif
                <span id="error_kode_unit_edit"></span>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-md-2 col-sm-2 label-align">Kuantitas</label>
              <div class="input-group col-md-6 col-sm-6">           
                <input type="number" class="form-control" name="quantity" id="quantity" value="" placeholder=""  required>
                <span class="input-group-addon" id="unit"></span>
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
  <!-- /Stock Modal --> 
  <!-- Confirm Del Modal -->   
  <div class="modal fade modal-confi"tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form action="{{url('/')}}/stock/del" method="post" accept-charset="utf-8">
          @csrf
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Hapus Stok</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body body-confi" id="md-body-confi">
          </div>
          <input type="hidden" name="id" id="delStockId">
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
  <!-- /page content-->

  @stack('scripts')
  <script src="{{asset('resources/js/views/stock.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){  
      $("#product").on("input", function(){
        var prSelected = document.getElementById('product').value;
        var pr = (<?php echo json_encode($data['product']) ?>);
        pr.forEach(function(i){
          if (prSelected == i['id']) {
            document.getElementById('unit').innerHTML = i['unit'];    
          }
        });
      });
    });

    function update(id) {
      document.getElementById("load").style.visibility = "visible";
      var url = document.URL;
      var idSales = url.substring(url.lastIndexOf('/') + 1);
      $('#salesId').val(idSales);
      jQuery.ajax({
        url: '{{ url('/')}}'.concat('/stock/',id,'/edit'),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (result) {
          if (result != '[]') {
            document.getElementById('update-label').innerHTML = 'Ubah Stok ' + result.product;
            $('#stockId').val(id);
            document.getElementById('product').value = result.id_product;
            $('#quantity').val(result.quantity);
            document.getElementById('unit').innerHTML = result.unit;

            var sel = document.getElementById('product');
            if (sel.options.length-1 > {{count($data['product'])}}) {

              sel.removeChild( sel.options[sel.options.length-1] ); 
            }
            var opt = document.createElement('option');
            opt.appendChild( document.createTextNode(result.product) );
            opt.value = result.id_product; 
            sel.appendChild(opt);

            $('#product').val(result.id_product);
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
</body>
