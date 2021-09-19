@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">HRD</li>
					<li class="breadcrumb-item active" aria-current="page">Manajemen Scoreboard</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Manajemen Scoreboard</h4>
		          	<div class="row">
									<div class="col-md-2 col-sm-3 col-xs-12">
						        <label class="tebal">Periode</label>
						      </div>

						      <div class="col-md-4 col-sm-6 col-xs-12">
						        <div class="form-group" style="display: ">
						          <div class="input-daterange input-group">
						            <input id="tanggal1" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal1" type="text" value="{{ date('d-m-Y') }}">
						            <span class="input-group-addon">-</span>
						            <input id="tanggal2" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal2" type="text" value="{{ date('d-m-Y') }}">
						          </div>
						        </div>
						      </div>

						      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
						        <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatKpiByTgl()">
						          <strong>
						            <i class="fa fa-search" aria-hidden="true"></i>
						          </strong>
						        </button>
						        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelIndex()">
						          <strong>
						            <i class="fa fa-undo" aria-hidden="true"></i>
						          </strong>
						        </button>
						      </div>

									<div align="right">
						          <select class="form-control input-sm" name="s_confirm" id="s_confirm" onchange="lihatKpiByTgl()">
						             <option selected value="ALL">Semua</option>
						             <option value="N">Belum Dikonfirmasi</option>
						             <option value="Y">Sudah Dikonfirmasi</option>
						           </select>
						      </div>
	                </div>
		          	<div class="row">

						<div class="table-responsive">
							<table class="table table-hover" cellspacing="0" id="tbl-index">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>Date</th>
							      <th>Code</th>
							      <th>Employee</th>
							      <th>Status</th>
							      <th>Date Confirm</th>
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
</div>

<div id="modal_detail_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Detail Manajemen Scoreboard</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-detail-kpi" name="formDetailKpi">
      {{ csrf_field() }}
      <!-- Modal content-->

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;margin-bottom: 15px;">
            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Nama Pegawai : </label>
              <span id="d_pegawai"></span>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal : </label>
              <span id="d_tgl_kpi"></span>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi : </label>
              <span id="d_divisi">
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan : </label>
              <span id="d_jabatan">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 10px;padding-bottom: 10px;">
            </div>

            <div id="d_appending"></div> {{-- appending --}}

          </div>

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>
    <!-- /Form-->

  </div>

  </div>
</div>

<div id="modal_edit_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Edit Manajemen Scoreboard</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-edit-kpi" name="formEditKpi">
      {{ csrf_field() }}
      <!-- Modal content-->

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divjenis">
                <input type="text" name="e_pegawai" id="e_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idpegawai" id="e_idpegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="e_old" id="e_old" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="e_tgl_kpi" class="form-control input-sm datepicker2 " name="eTglKpi" type="text">
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<input type="text" name="e_divisi" id="e_divisi" class="form-control input-sm" readonly>
								<input type="hidden" name="e_iddivisi" id="e_iddivisi" class="form-control input-sm" readonly>
							</div>
						</div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="e_jabatan" id="e_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idjabatan" id="e_idjabatan" class="form-control input-sm" readonly>
              </div>
            </div>

            <div id="e_appending"></div> {{-- appending --}}

          </div>

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="updateKpi()" id="btn_update">Confirm</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>
    <!-- /Form-->

  </div>

  </div>
</div>

<div id="modal_tambah_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Tambah Data Scoreboard</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-input-kpi" name="formInputKpi">
      {{ csrf_field() }}
      <!-- Modal content-->

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divjenis">
                <input type="text" name="pegawai" id="pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="idpegawai" id="idpegawai" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="tgl_kpi" class="form-control input-sm datepicker2 " name="tglKpi" type="text" value="{{ date('d-m-Y') }}">
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="divisi" id="divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="iddivisi" id="iddivisi" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="jabatan" id="jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="idjabatan" id="idjabatan" class="form-control input-sm" readonly>
              </div>
            </div>

            <div id="appending"></div> {{-- appending --}}

					</div>

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitKpi()" id="btn_simpan">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>
    <!-- /Form-->

  </div>

  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script src="{{asset('assets/validation/jquery.validate.js')}}"></script>

