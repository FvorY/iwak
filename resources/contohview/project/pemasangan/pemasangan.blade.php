@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">After Order</li>
					<li class="breadcrumb-item active" aria-current="page">Pemasangan</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Pemasangan</h4>
										<div class="row">
											<div class="col-md-4 col-sm-12 col-xs-12">
			    							<div class="alert alert-warning alert-dismissible" title="Delivered">
			    							    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    							    <strong>Notice!</strong> <br>
			    							    Released
			    							    <label class="badge badge-pill badge-warning">{{$countd}}</label>
			    							</div>
			    						</div>
											<div class="col-md-4 col-sm-12 col-xs-12">
			    							<div class="alert alert-danger alert-dismissible" title="Process Delivery">
			    							    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    							    <strong>Notice!</strong> <br>
			    							    Revition
			    							    <label class="badge badge-pill badge-danger">{{$countpd}}</label>
			    							</div>
			    						</div>
			    						<div class="col-md-4 col-sm-12 col-xs-12">
			    							<div class="alert alert-primary alert-dismissible" title="Sedang Process">
			    							    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    							    <strong>Notice!</strong> <br>
														Acc
			    							    <label class="badge badge-pill badge-primary">{{$countp}}</label>
			    							</div>
			    						</div>
										</div>
	                  <div class="table-responsive">
		                  <table class="table data-table table-hover" cellspacing="0">
		                  	<thead class="bg-gradient-info">
		                  		<tr>
		                  			<th>No</th>
														<th>Code WO</th>
		                  			<th>Customer</th>
														<th>Status SO</th>
														<th>Installer</th>
														<th>Code Perdin</th>
														<th>Delivery Rsp</th>
														<th></th>
														<th>Status Perdin</th>
		                  			<th>Action</th>
		                  		</tr>
		                  	</thead>
		                  	<tbody>
													@foreach ($data as $key => $value)
														@if ($value->so_status_delivery == 'D')
															<tr>
																<td>{{$key + 1}}</td>
																<td>{{$value->wo_nota}}</td>
																<td>{{$value->c_name}}</td>
																<td><span class="badge badge-pill badge-success">Delivered</span></td>
																<td>{{$value->mp_name}}</td>
																<td>{{$value->p_code}}</td>
																@if ($value->p_tanggung_jawab == null)
																	<td></td>
																@else
																	<td>{{Carbon\Carbon::parse($value->p_tanggung_jawab)->format('d-m-Y')}}</td>
																@endif
																@if (strtotime($value->p_tanggung_jawab) < strtotime('now') && $value->lp_code == null)
																	<td> <span style="color:red;">*</span> </td>
																@else
																	<td></td>
																@endif
																@if ($value->p_status == 'released')
																	<td> <span class="badge badge-warning" style="text-transform:uppercase;">{{$value->p_status}}</span> </td>
																@elseif ($value->p_status == 'revition')
																	<td> <span class="badge badge-danger" style="text-transform:uppercase;">{{$value->p_status}}</span> </td>
																@else
																	<td> <span class="badge badge-primary" style="text-transform:uppercase;">{{$value->p_status}}</span> </td>
																@endif
																	<td>
																		<div class="btn-group">
																			@if ($value->p_code == null)
																				<a href="{{url('project/pemasangan/prosespemasangan').'/'.$value->wo_id}}" class="btn btn-info btn-sm" title="Buat Perdin"><i class="fa fa-sign-in"></i></a>
																			@else
																			@if ($value->p_status_approve != 'Y')
																				<a href="{{url('/project/pemasangan/editperdin').'?id='.$value->wo_id}}" class="btn btn-info btn-sm" title="Edit Perdin"><i class="fa fa-edit"></i></a>
																			@endif
																			@endif
																			@if ($value->p_status != null)
																				<a href="{{url('/project/pemasangan/detailperdin').'?id='.$value->wo_id}}" class="btn btn-warning btn-sm" title="Detail Perdin"><i class="fa fa-folder"></i></a>
																			@endif
																			@if (Auth::user()->m_jabatan == 'FINANCE')
																				@if ($value->p_status_approve == 'N')
																					<button type="button" class="btn btn-success btn-sm" onclick="approve({{$value->wo_id}})" name="button" title="Approve"> <i class="fa fa-check"></i> </button>
																				@endif
																			@endif
																			@if ($value->p_status_approve == 'Y')
																				<button type="button" class="btn btn-primary btn-sm" onclick="printperdin({{$value->wo_id}})" name="button" title="Print"> <i class="fa fa-print"></i> </button>
																			@endif
																		</div>
																	</td>
															</tr>
															@endif
														@endforeach
		                  	</tbody>
		                  </table>
		              </div>
	                </div>
	              </div>
	    </div>
	</div>
