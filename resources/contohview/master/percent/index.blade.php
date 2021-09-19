@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Percent</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Percent</h4>
                    @if (App\mMember::akses('MASTER PERCENT', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
  				            <table class="table table-hover table-bordered" id="table-percent" cellspacing="0">
  				                          <thead class="bg-gradient-info">
  				                            <tr>
                                        <th>Percent</th>
                                        <th>Status</th>
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

<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Tambah Percent</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Percent</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <div class="input-group">
                <input type="number" id="percent" class="form-control" placeholder="Percent %">
                <span class="input-group-addon bg-primary border-primary" id="colored-addon3">
                  <i class="mdi mdi-percent text-white"></i>
                </span>
              </div>
            </div>
          </div>
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" onclick="simpan()">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
var table;

  table = $('#table-percent').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:baseUrl + '/master/percent/datatable_percent',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center d_id'
                  },
                  {
                     targets: 1 ,
                     className: 'center status'
                  },
                  {
                     targets: 2 ,
                     className: 'center aksi'
                  },
                ],
            "columns": [
            { "data": "p_percent" },
            { "data": "status" },
            { "data": "aksi" },
            ]
      });

  function aktif(id){
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
                '<button style="background-color:rgb(116, 179, 252)">Aktifkan</button>',
                function (instance, toast) {

                  $.ajax({
                   type: "get",
                     url: baseUrl + '/master/percent/aktif',
                     data: {id},
                     success: function(response){
                       if (response.status == 'berhasil') {
                         iziToast.success({
                           icon: 'fas fa-check-circle',
                           message: 'Successfully!',
                         });
                         table.ajax.reload();
                       } else if (response.status == 'lebih') {
                         iziToast.warning({
                           icon: 'fa fa-times',
                           message: 'Hanya boleh 1 data saja yang aktif!',
                         });
                       } else {
                         iziToast.warning({
                           icon: 'fa fa-times',
                           message: 'Terjadi Kesalahan!',
                         });
                       }
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
                '<button>Cancel</button>',
                function (instance, toast) {
                  instance.hide({
                    transitionOut: 'fadeOutUp'
                  }, toast);
                }
              ]
            ]
          });


  }

  function nonaktif(id){
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
                '<button style="background-color:rgb(116, 179, 252)">Non Aktifkan</button>',
                function (instance, toast) {

                  $.ajax({
                   type: "get",
                     url: baseUrl + '/master/percent/nonaktif',
                     data: {id},
                     success: function(response){
                       if (response.status == 'berhasil') {
                         iziToast.success({
                           icon: 'fas fa-check-circle',
                           message: 'Successfully!',
                         });
                         table.ajax.reload();
                       } else {
                         iziToast.warning({
                           icon: 'fa fa-times',
                           message: 'Terjadi Kesalahan!',
                         });
                       }
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
                '<button>Cancel</button>',
                function (instance, toast) {
                  instance.hide({
                    transitionOut: 'fadeOutUp'
                  }, toast);
                }
              ]
            ]
          });
  }

  function tambah(){
    $('#tambah').modal('show');
  }

  function simpan(){
    var percent = $('#percent').val();
    $.ajax({
      type: 'get',
      data: {percent},
      dataType: 'json',
      url: baseUrl + '/master/percent/simpan',
      success : function(response){
        if (response.status == 'berhasil') {
          iziToast.success({
            icon: 'fas fa-check-circle',
            message: 'Successfully!',
          });
          table.ajax.reload();
          var percent = $('#percent').val('');
          $('#tambah').modal('hide');
        } else {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
      }
    })
  }

</script>
@endsection
