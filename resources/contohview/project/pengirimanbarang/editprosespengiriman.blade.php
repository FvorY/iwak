@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
				<li class="breadcrumb-item">After Order</li>
				<li class="breadcrumb-item"><a href="{{url('project/pengirimanbarang/pengirimanbarang')}}">Pengiriman Barang</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Process Pengiriman Barang</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Process Pengiriman Barang</h4>
									<form id="dataedit">
									<input type="hidden" name="nota" value="{{$delivery[0]->d_do}}">
                	<div class="row">
                		<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Customer</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{$data[0]->c_code}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Order By</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" value="{{$data[0]->c_name}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Address</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<textarea class="form-control form-control-sm" readonly="">{{$data[0]->c_address}}</textarea>
		                			</div>
		                		</div>
		                	</div>
	                	</div>
	                	<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Date</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{Carbon\Carbon::parse($data[0]->so_date)->format('d-m-Y')}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>S.O.#</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{$data[0]->so_nota}}">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Ship to</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="{{$data[0]->q_ship_to}}">
		                			</div>
		                		</div>
		                	</div>
											<input type="hidden" name="d_so" value="{{$data[0]->so_nota}}">
	                	</div>
			              	<div class="col-md-6 col-sm-12 col-xs-12">
			              		<div class="row">
					              	<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Delivery Date</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<div class="input-group">
						                        <input class="form-control datepicker" readonly="" name="d_delivery_date" type="text" value="{{Carbon\Carbon::parse($delivery[0]->d_delivery_date)->format('d-m-Y')}}" style="cursor: pointer;">
						                        <span class="input-group-addon bg-info text-white">
						                            <i class="fa fa-calendar"></i>
						                        </span>
					                        </div>
				            			</div>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Shipping Charges</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<input type="text" name="d_shipping_charges" id="d_shipping_charges" class="form-control form-control-sm rp" value="Rp. {{number_format($delivery[0]->d_shipping_charges,0,',','.')}}">
				            			</div>
				            		</div>
				            	</div>
				            </div>
                	</div>

                  <div class="table-responsive">
	                  <table class="table data-table table-hover" cellspacing="0">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>Item</th>
	                  			<th>Qty</th>
	                  			<th>Unit</th>
													<th>Description</th>
													<th>Unit Price</th>
													<th>Line Total</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
												@foreach ($barang as $key => $value)
													<tr>
		                  			<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="{{$value->i_code}} - {{$value->i_name}}">
		                  			</td>
		                  			<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="{{$value->qd_qty}}">
		                  			</td>
		                  			<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="{{$value->u_unit}}">
		                  			</td>
		                  			<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="{{$value->qd_description}}">
		                  			</td>
														<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Rp. {{number_format($value->qd_price,2,',','.')}}">
		                  			</td>
														<td>
		                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Rp. {{number_format($value->qd_total,2,',','.')}}">
		                  			</td>
		                  		</tr>
												@endforeach
	                  	</tbody>
	                  </table>
	              </div>

								<br>
								<h3>Accessories</h3>
								<div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
									<div class="col-md-2 col-sm-6 col-xs-12">
										<label>Accesories Name</label>
									</div>
									<div class="col-md-3 col-sm-12 col-xs-12">
										<div class="form-group item_div">
											<input type="text" class="form-control" name="acc" id="acc" value="">
										</div>
									</div>
									<div class="col-md-1 col-sm-6 col-xs-12">
										<label>Description</label>
									</div>
									<div class="col-md-3 col-sm-8 col-xs-12">
										<div class="form-group">
											<input type="text" class="form-control form-control-sm" name="acc_desc" id="acc_desc">
										</div>
									</div>
									<div class="col-md-1 col-sm-6 col-xs-12">
										<label>Qty</label>
									</div>
									<div class="col-md-2 col-sm-8 col-xs-12">
										<div class="form-group">
											<input type="number" class="form-control form-control-sm" name="acc_qty" id="acc_qty" title="Press Enter">
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-hover" id="acctable" cellspacing="0">
										<thead class="bg-gradient-info">
											<tr>
												<th width="30%">Item</th>
												<th width="10%">Description</th>
												<th width="20%">QTY</th>
												<th width="3%">Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($acc as $key => $value)
											<tr>													
												<td><input type="text" readonly name="accin[]" class="form-control input-sm min-width" value="{{$value->a_acc}}"></td>
												<td><input type="text" readonly name="desc[]" class="form-control input-sm min-width" value="{{$value->a_description}}"></td>
												<td><input type="text" readonly name="qty[]" class="form-control input-sm min-width" value="{{$value->a_qty}}"></td>
												<td><center><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></center></td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								</form>
	              <div class="row">
	              	<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
	              		<button class="btn btn-sm btn-info" onclick="perbarui()" type="button">Process</button>
	              		<a href="{{url('project/pengirimanbarang/pengirimanbarang')}}" class="btn btn-secondary btn-sm">Back</a>
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
var tableacc;

$(document).ready(function(){
	tableacc = $('#acctable').DataTable();
});

$('#acc_qty').keypress(function(e){
	if(e.which == 13 || e.keyCode == 13){
		var accname = $('#acc').val();
		var accdesc = $('#acc_desc').val();
		var accqty = $('#acc_qty').val();

		if (accqty != 0) {
				tableacc.row.add([
					'<input type="text" readonly name="accin[]" class="form-control input-sm min-width" value="'+ accname +'">',
					'<input type="text" readonly name="desc[]" class="form-control input-sm min-width" value="'+ accdesc +'">',
					'<input type="text" readonly name="qty[]" class="form-control input-sm min-width" value="'+ accqty +'">',
					'<center><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></center>',
				]).draw(false);
		}
		$('#acc').val('');
		$('#acc_desc').val('');
		$('#acc_qty').val('');
	}
});

$('#acctable tbody').on( 'click', '.delete', function () {
	var tableacc       = $("#acctable").DataTable();

		tableacc
				.row( $(this).parents('tr') )
				.remove()
				.draw();
});

	$('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

	function perbarui(){
		var d_shipping_charges = $('#d_shipping_charges').val();
		$.ajax({
			type: 'get',
			data: $('#dataedit').serialize(),
			dataType: 'json',
			url: baseUrl + '/project/pengirimanbarang/perbarui',
			success : function(result){
				iziToast.success({
          icon: 'fa fa-check',
          message: 'Berhasil Diproses!',
        });
        setTimeout(function () {
                      window.location.href = baseUrl + '/project/pengirimanbarang/pengirimanbarang';
                  }, 1000);
			}
		});
	}
</script>
@endsection
