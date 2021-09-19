@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
				<li class="breadcrumb-item">Pemasangan</li>
				<li class="breadcrumb-item"><a href="{{url('project/pemasangan/pemasangan')}}">Pengiriman Barang</a></li>
				<li class="breadcrumb-item active" aria-current="page">Detail Perdin</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Detail Perdin</h4>
									<form id="data">
										<input type="hidden" name="id" value="{{$id}}">
                	<div class="row">
                		<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Customer</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" disabled class="form-control form-control-sm" name="customer" value="{{$data[0]->c_code}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Address</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<textarea class="form-control form-control-sm" disabled name="address">{{$data[0]->c_address}}</textarea>
		                			</div>
		                		</div>
		                	</div>
	                	</div>
	                	<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>W.O.#</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" disabled class="form-control form-control-sm" name="codewo" value="{{$data[0]->wo_nota}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Code Perdin</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" disabled class="form-control form-control-sm" name="codeperdin" value="{{$perdin->p_code}}">
		                			</div>
		                		</div>
		                	</div>
											<input type="hidden" name="d_wo" value="{{$data[0]->wo_nota}}">
	                	</div>
			              	<div class="col-md-6 col-sm-12 col-xs-12">
			              		<div class="row">
					              	<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Tanggal Pengajuan</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<div class="input-group">
						                        <input class="form-control datepicker" disabled name="pengajuandate" value="{{Carbon\Carbon::parse($perdin->p_pengajuan)->format('d-m-Y')}}" type="text" style="cursor: pointer;">
						                        <span class="input-group-addon bg-info text-white">
						                            <i class="fa fa-calendar"></i>
						                        </span>
					                        </div>
				            			</div>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Nama Pelaksana</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<select class="form-control" disabled name="pelaksana">
				            					<option> - Pilih Pelaksana - </option>
															@foreach ($pelaksana as $key => $value)
																<option value="{{$value->mp_id}}" @if ($value->mp_id == $perdin->p_pelaksana)
																	selected
																@endif>{{$value->mp_kode}} - {{$value->mp_name}}</option>
															@endforeach
				            				</select>
				            			</div>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Proyek</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<textarea disabled class="form-control form-control-sm" name="proyek">{{$perdin->p_proyek}}</textarea>
				            			</div>
				            		</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Tanggal Pertanggung Jawaban</label>
				            		</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<div class="input-group">
						                        <input disabled class="form-control datepicker" id="tanggung" value="{{Carbon\Carbon::parse($perdin->p_tanggung_jawab)->format('d-m-Y')}}" disabled name="tanggalpertanggungjawab" type="text" style="cursor: pointer;">
						                        <span class="input-group-addon bg-info text-white">
						                            <i class="fa fa-calendar"></i>
						                        </span>
					                        </div>
				            			</div>
				            		</div>
				            	</div>
				            </div>

                	</div>

										<div class="col-md-12">
											<div class="row">
											<div class="col-md-3 col-sm-6 col-xs-12">
												<label>Lama Dinas</label>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-12 alamraya-no-padding">
												<div id="datepicker-popup" disabled class="input-group date datepicker">
																			<input type="text" class="form-control" disabled name="dinasstart" value="{{Carbon\Carbon::parse($perdin->p_dinas_start)->format('d-m-Y')}}" id="ksdatepicker01" placeholder="dd-mm-yyyy">
																			<div class="input-group-addon">
																				<span class="mdi mdi-calendar"></span>
																			</div>
																	</div>
											</div>
											<span class="alamraya-span-addon">
												-
											</span>
											<div class="col-lg-4 col-md-4 col-sm-12 alamraya-no-padding">
												<div id="datepicker-popup" class="input-group date datepicker">
																			<input type="text" disabled class="form-control" name="dinasend" value="{{Carbon\Carbon::parse($perdin->p_dinas_end)->format('d-m-Y')}}" onchange="gettanggung()" id="ksdatepicker02" placeholder="dd-mm-yyyy">
																			<div class="input-group-addon">
																				<span class="mdi mdi-calendar"></span>
																			</div>
																	</div>
											</div>
										</div>
									</div>

                  <div class="table-responsive">
	                  <table class="table table-hover" id="table" cellspacing="0">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>Keterangan</th>
	                  			<th>Jumlah (Rp)</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
												@foreach ($perdindt as $key => $value)
													<tr>
														<td><input type="text" disabled name="keterangan[]" class="form-control input-sm min-width" value="{{$value->pd_keterangan}}"></td>
														<td><input type="text" disabled class="form-control input-sm min-width" name="jumlah[]" style="text-align:right;" value="{{number_format($value->pd_jumlah,0,',','.')}}"></td>
													</tr>
												@endforeach
	                  	</tbody>
	                  </table>
	              </div>

	              <div class="row">
	              	<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
	              		{{-- <button class="btn btn-sm btn-info" onclick="simpan()" type="button">Simpan</button> --}}
	              		<a href="{{url('project/pemasangan/pemasangan')}}" class="btn btn-secondary btn-sm">Back</a>
	              	</div>
	              </div>
                </div>
              </div>
							</form>
            </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
var table;
	$('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

	$(document).ready(function(){
		table = $('#table').DataTable();
		$('.rp').maskMoney({thousands:'.', decimal:',', precision:0});
	});

	function gettanggung(){
		var enddate = $('#ksdatepicker02').val();

		$.ajax({
			type: 'get',
			data: {enddate:enddate},
			dataType: 'json',
			url: baseUrl + '/project/pemasangan/gettanggung',
			success : function(response){
				$('#tanggung').val(response);
			}
		});
	}

	$('#jumlahenter').keypress(function(e){
		if(e.which == 13 || e.keyCode == 13){
			var keteranganenter = $('#keteranganenter').val();
			var jumlahenter = $('#jumlahenter').val();

			if (keteranganenter == "" || jumlahenter == "") {

			} else {
				table.row.add( [
					 '<input type="text" readonly name="keterangan[]" class="form-control input-sm min-width" value="'+ keteranganenter +'">',
					 '<input type="text" readonly class="form-control input-sm min-width" name="jumlah[]" style="text-align:right;" value="'+ jumlahenter +'">',
					 '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>',
			 ] ).draw( false );
			}
			$('#keteranganenter').val('');
			$('#jumlahenter').val('');
		}
	});

	$('#table tbody').on( 'click', '.delete', function () {
		var m_table       = $("#table").DataTable();

	    m_table
	        .row( $(this).parents('tr') )
	        .remove()
	        .draw();
	});

	function simpan(){
		$.ajax({
			type: 'get',
			data: $('#data').serialize()+'&tanggung='+$('#tanggung').val(),
			dataType: 'JSON',
			url : baseUrl + '/project/pemasangan/updateperdin',
			success : function(response){
				if (response.status == 'berhasil') {
					iziToast.success({
							icon: 'fa fa-check',
							message: 'Berhasil diedit!',
					});

					window.location.href = baseUrl + '/project/pemasangan/pemasangan';
				}else{
					iziToast.warning({
							icon: 'fa fa-info',
							message: 'Gagal diedit!',
					});
				}
			}
		});
	}
</script>
@endsection
