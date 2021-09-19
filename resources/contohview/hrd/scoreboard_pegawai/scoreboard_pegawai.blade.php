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
					<li class="breadcrumb-item active" aria-current="page">Scoreboard Pegawai</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Scoreboard Pegawai</h4>

							<div class="row">

								<div class="col-md-2 col-sm-3 col-xs-12">
									<label class="tebal">Periode</label>
								</div>

								<div class="col-md-4 col-sm-7 col-xs-12">
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

								@if (App\mMember::akses('SCOREBOARD PEGAWAI', 'tambah')) 
									<div align="right">
										<button type="button" class="btn btn-box-tool" title="Tambahkan Data Item" data-toggle="modal" data-target="#modal_tambah_data" onclick="setFieldBySesion()">
											<i class="fa fa-plus" aria-hidden="true">
												 &nbsp;
											</i>Tambah Data
										</button>
									</div>
								@endif


								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="table-responsive">
											<table class="table table-striped table-hover" cellspacing="0" id="table-index">
											<thead>
												<tr>
													<th>No</th>
													<th>Tgl</th>
													<th>Kode</th>
													<th>Pegawai</th>
													<th>Tgl Confirm</th>
													<th style="text-align: center;">Aksi</th>
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
</div>

<div id="modal_detail_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Detail Data Scoreboard</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-detail-kpi" name="formDetailKpi">
      {{ csrf_field() }}
      <!-- Modal content-->

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divjenis">
                <input type="text" name="d_pegawai" id="d_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="d_idpegawai" id="d_idpegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="d_old" id="d_old" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="d_tgl_kpi" class="form-control input-sm datepicker2 " name="dTglKpi" type="text" disabled>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="d_divisi" id="d_divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="d_iddivisi" id="d_iddivisi" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="d_jabatan" id="d_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="d_idjabatan" id="d_idjabatan" class="form-control input-sm" readonly>
              </div>
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
        <h4 class="modal-title">Edit Data Scoreboard</h4>
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
          <button type="button" class="btn btn-info" onclick="updateKpi()" id="btn_update">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>
    <!-- /Form-->

  </div>

  </div>
</div>

<!-- Modal -->
<div id="modal_tambah_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Tambah Data Scoreboard</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
					<form method="post" id="form-input-kpi" name="formInputKpi">
			      {{ csrf_field() }}

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
			              <div class="form-group">
			                <input type="text" name="divisi" id="divisi" class="form-control input-sm" readonly>
			                <input type="hidden" name="iddivisi" id="iddivisi" class="form-control input-sm" readonly>
			              </div>
			            </div>

			            <div class="col-md-6 col-sm-6 col-xs-6">
			              <label class="tebal">Jabatan</label>
			            </div>

			            <div class="col-md-6 col-sm-6 col-xs-6">
			              <div class="form-group">
			                <input type="text" name="jabatan" id="jabatan" class="form-control input-sm" readonly>
			                <input type="hidden" name="idjabatan" id="idjabatan" class="form-control input-sm" readonly>
			              </div>
			            </div>

			            <div id="appending"></div> {{-- appending --}}

								</form>

			      <!-- /Modal content-->
         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="button" onclick="submitKpi()" id="btn_simpan">Simpan</button>
      </div>
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
	newdate.setDate(newdate.getDate()-30);
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

	//select2
	$('.select2').select2({
	});

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
	//setFieldBySesion();
});//end jquery

