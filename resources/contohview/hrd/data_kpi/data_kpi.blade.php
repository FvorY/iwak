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
					<li class="breadcrumb-item active" aria-current="page">Data KPI</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Data KPI</h4>
							<div class="row">
							  <div class="panel-body">
							    <div class="row">

							      <div class="col-md-2 col-sm-3 col-xs-12">
							        <label class="tebal">Periode</label>
							      </div>

							      <div class="col-md-4 col-sm-7 col-xs-12">
							        <div class="form-group" style="display: ">
							          <div class="input-daterange input-group">
							            <input id="tanggal1" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal1" type="text">
							            <span class="input-group-addon">-</span>
							            <input id="tanggal2" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal2" type="text" value="{{ date('d-m-Y') }}">
							          </div>
							        </div>
							      </div>

							      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
							        <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatKpixByTgl()">
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

										@if (App\mMember::akses('DATA KPI', 'tambah'))
							      <div align="right">
							        <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item" data-toggle="modal" data-target="#modal_tambah_data" onclick="tambahKpix()">
							          <i class="fa fa-plus" aria-hidden="true">
							             &nbsp;
							          </i>Tambah Data
							        </button>
							      </div>
										@endif


							      <div class="col-md-12 col-sm-12 col-xs-12">
							        <div class="table-responsive">
							          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-index">
							            <thead>
							              <tr>
							                <th class="wd-10p">No</th>
							                <th class="wd-10p">Tgl</th>
							                <th class="wd-15p">Kode</th>
							                <th class="wd-10p">Pegawai</th>
							                <th class="wd-10p">Tgl Confirm</th>
							                <th class="wd-10p" style="text-align: center;">Aksi</th>
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
	</div>
</div>