</div>
<!-- content-wrapper ends -->

<!-- Modal -->
<div id="approve" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Kasbon</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
				<form id="data">
        <div class="row">
          <div class="col-3 col-sm-3 col-xs-12">
            <label>No Kasbon</label>
          </div>
          <div class="col-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="nokasbon" readonly>
            </div>
          </div>
           <div class="col-3 col-sm-3 col-xs-12">
            <label>Uang yang diberikan</label>
          </div>
          <div class="col-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" style="text-align:right" class="form-control rp" name="diberikan">
            </div>
          </div>
           <div class="col-3 col-sm-3 col-xs-12">
            <label>Diberikan Tanggal</label>
          </div>
          <div class="col-3 col-sm-3 col-xs-12">
						<div class="input-group">
										<input class="form-control datepicker" id="diberikantanggal" name="diberikantanggal" type="text" style="cursor: pointer;">
										<span class="input-group-addon bg-info text-white">
												<i class="fa fa-calendar"></i>
										</span>
						</div>
          </div>
           <div class="col-3 col-sm-3 col-xs-12">
            <label>Transaksi</label>
          </div>
          <div class="col-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control" name="transaksi" id="transaksi" onchange="transaksiup()">
								<option value=""> - Pilih Transaksi - </option>
              	<option value="transfer">Transfer</option>
								<option value="tunai">Tunai</option>
              </select>
            </div>
          </div>
           <div class="col-3 col-sm-3 col-xs-12">
            <label>Transfer Ke Bank</label>
          </div>
          <div class="col-3 col-sm-3 col-xs-12">
            <div class="form-group">
							<select class="form-control" name="transferbank">
								<option value=""> - Pilih Transfer Ke Bank - </option>
 							 @foreach ($bank as $key => $value)
 							 	<option value="{{$value->id}}">{{$value->name}}</option>
 							 @endforeach
 						 </select>
            </div>
          </div>
					<div class="col-3 col-sm-3 col-xs-12">
					 <label>Pilih Bank</label>
				 </div>
				 <div class="col-3 col-sm-3 col-xs-12">
					 <div class="form-group">
						 <select class="form-control" name="bank" id="bank">
							 <option value=""> - Pilih Bank - </option>
						 </select>
					 </div>
				 </div>
         </div>
				 </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" id="simpankasbon" onclick="simpankasbon()">Approve</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Revition</button>
      </div>
    </div>

  </div>
</div>

@endsection
@section('extra_script')
<script type="text/javascript">
	$('.rp').mask('000.000.000.000.000', {reverse: true});

	function approve(id){
		$.ajax({
			type: 'get',
			data: {id},
			dataType: 'json',
			url: baseUrl + '/project/pemasangan/getkasbon',
			success : function(response){
				$('input[name=nokasbon]').val(response.finalkode);
				$('input[name=diberikan]').val(accounting.formatMoney(response.nominal, "", 0, ".",','));

				$('#simpankasbon').attr('onclick', 'simpankasbon('+id+')');

				$('#approve').modal('show');
			}
		});
	}

	function transaksiup(){
		var transaksi = $('#transaksi').val();
		var html = '<option value=""> - Pilih Bank - </option>';
		$.ajax({
			type: 'get',
			data: {transaksi},
			url: baseUrl + '/project/pemasangan/transaksiup',
			success : function(response){
				for (var i = 0; i < response.length; i++) {
					html += '<option value="'+response[i].ak_id+'">'+response[i].ak_nama+'</option>'
				}
				$('#bank').html(html);
			}
		})
	}

	function simpankasbon(id) {
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
	                '<button style="background-color:red;">Yes</button>',
	                function (instance, toast) {

	                  $.ajax({
												type: 'get',
												data: $('#data').serialize()+'&id='+id,
												dataType: 'JSON',
												url: baseUrl + '/project/pemasangan/simpankasbon',
	                      success:function(data){
	                        if (data.status == 'berhasil') {
	                          iziToast.success({
	                            icon: 'fa fa-check',
	                            message: 'Data Berhasil diapprove!',
	                          });
														window.location.reload();
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

		function printperdin(id){
			window.open("{{ url('/project/pemasangan/printperdin') }}"+'?id='+id);
			window.location.reload();
		}

</script>
@endsection