function lihatKpiByTgl()
{
	var tgl1 = $('#tanggal1').val();
	var tgl2 = $('#tanggal2').val();
	$('#table-index').dataTable({
		"destroy": true,
		"processing" : true,
		"serverside" : true,
		"ajax" : {
			url: baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/datatable/"+tgl1+"/"+tgl2,
			type: 'GET'
		},
		"columns" : [
			{"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
			{"data" : "tglBuat", "width" : "15%"},
			{"data" : "d_kpi_code", "width" : "15%"},
			{"data" : "mp_name", "width" : "35%"},
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

function setFieldBySesion()
{
	$.ajax({
		url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/set-field-modal",
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			if(response.status == "sukses")
			{
				$('#idpegawai').val(response.id_peg);
				$('#pegawai').val(response.data.mp_name);
				$('#divisi').val(response.data.c_divisi);
				$('#iddivisi').val(response.data.c_divisi_id);
				$('#jabatan').val(response.data.c_posisi);
				$('#idjabatan').val(response.data.c_jabatan_id);

				var i = randString(5);
				var key = 1;
				//loop data
				Object.keys(response.kpi).forEach(function()
				{
					$('#appending').append(
							'<div class="col-md-12 col-sm-12 col-xs-12">'
								+'<label class="tebal">'+response.kpi[key-1].kpi_name+'</label>'
							+'</div>'
							+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
								+'<div class="form-group">'
									+'<textarea class="form-control input-sm" id="value_kpi" name="value_kpi[]" rows="3"></textarea>'
									+'<input type="hidden" id="index_kpi" name="index_kpi[]" class="form-control input-sm" value="'+response.kpi[key-1].kpi_id+'">'
								+'</div>'
							+'</div>');
					i = randString(5);
					key++;
				});

			}
		},
		error: function(){
			console.log('terjadi kesalahan pada set nama pada modal');
		},
		async: false
	});
}

function submitKpi()
{
	iziToast.question({
		close: false,
		overlay: true,
		displayMode: 'once',
		//zindex: 999,
		title: 'Simpan Data KPI',
		message: 'Apakah anda yakin ?',
		position: 'center',
		buttons: [
			['<button><b>Ya</b></button>', function (instance, toast) {
				var IsValid = $("form[name='formInputKpi']").valid();
				if(IsValid)
				{
					$('#btn_simpan').text('Saving...');
					$('#btn_simpan').attr('disabled',true);
					$.ajax({
						url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/simpan-data",
						type: "POST",
						dataType: "JSON",
						data: $('#form-input-kpi').serialize(),
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
										$('#btn_simpan').text('Submit'); //change button text
										$('#btn_simpan').attr('disabled',false); //set button enable
										$('#modal_tambah_data').modal('hide');
										$('#table-index').DataTable().ajax.reload();
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
										$('#btn_simpan').text('Submit'); //change button text
										$('#btn_simpan').attr('disabled',false); //set button enable
										$('#modal_tambah_data').modal('hide');
										$('#table-index').DataTable().ajax.reload();
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

function editKpi(id)
{
	$.ajax({
		url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/get-edit/"+id,
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
		url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/get-edit/"+id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			var date = response.data[0].d_kpi_date;
			if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }

			$('#d_old').val(response.data[0].d_kpi_id);
			$('#d_idpegawai').val(response.data[0].d_kpi_pid);
			$('#d_pegawai').val(response.pegawai.mp_name);
			$('#d_tgl_kpi').val(newDueDate);
			$('#d_divisi').val(response.pegawai.c_divisi);
			$('#d_iddivisi').val(response.data[0].kpi_div_id);
			$('#d_jabatan').val(response.pegawai.c_posisi);
			$('#d_idjabatan').val(response.data[0].kpi_jabatan_id);

			var i = randString(5);
			var key = 1;
			//loop data
			Object.keys(response.data).forEach(function()
			{
				$('#d_appending').append(
						'<div class="col-md-12 col-sm-12 col-xs-12">'
							+'<label class="tebal">'+response.data[key-1].kpi_name+'</label>'
						+'</div>'
						+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
							+'<div class="form-group">'
								+'<textarea class="form-control input-sm" id="d_value_kpi" name="d_value_kpi[]" rows="3" readonly>'+response.data[key-1].d_kpidt_value+'</textarea>'
								+'<input type="hidden" id="d_index_kpi" name="d_index_kpi[]" class="form-control input-sm" value="'+response.data[key-1].kpi_id+'" readonly>'
							+'</div>'
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
		title: 'Update Data KPI',
		message: 'Apakah anda yakin ?',
		position: 'center',
		buttons: [
			['<button><b>Ya</b></button>', function (instance, toast) {
				var IsValid = $("form[name='formEditKpi']").valid();
				if(IsValid)
				{
					$('#btn_update').text('Update...');
					$('#btn_update').attr('disabled',true);
					$.ajax({
						url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/update-data",
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
										$('#btn_update').text('Update'); //change button text
										$('#btn_update').attr('disabled',false); //set button enable
										$('#modal_edit_data').modal('hide');
										$('#table-index').DataTable().ajax.reload();
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
										$('#table-index').DataTable().ajax.reload();
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

function hapusKpi(id)
{
	iziToast.question({
		timeout: 20000,
		close: false,
		overlay: true,
		displayMode: 'once',
		title: 'Hapus data',
		message: 'Apakah anda yakin ?',
		position: 'center',
		buttons: [
			['<button><b>Ya</b></button>', function (instance, toast) {
				$.ajax({
					url : baseUrl + "/hrd/scoreboard_pegawai/scoreboard_pegawai/delete-data",
					type: "POST",
					dataType: "JSON",
					data: {id:id, "_token": "{{ csrf_token() }}"},
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
									$('#table-index').DataTable().ajax.reload();
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
									$('#table-index').DataTable().ajax.reload();
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
	$('#table-index').DataTable().ajax.reload();
}

</script>

@endsection
