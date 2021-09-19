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
  				<li class="breadcrumb-item active" aria-current="page">Master KPI</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master KPI</h4>
                    <div id="tab-general">
                      <div class="row mbl">
                        <div class="col-lg-12">
                          <div class="col-md-12">
                            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                            </div>
                          </div>

                          <div id="generalTabContent" class="tab-content responsive">
                            <!-- div index-tab -->
                            <div class="row" style="margin-top:-15px;">
                              <div align="left" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
                                <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refresh()">
                                  <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
                                </button>
                              </div>

                              @if (App\mMember::akses('MASTER KPI', 'tambah'))
                              <div align="right" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
                                <a href="{{ url('master/kpi/tambah-kpi') }}">
                                  <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                    <i class="fa fa-plus" aria-hidden="true">
                                    &nbsp;
                                    </i>Tambah Data
                                  </button>
                                </a>
                              </div>
                              @endif

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                  <table class="table table-hover table-bordered" id="tbl-index" cellspacing="0">
                                    <thead class="bg-gradient-info">
                                      <tr>
                                        <th>NO</th>
                                        <th>Indikator</th>
                                        <th>Deadline</th>
                                        <th>Bobot</th>
                                        <th>Target</th>
                                        <th>Pegawai</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody></tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
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
    $(document).ready(function() {
      //fix to issue select2 on modal when opening in firefox
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
      //add bootstrap class to datatable
      var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url : baseUrl + "/master/kpi/datatable-index",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "kpix_name", "width" : "25%"},
          {"data" : "deadline", "width" : "10%"},
          {"data" : "kpix_bobot", "width" : "10%"},
          {"data" : "kpix_target", "width" : "10%"},
          {"data" : "mp_name", "width" : "10%"},
          {"data" : "c_posisi", "width" : "15%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "50%"}
        ],
        "language": {
          "searchPlaceholder": "Cari Data",
          "emptyTable": "Tidak ada data",
          "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
          "sSearch": '<i class="fa fa-search"></i>',
          "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
          "infoEmpty": "",
          "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
          }
        }
      });
    }); //end jquery

    function hapus(id) {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        // id: 'question',
        zindex: 999,
        title: 'Hapus Data',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
              $.ajax({
                type: "POST",
                url : baseUrl + "/master/kpi/delete-kpi",
                data: {id:id, "_token": "{{ csrf_token() }}"},
                success: function(response){
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        refresh();
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        refresh();
                      }
                    });
                  }
                },
                error: function(){
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }

    function edit(id) {
      $.ajax({
        type: "GET",
        url : baseUrl + "/master/kpi/edit-kpi",
        data: {id},
        success: function(data){
        },
        complete:function (argument) {
          window.location=(this.url)
        },
        error: function(){

        },
        async: false
      });
    }

    function refresh() {
      $('#tbl-index').DataTable().ajax.reload();
    }
  </script>
@endsection