<div id="modal_detail_data" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Detail Data KPI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-detail-kpi" name="formDetailKpi">
      {{ csrf_field() }}

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal</label>
            </div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<input id="d_tgl_kpix" class="form-control input-sm datepicker2" name="dtglKpix" type="text" disabled>
							</div>
						</div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="d_divisi" id="d_divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="d_iddivisi" id="d_iddivisi" class="form-control input-sm" readonly>
                <input type="hidden" name="d_old" id="d_old" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

						<div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="d_jabatan" id="d_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="d_idjabatan" id="d_idjabatan" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Pegawai</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="d_pegawai" id="d_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="d_idpegawai" id="d_idpegawai" class="form-control input-sm" readonly>
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
        <h4 class="modal-title">Edit Data KPI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-edit-kpi" name="formEditKpi">
      {{ csrf_field() }}

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal</label>
            </div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<input id="e_tgl_kpix" class="form-control input-sm datepicker2" name="eTglKpix" type="text">
							</div>
						</div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="e_divisi" id="e_divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="e_iddivisi" id="e_iddivisi" class="form-control input-sm" readonly>
                <input type="hidden" name="e_old" id="e_old" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="e_jabatan" id="e_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idjabatan" id="e_idjabatan" class="form-control input-sm" readonly>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Pegawai</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="e_pegawai" id="e_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idpegawai" id="e_idpegawai" class="form-control input-sm" readonly>
              </div>
            </div>

            <div id="e_appending"></div> {{-- appending --}}

          </div>

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="updateKpix()" id="btn_update">Update</button>
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
        <h4 class="modal-title">Tambah Data KPI</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
    <form method="post" id="form-input-kpi" name="formInputKpi">
      {{ csrf_field() }}

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal</label>
            </div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="form-group">
								<input id="tgl_kpix" class="form-control input-sm datepicker2" name="tglKpix" type="text" value="{{ date('d-m-Y') }}">
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
              <div class="form-group divSelectJabatan">
                <select class="form-control input-sm select2 selJabatan" id="jabatan" name="jabatan" style="width: 100% !important;"></select>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Pegawai</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectPegawai">
                <select class="form-control input-sm select2 selPegawai" id="pegawai" name="pegawai" style="width: 100% !important;" disabled></select>
              </div>
            </div>

          </div>

          <div id="appending"></div> {{-- appending --}}

        </div>

        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitKpix()" id="btn_simpan">Submit</button>
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
//global variable u/ select2
var idDiv = "";
var idJabatan = "";

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
		endDate: '0'
	}).datepicker("setDate", "0");
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
		$('#form-input-kpi select').empty();
		//reset all input txt field
		$('#form-input-kpi')[0].reset();
		$('#form-edit-kpi')[0].reset();
		$('#form-detail-kpi')[0].reset();
	});

	//select2
	$('.select2').select2({
	});

	$(".selJabatan").select2({
		placeholder: "Pilih Jabatan",
		ajax: {
			url: baseUrl + '/hrd/data_kpi/data_kpi/lookup-data-jabatan',
			dataType: 'json',
			data: function (params) {
				return {
						q: $.trim(params.term),
						idDiv : idDiv
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

	$('.selJabatan').change(function()
	{
		if($(this).val() != ""){
			$('.divSelectJabatan').removeClass('has-error').addClass('has-valid');
			$('.selPegawai').empty().attr('disabled', false);
		}else{
			$('.divSelectJabatan').removeClass('has-error').addClass('has-valid');
			$('.selPegawai').empty().attr('disabled', true);
		}
		// $('.kode_divisi').empty().attr('disabled', false);
		// $('.kode_jabatan').empty().attr('disabled', false);
		idJabatan = $('.selJabatan').val();
		$(".selPegawai").select2({
			placeholder: "Pilih Pegawai",
			ajax: {
				url: baseUrl + '/hrd/data_kpi/data_kpi/lookup-data-pegawai',
				dataType: 'json',
				data: function (params) {
					return {
							q: $.trim(params.term),
							idDiv : idDiv,
							idJabatan : idJabatan
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

	$('.selPegawai').change(function()
	{
		if($(this).val() != ""){
			$('.divSelectPegawai').removeClass('has-error').addClass('has-valid');
		}else{
			$('.divSelectPegawai').removeClass('has-error').addClass('has-valid');
		}
		setField($(this).val());
	});

	//validasi
	$("#form-input-kpi").validate({
		rules:{
			tglKpix : "required",
			jabatan : "required",
			pegawai : "required"
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
			eTglKpix : "required"
		},
		errorPlacement: function() {
				return false;
		},
		submitHandler: function(form) {
			form.submit();
		}
	});

	//load fungsi
	lihatKpixByTgl();
});//end jquery

function lihatKpixByTgl()
{
	var tgl1 = $('#tanggal1').val();
	var tgl2 = $('#tanggal2').val();
	$('#tbl-index').dataTable({
		"destroy": true,
		"processing" : true,
		"serverside" : true,
		"ajax" : {
			url: baseUrl + "/hrd/data_kpi/data_kpi/get-kpi-by-tgl/"+tgl1+"/"+tgl2,
			type: 'GET'
		},
		"columns" : [
			{"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
			{"data" : "tglBuat", "width" : "15%"},
			{"data" : "d_kpix_code", "width" : "15%"},
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

function tambahKpix()
{
	$.ajax({
		url : baseUrl + "/hrd/data_kpi/data_kpi/tambah-data",
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			if(response.status == "sukses")
			{
				$('#divisi').val(response.data.c_divisi);
				$('#iddivisi').val(response.data.c_divisi_id);
				idDiv = response.data.c_divisi_id;
			}
		},
		error: function(){
			console.log('terjadi kesalahan pada modal tambah data');
		},
		async: false
	});
}

function setField(id)
{
	$.ajax({
		url : baseUrl + "/hrd/data_kpi/data_kpi/set-field-modal/" + id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			if(response.status == "sukses")
			{
				var i = randString(5);
				var key = 1;
				var tgl = "";
				//loop data
				Object.keys(response.kpi).forEach(function()
				{
					tgl = response.kpi[key-1].kpix_deadline;
					if(tgl != null) { var newTgl = tgl.split("-").reverse().join("-"); }
					$('#appending').append(
							'<div class="col-md-12 col-sm-12 col-xs-12">'
								+'<label class="tebal">'+response.kpi[key-1].kpix_name+' | Bobot : <span style="color:#8080ff;">'+response.kpi[key-1].kpix_bobot+'</span> | Target : <span style="color:#8080ff;">'+response.kpi[key-1].kpix_target+'</span> | Deadline : <span style="color:#8080ff;">'+newTgl+'</span></label>'
							+'</div>'
							+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
								+'<div class="form-group">'
									+'<input type="text" id="value_kpi" name="value_kpix[]" class="form-control input-sm" placeholder="Realisasi......">'
									+'<input type="hidden" id="index_kpi" name="index_kpix[]" class="form-control input-sm" value="'+response.kpi[key-1].kpix_id+'">'
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

function submitKpix()
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
						url : baseUrl + "/hrd/data_kpi/data_kpi/simpan-data",
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
										$('#btn_simpan').text('Submit'); //change button text
										$('#btn_simpan').attr('disabled',false); //set button enable
										$('#modal_tambah_data').modal('hide');
										refreshTabelIndex();
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
							$('.divSelectJabatan').addClass('has-error');
							$('.divSelectPegawai').addClass('has-error');
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

function detailKpix(id)
{
	$.ajax({
		url : baseUrl + "/hrd/data_kpi/data_kpi/get-edit/"+id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{			
			var date = response.data[0].d_kpix_date;
			if(date != null) { var newTglKpix = date.split("-").reverse().join("-"); }

			$('#d_old').val(response.data[0].d_kpix_id);
			$('#d_tgl_kpix').val(newTglKpix);
			$('#d_divisi').val(response.pegawai.c_divisi);
			$('#d_iddivisi').val(response.data[0].kpix_div_id);
			$('#d_jabatan').val(response.pegawai.c_posisi);
			$('#d_idjabatan').val(response.data[0].kpix_div_id);
			$('#d_pegawai').val(response.pegawai.mp_name);
			$('#d_idpegawai').val(response.data[0].d_kpix_pid);

			var i = randString(5);
			var key = 1;
			var tgl = "";
			//loop data
			Object.keys(response.data).forEach(function()
			{
				tgl = response.data[key-1].kpix_deadline;
				if(tgl != null) { var newTgl = tgl.split("-").reverse().join("-"); }
				$('#d_appending').append(
						'<div class="col-md-12 col-sm-12 col-xs-12">'
							+'<label class="tebal">'+response.data[key-1].kpix_name+' | Bobot : <span style="color:#8080ff;">'+response.data[key-1].kpix_bobot+'</span> | Target : <span style="color:#8080ff;">'+response.data[key-1].kpix_target+'</span> | Deadline : <span style="color:#8080ff;">'+newTgl+'</span></label>'
						+'</div>'
						+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
							+'<div class="form-group">'
								+'<input type="text" id="d_value_kpi" name="d_value_kpix[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_value+'" readonly>'
								+'<input type="hidden" id="d_index_kpi" name="d_index_kpix[]" class="form-control input-sm" value="'+response.data[key-1].kpix_id+'" readonly>'
								+'<input type="hidden" id="d_dt" name="d_index_dt[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_id+'" readonly>'
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

function editKpix(id)
{
	$.ajax({
		url : baseUrl + "/hrd/data_kpi/data_kpi/get-edit/"+id,
		type: "GET",
		dataType: "JSON",
		success: function(response)
		{
			var date = response.data[0].d_kpix_date;
			if(date != null) { var newTglKpix = date.split("-").reverse().join("-"); }

			$('#e_old').val(response.data[0].d_kpix_id);
			$('#e_tgl_kpix').val(newTglKpix);
			$('#e_divisi').val(response.pegawai.c_divisi);
			$('#e_iddivisi').val(response.data[0].kpix_div_id);
			$('#e_jabatan').val(response.pegawai.c_posisi);
			$('#e_idjabatan').val(response.data[0].kpix_div_id);
			$('#e_pegawai').val(response.pegawai.mp_name);
			$('#e_idpegawai').val(response.data[0].d_kpix_pid);

			var i = randString(5);
			var key = 1;
			var tgl = "";
			//loop data
			Object.keys(response.data).forEach(function()
			{
				tgl = response.data[key-1].kpix_deadline;
				if(tgl != null) { var newTgl = tgl.split("-").reverse().join("-"); }
				$('#e_appending').append(
						'<div class="col-md-12 col-sm-12 col-xs-12">'
							+'<label class="tebal">'+response.data[key-1].kpix_name+' | Bobot : <span style="color:#8080ff;">'+response.data[key-1].kpix_bobot+'</span> | Target : <span style="color:#8080ff;">'+response.data[key-1].kpix_target+'</span> | Deadline : <span style="color:#8080ff;">'+newTgl+'</span></label>'
						+'</div>'
						+'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
							+'<div class="form-group">'
								+'<input type="text" id="e_value_kpi" name="e_value_kpix[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_value+'">'
								+'<input type="hidden" id="e_index_kpi" name="e_index_kpix[]" class="form-control input-sm" value="'+response.data[key-1].kpix_id+'">'
								+'<input type="hidden" id="e_dt" name="e_index_dt[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_id+'">'
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

function updateKpix()
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
						url : baseUrl + "/hrd/data_kpi/data_kpi/update-data",
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
										refreshTabelIndex();
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
										refreshTabelIndex();
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

function hapusKpix(id)
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
					url : baseUrl + "/hrd/data_kpi/data_kpi/delete-data",
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
									refreshTabelIndex();
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
									refreshTabelIndex();
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
</script>

@endsection
