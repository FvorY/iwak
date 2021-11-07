@extends('main')
@section('content')

@include('penjuallelang.edit')
@include('penjuallelang.listbid')
@include('penjuallelang.pemenang')
@include('penjuallelang.tambah')

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
          <li class="breadcrumb-item active" aria-current="page">Manage Lelang</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Manage Lelang</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      <button type="button" class="btn btn-info" onclick="showcreate()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      {{-- @if(Auth::user()->akses('MASTER DATA STATUS','tambah')) --}}
                    	{{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button> --}}
                      {{-- @endif --}}
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Image Utama</th>
                                <th>Nama Produk</th>
                                <th>Harga Diawal</th>
                                <th>Status</th>
                                <th>Pemenang</th>
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

baseUrlChange += '/penjual/lelang'

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
          {data: 'image', name: 'image'},
          {data: 'name', name: 'name'},
          {data: 'price', name: 'price'},
          {data: 'status', name: 'status'},
          {data: 'pemenang', name: 'pemenang'},
          {data: 'aksi', name: 'aksi'},
        ]
  });

  function edit(id) {
    // body...
    $.ajax({
      url:baseUrlChange + '/edit',
      data:{id},
      dataType:'json',
      success:function(data){
        reloadall()
        $('.id').val(data.id_lelang);
        $('.namaproduk').text(data.name);
        $('.hargawal').val("Rp. " + accounting.formatMoney(data.price,"",0,'.',','));


        $('#edit').modal('show');
      }
    });

  }

  function pemenang(id) {

    $.ajax({
      url:baseUrlChange + '/pemenang',
      data:{id},
      dataType:'json',
      success:function(data){
        reloadall()
        $('.nama').text(data.fullname);
        $('.email').text(data.email);
        $('.phone').text(data.phone);
        $('.address').text(data.address);

        $('#pemenang').modal('show');
      }
    });

  }

  function listbid(id) {
      $('#table-databid').DataTable().clear().destroy();

      $('#table-databid').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            searching: true,
            paging: true,
            ajax: {
                url: baseUrlChange + "/listbid/" + id,
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
                ],
            "columns": [
              {data: 'DT_Row_Index', name: 'DT_Row_Index'},
              {data: 'name', name: 'name'},
              {data: 'price', name: 'price'},
              {data: 'status', name: 'status'},
              {data: 'aksi', name: 'aksi'},
            ]
      });

      $('#listbid').modal('show');
  }

  $('#update').click(function(){

  $.ajax({
    type: "post",
    url: baseUrlChange + '/update?_token='+"{{csrf_token()}}&"+$('.table_modalupdate :input').serialize(),
    processData: false, //important
    contentType: false,
    cache: false,
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Data Berhasil Disimpan!',
        });
        reloadall();
      }else if(data.status == 2){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Data Gagal disimpan!',
        });
      }else if (data.status == 3){
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Data Berhasil Diubah!',
        });
        reloadall();
      }else if (data.status == 4){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Data Gagal Diubah!',
        });
      } else if (data.status == 7) {
        iziToast.warning({
            icon: 'fa fa-info',
            message: data.message,
        });
      }

    }
  });
})

$('#simpan').click(function(){

$.ajax({
  type: "post",
  url: baseUrlChange + '/simpan?_token='+"{{csrf_token()}}&"+$('.table_modal :input').serialize(),
  processData: false, //important
  contentType: false,
  cache: false,
  success:function(data){
    if (data.status == 1) {
      iziToast.success({
          icon: 'fa fa-save',
          message: 'Data Berhasil Disimpan!',
      });
      reloadall();
    }else if(data.status == 2){
      iziToast.warning({
          icon: 'fa fa-info',
          message: 'Data Gagal disimpan!',
      });
    }else if (data.status == 3){
      iziToast.success({
          icon: 'fa fa-save',
          message: 'Data Berhasil Diubah!',
      });
      reloadall();
    }else if (data.status == 4){
      iziToast.warning({
          icon: 'fa fa-info',
          message: 'Data Gagal Diubah!',
      });
    } else if (data.status == 7) {
      iziToast.warning({
          icon: 'fa fa-info',
          message: data.message,
      });
    }

  }
});
})

function hapus(id) {
  iziToast.question({
    closeOnClick: true,
    timeout: false,
    overlay: true,
    displayMode: 'once',
    title: 'Hapus Lelang',
    message: 'Apakah anda yakin ?, menghapus lelang?',
    position: 'center',
    buttons: [
      ['<button><b>Ya</b></button>', function (instance, toast) {
        $.ajax({
          url:baseUrlChange + '/hapus',
          data:{id},
          dataType:'json',
          success:function(data){

            if (data.status == 3) {
              iziToast.success({
                  icon: 'fa fa-trash',
                  message: 'Lelang Berhasil Dihapus!',
              });

              reloadall();
            }else if(data.status == 4){
              iziToast.warning({
                  icon: 'fa fa-info',
                  message: 'Lelang Gagal Dihapus!',
              });
            }else if (data.status == 7) {
              iziToast.warning({
                  icon: 'fa fa-info',
                  message: data.message,
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


  function aktif(id) {
    iziToast.question({
      closeOnClick: true,
      timeout: false,
      overlay: true,
      displayMode: 'once',
      title: 'Aktifkan Lelang',
      message: 'Apakah anda yakin ?, mengaktifkan Lelang?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrlChange + '/aktif',
            data:{id},
            dataType:'json',
            success:function(data){

              if (data.status == 3) {
                iziToast.success({
                    icon: 'fa fa-trash',
                    message: 'Lelang Berhasil Diaktifkan!',
                });

                reloadall();
              }else if(data.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Lelang Gagal Diaktifkan!',
                });
              }else if (data.status == 7) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
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

  function nonaktif(id) {
    iziToast.question({
      closeOnClick: true,
      timeout: false,
      overlay: true,
      displayMode: 'once',
      title: 'Nonaktifkan Lelang',
      message: 'Apakah anda yakin ?, menonaktifkan Lelang?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrlChange + '/nonaktif',
            data:{id},
            dataType:'json',
            success:function(data){

              if (data.status == 3) {
                iziToast.success({
                    icon: 'fa fa-trash',
                    message: 'Lelang Berhasil Dinonaktifkan!',
                });

                reloadall();
              }else if(data.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Lelang Gagal Dinonaktifkan!',
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

  function won(id) {
    iziToast.question({
      closeOnClick: true,
      timeout: false,
      overlay: true,
      displayMode: 'once',
      title: 'Pilih Pemenang',
      message: 'Apakah anda yakin ?, pilih pemenang ini?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrlChange + '/won',
            data:{id},
            dataType:'json',
            success:function(data){

              if (data.status == 3) {
                iziToast.success({
                    icon: 'fa fa-trash',
                    message: 'Pemenang Berhasil Dipilih!',
                });

                $('#listbid').modal('hide');
                reloadall();
              }else if(data.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pemenang Gagal Dipilih!',
                });
              }else if (data.status == 7) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
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
    $('#edit').modal('hide');
    $('.produk').val('').change();
    // // $('#table_modal :input').val('');
    // $(".inputtext").val("");
    // var table1 = $('#table_modal').DataTable();
    // table1.ajax.reload();
    table.ajax.reload();
  }

  function showcreate() {
    reloadall()

    $('#tambah').modal('show');
  }

</script>
@endsection
