@extends('main')
@section('content')
@include('penjualpesanan.listpayment')
@include('penjualpesanan.detailpesanan')

<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/penjual/home')}}">Home</a></li>
          <li class="breadcrumb-item">Penjual</li>
          <li class="breadcrumb-item active" aria-current="page">List Pesanan</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">List Pesanan</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      {{-- @if(Auth::user()->akses('MASTER DATA STATUS','tambah')) --}}
                    	{{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button> --}}
                      {{-- @endif --}}
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Nota</th>
                                <th>Pembeli</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                                <th>Date</th>
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
@endsection
@section('extra_script')
<script>

baseUrlChange += '/penjual/listorder'

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
            url: baseUrlChange + "/table",
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id'
              },
              {
                 targets: 1,
                 className: 'center'
              },
              {
                 targets: 2,
                 className: 'center'
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
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'nota', name: 'nota'},
          {data: 'fullname', name: 'fullname'},
          {data: 'subtotal', name: 'subtotal'},
          {data: 'status', name: 'status'},
          {data: 'date', name: 'date'},
          {data: 'aksi', name: 'aksi'},
        ]
  });

  function cancel(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Cancel pesanan',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrlChange + '/cancel',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dicancel!',
                });
              reloadall();
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dicancel!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dicancel!',
                });
                reloadall();
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dicancel!',
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

  function hapus(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Pesanan dihapus',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrlChange + '/hapus',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dihapus!',
                });
                reloadall();
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dihapus!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dihapus!',
                });
                reloadall();
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dihapus!',
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

  function deliverdone(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Pesanan selesai dikirim',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrlChange + '/deliverdone',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Sudah Dikirim!',
                });
                reloadall();
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dikirim!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Sudah Dikirim!',
                });
                reloadall();
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dikirim!',
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

  function deliver(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Pesanan dikirim',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrlChange + '/deliver',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dikirim!',
                });
                reloadall();
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dikirim!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dikirim!',
                });
                reloadall();
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dikirim!',
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

  function approve(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Konfirmasi pembayaran',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrlChange + '/approve',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pembayaran Berhasil Dikonfirmasi!',
                });
                reloadall();
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pembayaran Gagal Dikonfirmasi!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pembayaran Berhasil Dikonfirmasi!',
                });
                reloadall();
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pembayaran Gagal Dikonfirmasi!',
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
    $('.table_modal :input').val("");
    $('.image-holder').empty();
    $('#tambah').modal('hide');
    $('#listpay').modal('hide');
    $('#detailpesanan').modal('hide');
    // // $('#table_modal :input').val('');
    // $(".inputtext").val("");
    // var table1 = $('#table_modal').DataTable();
    // table1.ajax.reload();
    table.ajax.reload();
  }

  function showpayment(id) {
      $('#table-datapay').DataTable().clear().destroy();

      $('#table-datapay').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            searching: true,
            paging: true,
            ajax: {
                url: baseUrlChange + "/showpayment/" + id,
            },
            columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center id'
                  },
                  {
                     targets: 1,
                     className: 'center'
                  },
                  {
                     targets: 2,
                     className: 'center'
                  },
                  {
                     targets: 3,
                     className: 'center'
                  },
                ],
            "columns": [
              {data: 'DT_Row_Index', name: 'DT_Row_Index'},
              {data: 'image', name: 'image'},
              {data: 'aksi', name: 'aksi'},
              {data: 'approve', name: 'approve'},
            ]
      });

      $('#listpay').modal('show');
  }

  function detail(id) {
    var html = "";
    $.ajax({
      url: baseUrlChange + '/detail',
      data:{id},
      dataType:'json',
      success:function(response){

        var subtotal = 0
        for (var i = 0; i < response.length; i++) {

          let detail = response[i];

          subtotal += detail.qty * detail.price;

          html += "<tr>"+
                  "<td> "+(i+1)+" </td>"+
                  "<td> "+detail.name+" </td>"+
                  "<td> "+detail.qty+" </td>"+
                  "<td> "+"Rp. " + accounting.formatMoney(detail.price,"",0,'.',',')+" </td>"+
                  "<td> "+"Rp. " + accounting.formatMoney((detail.qty * detail.price),"",0,'.',',')+" </td>"+
                  "<tr>";
        }

        $('#subtotal').text(accounting.formatMoney(subtotal,"",0,'.',','));
        $('#alamatpengiriman').text(response[0].address)
        $('#bodydetail').html(html);
        $('#detailpesanan').modal('show');

      }
    })
  }
</script>
@endsection
