@extends('main')
@section('content')

<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="/home">Home</a></li>
          {{-- <li class="breadcrumb-item">Setup Master Tagihan</li> --}}
          <li class="breadcrumb-item active" aria-current="page">Tagihan</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Tagihan</h4>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Nominal</th>
                                <th>Type</th>
                                <th>Berlangsung</th>
                                <th>Auto Debit</th>
                                <th>Note</th>
                                <th>Jatuh Tempo</th>
                                <th>Status Bayar</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody>

                            </tbody>


                        </table>
                    </div>
                  </div>
                </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->

<!-- Modal -->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Tanggal dibayar</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext datepicker" name="date">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" id="simpan" type="button">Process</button> --}}
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>


@endsection
@section('extra_script')
<script>

var table = $('#table-data').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        searching: true,
        paging: true,
        dom: 'Bfrtip',
        title: '',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url:'{{ url('/tagihantable') }}',
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id'
              },
              {
                 targets: 1,
                 className: 'nominal center'
              },
              {
                 targets: 2,
                 className: 'type center'
              },
              {
                 targets: 3,
                 className: 'center'
              },
              {
                 targets: 4,
                 className: 'center'
              },
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 6,
                 className: 'center'
              },
              {
                 targets: 7,
                 className: 'center'
              },
              {
                 targets: 8,
                 className: 'center'
              }
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'nominal', name: 'nominal'},
          {data: 'type_nama', name: 'type_nama'},
          {data: 'looptype_name', name: 'looptype_name'},
          {data: 'autodebit', name: 'autodebit'},
          {data: 'tagihan_note', name: 'tagihan_note'},
          {data: 'jatuhtempo', name: 'jatuhtempo'},
          {data: 'statusbayar', name: 'statusbayar'},
          {data: 'aksi', name: 'aksi'},

        ]
  });

  function lihat(obj) {
    var date = $(obj).data("date");

    // alert(date);
    $('.datepicker').val(date);

    $('#detail').modal('show');
  }

  function bayar(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Bayar Tagihan',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrl + '/bayartagihan',
            data:{id},
            dataType:'json',
            success:function(data){
              if (data.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Dibayar!',
                });
                reloadall();
              }else if(data.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal Dibayar!',
                });
              }else if (data.status == 3){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Saldo tidak cukup!',
                });
            }
          }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  }

  function reloadall() {
    // var table1 = $('#table_modal').DataTable();
    // table1.ajax.reload();
    table.ajax.reload();
  }
</script>
@endsection