<script type="text/javascript">
$(document).ready(function () {
	//fix to issue select2 on modal when opening in firefox
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};

	var extensions = {
			"sFilterInput": "form-control input-sm",
			"sLengthSelect": "form-control input-sm"
	}
	// Used when bJQueryUI is false
	$.extend($.fn.dataTableExt.oStdClasses, extensions);
	// Used when bJQueryUI is true
	$.extend($.fn.dataTableExt.oJUIClasses, extensions);

	var date = new Date();
	var newdate = new Date(date);
	newdate.setDate(newdate.getDate()-3);
	var nd = new Date(newdate);

	//datepicker
	$('.datepicker1').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		endDate: 'today'
	}).datepicker("setDate", nd);

	$('.datepicker2').datepicker({
		autoclose: true,
		format:"dd-mm-yyyy",
		endDate: 'today'
	});//datepicker("setDate", "0");
	//end datepicker

	// fungsi jika modal hidden
	$(".modal").on("hidden.bs.modal", function(){
		//remove append tr
		//$('tr').remove('.tbl_modal_detail_row');
		$('#appending div').remove();
		$('#e_appending div').remove();
		$('#d_appending div').remove();
		//remove class all jquery validation error
		$('.form-group').find('.error').removeClass('error');
		$('.form-group').removeClass('has-valid has-error');
		//reset all input txt field
		$('#form-input-kpi')[0].reset();
		$('#form-edit-kpi')[0].reset();
		$('#form-detail-kpi')[0].reset();
	});

	// //select2
	// $('.select2').select2({
	// });

	$('.jenis_pegawai').change(function()
	{
		if($(this).val() != ""){
			$('.divjenis').removeClass('has-error').addClass('has-valid');
			$('.kode_divisi').empty().attr('disabled', false);
			$('.kode_jabatan').empty().attr('disabled', false);
			$('.pegawai').empty().attr('disabled', false);
		}else{
			$('.divjenis').addClass('has-error').removeClass('has-valid');
			$('.kode_divisi').empty().attr('disabled', true);
			$('.kode_jabatan').empty().attr('disabled', true);
			$('.pegawai').empty().attr('disabled', true);
		}

		$('.kode_divisi').empty().attr('disabled', false);
		$('.kode_jabatan').empty().attr('disabled', false);
		var jenis = $(this).val();

		$(".kode_divisi").select2({
			placeholder: "Pilih Divisi",
			ajax: {
				url: baseUrl + '/hrd/kpi/lookup-data-divisi',
				dataType: 'json',
				data: function (params) {
					return {
							q: $.trim(params.term),
							jenis : jenis
					};
				},
				processResults: function (data) {
						return {
								results: data
						};
				},
				cache: true
			},
		});
	});

	//validasi
	$("#form-input-kpi").validate({
		rules:{
			tglKpi : "required"
		},
		errorPlacement: function() {
				return false;
		},
		submitHandler: function(form) {
			form.submit();
		}
	});

	$("#form-edit-kpi").validate({
		rules:{
			eTglKpi : "required"
		},
		errorPlacement: function() {
				return false;
		},
		submitHandler: function(form) {
			form.submit();
		}
	});

	//load fungsi
	lihatKpiByTgl();
});//end jquery

function lihatKpiByTgl()
{
	var tgl1 = $('#tanggal1').val();
	var tgl2 = $('#tanggal2').val();
	var tampil = $('#s_confirm').val();
	$('#tbl-index').dataTable({
		"destroy": true,
		"processing" : true,
		"serverside" : true,
		"ajax" : {
			url: baseUrl + "/hrd/manajemen_scoreboard/manajemen_scoreboard/get-kpi-by-tgl/"+tgl1+"/"+tgl2+"/"+tampil,
			type: 'GET'
		},
		"columns" : [
			{"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
			{"data" : "tglBuat", "width" : "10%"},
			{"data" : "d_kpi_code", "width" : "10%"},
			{"data" : "mp_name", "width" : "30%"},
			{"data" : "status", "width" : "15%"},
			{"data" : "tglConfirm", "width" : "15%"},
			{"data" : "action", orderable: false, searchable: false, "width" : "15%"}
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
}

function confirmKpi(id)
{
	$.ajax({
		url : baseUrl + "/hrd/manajemen_scoreboard/manajemen_scoreboard/get-edit/"+id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			var date = response.data[0].d_kpi_date;
			if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }

			$('#e_old').val(response.data[0].d_kpi_id);
			$('#e_idpegawai').val(response.data[0].d_kpi_pid);
			$('#e_pegawai').val(response.pegawai.mp_name);
			$('#e_tgl_kpi').val(newDueDate);
			$('#e_divisi').val(response.pegawai.c_divisi);
			$('#e_iddivisi').val(response.data[0].kpi_div_id);
			$('#e_jabatan').val(response.pegawai.c_posisi);
			$('#e_idjabatan').val(response.data[0].kpi_jabatan_id);

			var i = randString(5);
			var key = 1;
			//loop data
			Object.keys(response.data).forEach(function()
			{
				$('#e_appending').append(
					'<div class="col-md-12 col-sm-12 col-xs-12">'
						+'<label class="tebal">'+response.data[key-1].kpi_name+'</label>'
					+'</div>'
					+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
						+'<div class="form-group">'
							+'<textarea class="form-control input-sm" id="e_value_kpi" name="e_value_kpi[]" rows="3">'+response.data[key-1].d_kpidt_value+'</textarea>'
							+'<input type="hidden" id="e_index_kpi" name="e_index_kpi[]" class="form-control input-sm" value="'+response.data[key-1].kpi_id+'">'
							 +'<input type="hidden" id="e_dt" name="e_index_dt[]" class="form-control input-sm" value="'+response.data[key-1].d_kpidt_id+'">'
						+'</div>'
					+'</div>');
				i = randString(5);
				key++;
			});
			$('#modal_edit_data').modal('show');
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
				alert('Error get data from ajax');
		}
	});
}

function detailKpi(id)
{
	$.ajax({
		url : baseUrl + "/hrd/manajemen_scoreboard/manajemen_scoreboard/get-edit/"+id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			var date = response.data[0].d_kpi_date;
			if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }

			$('#d_old').val(response.data[0].d_kpi_id);
			$('#d_pegawai').text(response.pegawai.mp_name);
			$('#d_tgl_kpi').text(newDueDate);
			$('#d_divisi').text(response.pegawai.c_divisi);
			$('#d_jabatan').text(response.pegawai.c_posisi);

			var i = randString(5);
			var key = 1;
			//loop data
			Object.keys(response.data).forEach(function()
			{
				$('#d_appending').append(
					'<div class="col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">'
						+'<label class="tebal">'+response.data[key-1].kpi_name+' :</label>'
						+'<span id="d_value_kpi"> '+response.data[key-1].d_kpidt_value+'</span>'
					+'</div>');
				i = randString(5);
				key++;
			});
			$('#modal_detail_data').modal('show');
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
				alert('Error get data from ajax');
		}
	});
}

