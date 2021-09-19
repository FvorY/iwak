@extends('main')
@section('content')

@include('master.pegawai.tambah')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Data Pegawai</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data Pegawai</h4>
                    @if (App\mMember::akses('MASTER DATA PEGAWAI', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info" data-toggle="modal" id="button_add" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
  				            <table class="table table-hover table-bordered" id="table-pegawai" cellspacing="0">
  				                          <thead class="bg-gradient-info">
  				                            <tr>
  				                              <th>ID</th>
  				                              <th>NIK</th>
  				                              <th>Employee Name</th>
  				                              <th>Address</th>
  				                              <th>Employee Status</th>
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
<script type="text/javascript">


    $('#table-pegawai').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url:'{{ route('datatable_pegawai') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center d_id'
                  },
                ],
            "columns": [
            { "data": "mp_kode" },
            { "data": "mp_nik" },
            { "data": "mp_name" },
            { "data": "mp_address" },
            { "data": "mp_status" },
            { "data": "aksi" },
            ]
      });

  $('#button_add').click(function(){
    var mp_name      = $("input[name='mp_name']").val('');
    var mp_nik       = $("input[name='mp_nik']").val('');
    var mp_tlp       = $("input[name='mp_phone']").val('');
    var mp_email     = $("input[name='mp_email']").val('');
    var mp_address   = $("textarea#mp_address").val('');
    var mp_pendidikan    = $("select[name='mp_pendidikan']").val('').trigger('change');
    var mp_status    = $("select[name='mp_status']").val('').trigger('change');
    var mp_position  = $("select[name='mp_position']").val('').trigger('change');
    $.ajax({
         type: "get",
         url:'{{ route('kode_pegawai') }}',
         success: function(data){
            var mp_id   = $("input[name='mp_id']").val(data[0]);
         },
         async: false
       });
    $('#change_function').html('<button class="btn btn-primary" type="button" id="save_data" >Save Data</button>')
  })

  $('#change_function').on("click", "#save_data",function(){
    $.ajax({
         type: "get",
         url: baseUrl + '/master/simpanpegawai/simpan_pegawai',
         data: $('#form_save').serialize(),
         success: function(data){
            $('#tambah').modal('hide');
            var table = $('#table-pegawai').DataTable();
            table.ajax.reload();

            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
            });
         },
         error: function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
         },
         async: false
       });
  })

   function update() {
      $.ajax({
           type: "get",
           url: baseUrl + '/master/updatepegawai/update_pegawai',
           data: $('#form_save').serialize(),
           success: function(data){
              $('#tambah').modal('hide');
              var table = $('#table-pegawai').DataTable();
              table.ajax.reload();

              iziToast.success({
                icon: 'fas fa-check-circle',
                message: 'Data Telah Terupdate!',
              });
           },
           error: function(){
            iziToast.warning({
              icon: 'fa fa-times',
              message: 'Terjadi Kesalahan!',
            });
           },
           async: false
         });
   }
   function edit(parm){
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();
    $('#tambah').modal('show');
    $.ajax({
       type: "get",
         url: baseUrl + '/master/dataeditpegawai/dataedit_pegawai',
         data: {id},
         success: function(data){
     	 $('#tambah').modal('hide');
          var table = $('#table-pegawai').DataTable();
          table.ajax.reload();
            var mp_name      = $("input[name='mp_name']").val(data[0].mp_name);
            var mp_nik       = $("input[name='mp_nik']").val(data[0].mp_nik);
            var mp_tlp       = $("input[name='mp_phone']").val(data[0].mp_phone);
            var mp_email     = $("input[name='mp_email']").val(data[0].mp_email);
            var mp_address   = $("textarea#mp_address").val(data[0].mp_address);
            var mp_pendidikan    = $("select[name='mp_pendidikan']").val(data[0].mp_pendidikan).trigger('change');
            var mp_status    = $("select[name='mp_status']").val(data[0].mp_status).trigger('change');
            var mp_position  = $("select[name='mp_position']").val(data[0].mp_position).trigger('change');
            var mp_id        = $("input[name='mp_id']").val(data[0].mp_kode);

            $('#change_function').html('<button class="btn btn-primary" type="button" onclick="update()">Update Data</button>')
         },
         error: function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
         },
         async: false
       });
  }

  function hapus(parm){
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();

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
                   type: "get",
                     url: baseUrl + '/master/hapuspegawai/hapus_pegawai',
                     data: {id},
                     success: function(data){
                      var table = $('#table-pegawai').DataTable();
          			  table.ajax.reload();


                     },
                     error: function(){
                      iziToast.warning({
                        icon: 'fa fa-times',
                        message: 'Terjadi Kesalahan!',
                      });
                     },
                     async: false
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
