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
        <h3>Laporan Sales</h3>
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
            <h2><small></small></h2>
            <div class="clearfix"></div>
          </div>

          <table class="table table-bordered table-striped" id="myTable">
            <thead>
              <tr><th width="50px"><center>No<center></th>
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
                
                <th width="110px"><center>Total Omset</center></th>
                <th width="110px"><center>Sisa Target Omset</center></th>                
                <th width="100px"><center>Total Transaksi</center></th>
                <th width="110px"><center>Sisa Target Effective Call</center></th>
                <th width="110px"><center>Total Produk Fokus</center></th>
                <th width="110px"><center>Sisa Target Produk Fokus</center></th>
                <th width="100px"><center>Aksi</center></th>
              </tr>
            </thead>

            @foreach ($data['report'] as $key=>$report)
            <?php 
            $remainOmz = $data['target']->target_omset-$report->income;
            if ($remainOmz < 0) {
              $remainOmz = 'Tercapai';
            }else{
              $remainOmz = 'Rp'.number_format($remainOmz,2,',','.');
            }

            $remainEff = $data['target']->target_eff_call-$report->eff_call;
            if ($remainEff < 0) {
              $remainEff = 'Target Tercapai';
            }

            // $remainPrFocus = $data['pr_focus']-
             ?>
            <tr>
              <td><center>{{$key+1}}</center></td>
              <td><center>{{$report->name}}</center></td>              
              <td><center>Rp{{number_format($report->income,2,',','.')}}</center></td>
              <td><center>{{$remainOmz}}</center></td>
              <td><center>{{$report->eff_call}}</center></td>
              <td><center>{{$remainEff}}</center></td>
              <td><center>0</center></td>
              <td><center>0</center></td>
              <td>
                <form action="{{url('/')}}/report/{{$report->id}}" method="get">
                  <button type="submit" class="btn transparent btn-grey">Detail</button>
                </form>
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
