@extends('main')
@section('content')

@include('master.status.tambah_status')
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
          <li class="breadcrumb-item active" aria-current="page">Master Data Status Q.O.#</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data Status Q.O.#</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      @if(Auth::user()->akses('MASTER DATA STATUS','tambah'))
                    	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah_status"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      @endif
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table_status" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Status Name</th>
                                <th>Color</th>
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

  $(document).ready(function(){
    $('#table_status').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route('datatable_status') }}',
        },
        columnDefs: [

                {
                   targets: 0 ,
                   className: 'center'
                },
                {
                   targets: 3,
                   className: 'center'
                },
              ],
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 's_name', name: 's_name'},
          {data: 'status', name: 'status'},
          {data: 'aksi', name: 'aksi'},
          

        ]

    });
  })


  function edit(id) {
    // body...
    $.ajax({
      url:baseUrl + '/master/status/edit_status',
      data:{id},
      dataType:'json',
      success:function(data){
        $('.id').val(data.data.s_id);
        $('#i_status_color').val(data.data.s_color);
        $('#i_status_color').select2();
        $('.name').val(data.data.s_name);
        $('#tambah_status').modal('show');
      }
    });

  }

  $('.simpan_status').click(function(){
    $.ajax({
      url:baseUrl + '/master/status/simpan_status',
      data:$('.table_status :input').serialize(),
      dataType:'json',
      success:function(data){
        if (data.status == 1) {
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Disimpan!',
          });
        }else if(data.status == 2){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Sudah Ada!',
          });
        }else if (data.status == 3){
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Diubah!',
          });
        }else if (data.status == 4){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Ini Tidak Bisa Dirubah!',
          });
        }

        $('#tambah_status').modal('hide');
        $('#table_status :input').val('');
        $('#i_status_color').val('0');
        $('#i_status_color').select2();
        var table = $('#table_status').DataTable();
        table.ajax.reload();
      }
    });
  })


  function hapus(id) {
    $.ajax({
      url:baseUrl + '/master/status/hapus_status',
      data:{id},
      dataType:'json',
      success:function(data){
        iziToast.success({
            icon: 'fa fa-trash',
            message: 'Data Berhasil Dihapus!',
        });

        var table = $('#table_status').DataTable();
        table.ajax.reload();
      }
    });
  }
</script>
@endsection