function updateKpi()
{
	iziToast.question({
		close: false,
		overlay: true,
		displayMode: 'once',
		//zindex: 999,
		title: 'Konfirmasi Data KPI',
		message: 'Apakah anda yakin ?',
		position: 'center',
		buttons: [
			['<button><b>Ya</b></button>', function (instance, toast) {
				var IsValid = $("form[name='formEditKpi']").valid();
				if(IsValid)
				{
					$('#btn_update').text('Confirm...');
					$('#btn_update').attr('disabled',true);
					$.ajax({
						url : baseUrl + "/hrd/manajemen_scoreboard/manajemen_scoreboard/update-data",
						type: "POST",
						dataType: "JSON",
						data: $('#form-edit-kpi').serialize(),
						success: function(response)
						{
							if(response.status == "sukses")
							{
								instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
								iziToast.success({
									position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
									title: 'Pemberitahuan',
									message: response.pesan,
									onClosing: function(instance, toast, closedBy){
										$('#btn_update').text('Confirm'); //change button text
										$('#btn_update').attr('disabled',false); //set button enable
										$('#modal_edit_data').modal('hide');
										$('#tbl-index').DataTable().ajax.reload();
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
										$('#btn_update').text('Update'); //change button text
										$('#btn_update').attr('disabled',false); //set button enable
										$('#modal_edit_data').modal('hide');
										$('#tbl-index').DataTable().ajax.reload();
									}
								});
							}
						},
						error: function(){
							instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
							iziToast.warning({
								icon: 'fa fa-times',
								message: 'Terjadi Kesalahan!'
							});
						},
						async: false
					});
				}
				else
				{
					instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
					iziToast.warning({
						position: 'center',
						message: "Mohon Lengkapi data form !",
						onClosing: function(instance, toast, closedBy){
							$('.divjenis').addClass('has-error');
							$('.divDivisi').addClass('has-error');
							$('.divJabatan').addClass('has-error');
							$('.divPegawai').addClass('has-error');
						}
					});
				} //end check valid
			}, true],
			['<button>Tidak</button>', function (instance, toast) {
				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
			}],
		]
	});
}

function ubahStatus(id, status)
{
	iziToast.question({
		timeout: 20000,
		close: false,
		overlay: true,
		displayMode: 'once',
		title: 'Ubah Status Data',
		message: 'Apakah anda yakin ?',
		position: 'center',
		buttons: [
			['<button><b>Ya</b></button>', function (instance, toast) {
				$.ajax({
					url : baseUrl + "/hrd/manajemen_scoreboard/manajemen_scoreboard/ubah-status",
					type: "POST",
					dataType: "JSON",
					data: {id:id, status:status, "_token": "{{ csrf_token() }}"},
					success: function(response)
					{
						if(response.status == "sukses")
						{
							instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
							iziToast.success({
								position: 'topRight',
								title: 'Pemberitahuan',
								message: response.pesan,
								onClosing: function(instance, toast, closedBy){
									$('#tbl-index').DataTable().ajax.reload();
								}
							});
						}
						else
						{
							instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
							iziToast.error({
								position: 'topRight',
								title: 'Pemberitahuan',
								message: response.pesan,
								onClosing: function(instance, toast, closedBy){
									$('#tbl-index').DataTable().ajax.reload();
								}
							});
						}
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						iziToast.error({
							icon: 'fa fa-times',
							message: 'Terjadi Kesalahan!'
						});
					}
				});
			}, true],
			['<button>Tidak</button>', function (instance, toast) {
				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
			}],
		]
	});
}

function randString(angka)
{
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for (var i = 0; i < angka; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
}

function refreshTabelIndex()
{
	$('#tbl-index').DataTable().ajax.reload();
}

function refreshTabelLaporan()
{
	$('#tbl-laporan').DataTable().ajax.reload();
}
</script>
@endsection
