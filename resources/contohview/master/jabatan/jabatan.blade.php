@extends('main')
@section('content')

@include('master.jabatan.tambah')
@include('master.jabatan.edit')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Data Jabatan</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data jabatan</h4>
                    @if (App\mMember::akses('MASTER DATA JABATAN', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info" data-toggle="modal" id="button_add" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
  				            <table class="table table-hover table-bordered" id="table-jabatan" cellspacing="0">
  				                          <thead class="bg-gradient-info">
  				                            <tr>
  				                              <th>ID</th>
  				                              <th>NAMA</th>
  				                              <th>DIVISI</th>
  				                              <th>ACTION</th>
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
<script type="text/javascript">
var table;
$(document).ready(function(){
   table = $('#table-jabatan').DataTable({
          processing: true,
          // responsive:true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_jabatan') }}',
          },
           columnDefs: [

                {
                   targets: 0 ,
                   className: 'center d_id'
                },
                {
                   targets: 3 ,
                   className: 'center'
                },
              ],
          "columns": [
          { "data": "number" },
          { "data": "c_posisi" },
          { "data": "c_divisi" },
          { "data": "aksi" },
          ]
    });

});

$('#save_data').on('click', function(){
    $.ajax({
      type: 'get',
      data: $('#form_save').serialize(),
      dataType: 'json',
      url: baseUrl + '/master/jabatan/simpan',
      success : function(response){
        if (response.status == 'berhasil') {
          iziToast.success({
            icon: 'fas fa-check-circle',
            message: 'Data Telah Tersimpan!',
          });
          table.ajax.reload();
        } else {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
      }
    });
});


function edit(id){
  $.ajax({
    type: 'get',
    data: {id:id},
    dataType: 'json',
    url: baseUrl + '/master/jabatan/edit',
    success : function(response){
      $('#namajabatanedit').val(response[0].c_posisi);
      $('#divisiedit').find('option[value="'+response[0].c_divisi_id+'"]').attr('selected','selected');
      var text = $('#divisiedit').find('option[value="'+response[0].c_divisi_id+'"]').text();
      $('#select2-divisiedit-container').text(text);
      $('input[name=id]').val(id);

      $('#edit').modal('show');
    }
  });
}

$('#edit_data').on('click', function(){
  var data = $('#namajabatanedit').val();
  var id = $('input[name=id]').val();
    $.ajax({
      type: 'get',
      data: {data:data, id:id},
      dataType: 'json',
      url: baseUrl + '/master/jabatan/update',
      success : function(response){
        if (response.status == 'berhasil') {
          iziToast.success({
            icon: 'fas fa-check-circle',
            message: 'Data Telah Tersimpan!',
          });
          table.ajax.reload();
        } else {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
      }
    });
});

function hapus(id) {
    iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Important!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
              [
                '<button style="background-color:red;">Delete</button>',
                function (instance, toast) {

                  $.ajax({
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    url: baseUrl + '/master/jabatan/hapus',
                    success : function(response){
                      if (response.status == 'berhasil') {
                        iziToast.success({
                          icon: 'fas fa-check-circle',
                          message: 'Data Telah Dihapus!',
                        });
                        table.ajax.reload();
                      } else {
                        iziToast.warning({
                          icon: 'fa fa-times',
                          message: 'Terjadi Kesalahan!',
                        });
                      }
                      },
                      error:function(){
                        iziToast.warning({
                          icon: 'fa fa-times',
                          message: 'Terjadi Kesalahan!',
                        });
                      }
                  });

                }
              ],
              [
                '<button style="background-color:#44d7c9;">Cancel</button>',
                function (instance, toast) {
                  instance.hide({
                    transitionOut: 'fadeOutUp'
                  }, toast);
                }
              ]
            ]
          });
  }

</script>
@endsection
