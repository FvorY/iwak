@extends('main')
@section('content')

@include('master.bank.tambah_bank')
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
          <li class="breadcrumb-item active" aria-current="page">Master Data Bank</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data Bank</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      @if(Auth::user()->akses('MASTER DATA BANK','tambah'))
                    	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah_bank"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      @endif
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_bank table-hover " id="table_bank" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Bank Name</th>
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
  // $('#name').keyup(function(){
  //   this.value = this.value.toUpperCase();
  // });

  $(document).ready(function(){
    $('#table_bank').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{ route('datatable_bank') }}',
        },
        columnDefs: [

                {
                   targets: 0 ,
                   className: 'center'
                },
                {
                   targets: 2,
                   className: 'center'
                },
              ],
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'name', name: 'name'},
          {data: 'aksi', name: 'aksi'}
          

        ]

    });
  })


  function edit(id) {
    // body...
    $.ajax({
      url:baseUrl + '/master/bank/edit_bank',
      data:{id},
      dataType:'json',
      success:function(data){
        $('#id').val(data.bank.id);
        $('#name').val(data.bank.name);
        $('#tambah_bank').modal('show');
      }
    });

  }

  $('.simpan_bank').click(function(){
    $.ajax({
      url:baseUrl + '/master/bank/simpan_bank',
      data:$('#t55am1').serialize(),
      dataType:'json',
      success:function(data){
        if (data.bank == 1) {
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Disimpan!',
          });
        }else if(data.bank == 2){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Sudah Ada!',
          });
        }else if (data.bank == 3){
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Diubah!',
          });
        }else if (data.bank == 4){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Ini Tidak Bisa Dirubah!',
          });
        }

        $('#tambah_bank').modal('hide');
        $('#table_bank :input').val('');
        var table = $('#table_bank').DataTable();
        table.ajax.reload();
      }
    });
  })


  function hapus(id) {
    $.ajax({
      url:baseUrl + '/master/bank/hapus_bank',
      data:{id},
      dataType:'json',
      success:function(data){
        iziToast.success({
            icon: 'fa fa-trash',
            message: 'Data Berhasil Dihapus!',
        });

        var table = $('#table_bank').DataTable();
        table.ajax.reload();
      }
    });
  }
</script>
@endsection