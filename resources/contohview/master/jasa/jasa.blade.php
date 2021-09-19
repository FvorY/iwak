@extends('main')
@section('content')

@include('master.jasa.tambah_jasa')
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active" aria-current="page">Master Data Jasa Pemasangan</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data Jasa Pemasangan</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      @if(Auth::user()->akses('MASTER DATA JASA','tambah'))
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah_jasa"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table_jasa table-hover " id="table_jasa" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Services Name</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Description</th>
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
  // $('#i_name').keyup(function(){
  //   this.value = this.value.toUpperCase();
  // });

  $(document).ready(function(){

    $('#i_price').mask('000.000.000.000.000', {reverse: true});

    $('#table_jasa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route('datatable_jasa') }}',
        },
        columnDefs: [

                {
                   targets: 0 ,
                   className: 'center'
                },
                {
                   targets: 4,
                   className: 'center'
                },
              ],
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'i_name', name: 'i_name'},
          {data: 'i_price', name: 'i_price'},
          {data: 'u_unit', name: 'u_unit'},
          {data: 'i_description', name: 'i_description'},
          {data: 'aksi', name: 'aksi'}


        ]

    });
  })


  function edit(i_id) {
    // body...
    $.ajax({
      url:baseUrl + '/master/jasa/edit_jasa',
      data:{i_id},
      dataType:'json',
      success:function(data){
        $('#i_id').val(data.jasa.i_id);
        $('#i_name').val(data.jasa.i_name);
        $('#i_price').val(accounting.formatMoney(data.jasa.i_price, "", 0, ".",','));
        $('#i_unit').val(data.jasa.u_unit);
        $('#i_description').val(data.jasa.i_description);
        $('select[name="akun"]').val(data.jasa.i_akun_persediaan).trigger('change');
        $('#tambah_jasa').modal('show');
      }
    });

  }

  $('.simpan_jasa').click(function(){
    $.ajax({
      url:baseUrl + '/master/jasa/simpan_jasa',
      data:$('#t55am1').serialize(),
      dataType:'json',
      success:function(data){
        if (data.jasa == 1) {
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Disimpan!',
          });
        }else if(data.jasa == 2){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Sudah Ada!',
          });
        }else if (data.jasa == 3){
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Diubah!',
          });
        }else if (data.jasa == 4){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Ini Tidak Bisa Dirubah!',
          });
        }

        $('#tambah_jasa').modal('hide');
        $('#t55am1 :input').val('');
        var table = $('#table_jasa').DataTable();
        table.ajax.reload();
      }
    });
  })


  function hapus(i_id) {
    $.ajax({
      url:baseUrl + '/master/jasa/hapus_jasa',
      data:{i_id},
      dataType:'json',
      success:function(data){
        iziToast.success({
            icon: 'fa fa-trash',
            message: 'Data Berhasil Dihapus!',
        });

        var table = $('#table_jasa').DataTable();
        table.ajax.reload();
      }
    });
  }

  function reset(){
    $('.reset').val('');
    $("#akun").val('').trigger('change');
  }
</script>
@endsection
