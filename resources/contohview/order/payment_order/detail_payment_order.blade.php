@extends('main')
@section('content')

@include('order.payment_order.pilihpembayaran')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Order</li>
				<li class="breadcrumb-item">Payment Order</li>
				<li class="breadcrumb-item active" aria-current="page">Process Payment Order</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
      	<div class="card">
	        <div class="card-body">
	          	<h4 class="card-title">Payment Order</h4>

	          		<form class="row detail_bayar">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Quote#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control form-control-sm" value="{{ $data->q_nota }}" name="q_nota">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Payment Order#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<input type="text" readonly="" class="form-control-sm form-control po_nota" value="{{ $nota_po }}" name="po_nota">
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Customer ID</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control-sm form-control" value="{{ $data->q_customer }}" name="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Order By</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control form-control-sm" value="{{ $market }}" name="">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Date</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control-sm form-control" value="{{ carbon\carbon::parse($data->q_date)->format('d-m-Y') }}" name="dates">
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Ship to</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
							  <input type="text" class="form-control form-control-sm" value="{{ $data->q_ship_to }}" readonly="" name="">
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-2 col-sm-6 col-xs-12">
							<label>Shipping Method</label>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control-sm form-control" readonly="" value="{{ $data->q_shipping_method }}" name="">
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<label>Shipping Terms</label>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control-sm form-control" readonly="" value="{{ $data->q_term }}" name="">
							</div>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<label>Delivery Date</label>
						</div>
						<div class="col-md-2 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control-sm form-control" readonly="" value="{{ carbon\carbon::parse($data->q_delivery)->format('d-m-Y') }}" name="">
							</div>
						</div>
					</div>
					<div class="table-responsive" style="margin-bottom: 15px;">
						<table class="table table-hover data-table" cellspacing="0">
						  <thead class="bg-gradient-info">
						    <tr>
						      <th>Item#</th>
						      <th>Qty</th>
						      <th>Unit</th>
						      <th>Description</th>
						      <th>Unit Price</th>
									<th>Line Before Tax</th>
									<th>Tax</th>
						      <th>Line Total</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data_dt as $i=>$val)
						    <tr>
						    	<td>{{$val->i_code}} - {{ $val->i_name }}</td>
						    	<td>{{ $val->qd_qty }}</td>
						    	<td>{{ $val->i_unit }}</td>
						    	<td>{{ $val->qd_description }}</td>
									<td>{{ 'Rp. '. number_format($val->qd_price, 2, ",", ".") }}</td>
									<td>{{ 'Rp. '. number_format($val->qd_beforetax, 2, ",", ".") }}</td>
									<td>{{ 'Rp. '. number_format($val->qd_tax, 2, ",", ".") }}</td>
						    	<td>{{ 'Rp. '. number_format($val->qd_total, 2, ",", ".") }}</td>
						    </tr>
						    @endforeach
						  </tbody>
						</table>
					</div>

			        <div class="row">

			          <div class="col-md-12 col-sm-12 col-xs-12">
			          	<div class="row">
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Subtotal</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input type="text" class="form-control form-control-sm" name="subtotal" value="{{ 'Rp. '. number_format($data->q_subtotal, 2, ",", ".") }}" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Sales Tax</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input type="text" class="form-control form-control-sm" name="tax" value="{{ 'Rp. '. number_format($data->q_tax, 2, ",", ".") }}" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Total</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input type="text" class="form-control form-control-sm" name="total" value="{{ 'Rp. '. number_format($data->q_total, 2, ",", ".") }}" readonly="" id="total_harga">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>DP</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                @if($data->q_dp != null)
				                <input type="text" class="form-control form-control-sm" name="dp" id="dp" readonly="" value="{{'Rp. '. number_format($data->q_dp, 2, ",", ".")}}">
				                @else
				                <input type="text" class="form-control form-control-sm" name="dp" id="dp" readonly="" value="0">
				                @endif
				              </div>
				            </div>

				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Payment Log</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				            	<div class="form-group">
				              		<button class="btn btn-primary btn-sm btn-block pilihpembayaran" data-toggle="modal" data-target="#pilihpembayaran">Detail</button>
				              	</div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Payment</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="0" type="text" class="form-control form-control-sm" name="payment" id="payment" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Total Paid</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_total - $data->q_remain, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="total_paid" id="total_paid" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Remaining</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_remain, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" readonly="" value="" id="remain">
												<input type="hidden" name="tmpremain" id="tmpremain" value="{{$data->q_remain}}">
				              </div>
				            </div>
				            <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
					            <a onclick="save_data()" class="btn btn-info" style="color: white">Save Data</a>
					            <a href="{{url('order/payment_order')}}" class="btn btn-secondary" >Back</a>
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
$('#amount').mask('000.000.000.000.000', {reverse: true});

	$('.pilihpembayaran').click(function(){
		var dp = $('#payment').val();
		dp     = dp.replace(/[^0-9\-]+/g,"")/100;
		var remain = $('input[name=tmpremain]').val();
		$('#amount').val(accounting.formatMoney(remain, "", 0, ".",','));
	});



	function save_detail(){
		var amount 		 = $('#amount').val();
		amount     		 = amount.replace(/[^0-9\-]+/g,"")*1;
		var payment      = $('#payment');
		var remain 		 = '{{ $data->q_remain }}'*1;
		var paid	 	 = '{{ $data->q_total - $data->q_remain }}'*1;
		var hasil 		 = remain - amount;
		var total_paid 	 = amount + paid;
		if (amount == 0) {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Amount Tidak Boleh 0!',
	        });

	        return false;
		}
		if (amount > remain) {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Amount Melebihi Remain!',
	        });

	        return false;
		}
		$('#payment').val(accounting.formatMoney(amount,"Rp. ", 2, ".",','));
		$('#remain').val(accounting.formatMoney(hasil,"Rp. ", 2, ".",','));
		$('#total_paid').val(accounting.formatMoney(total_paid,"Rp. ", 2, ".",','));

		$('#pilihpembayaran').modal('hide');
	}

	function save_data() {
		var amount 	= $('#payment').val();
		amount     = amount.replace(/[^0-9\-]+/g,"");
		var id = '{{ $id }}';

		if (amount == 0 || amount == '') {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Payment Tidak Boleh 0',
	        });
	        return false;
		}

		// function amountupp(){
		// 	var amount = $('#amount').val();
		// 	var remain = $('#tmpremain').val();
    //
		// 	amount = amount.replace(/[^0-9\-]+/g,"");
		// 	if (parseInt(amount) > parseInt(remain)) {
		// 		var lebih = parseInt(amount) - parseInt(remain);
		// 		iziToast.warning({
		// 						icon: 'fa fa-info',
		// 						message: 'Nominal melebihi remain!',
		// 				});
		// 		$('#amount').val(accounting.formatMoney(remain,"", 0, ".",','));
		// 		$('#akunsisa').css('display', '');
		// 		$('#labelakunsisa').css('display', '');
		// 		$('input[name=lebih]').val(accounting.formatMoney(lebih,"", 0, ".",','));
		// 	}
		// }

		iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Simpan Data!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
              [
                '<button style="background-color:#32CD32;">Save</button>',
                function (instance, toast) {

                  $.ajaxSetup({
				      headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
				    });

                  $.ajax({
				      url:baseUrl + '/order/payment_order/save_payment_order',
				      data:$('.detail_bayar :input').serialize()+'&'+$('.log :input').serialize()+'&id='+id,
				      dataType:'json',
				      success:function(data){
				      	if (data.status == 1) {
				      		location.href = "{{ url('/order/payment_order') }}";
				      	}else{
				      		iziToast.warning({
					            icon: 'fa fa-info',
					            message: 'Data Sudah Ada!',
					        });
				      	}

				      },error:function(){
			      		iziToast.warning({
				            icon: 'fa fa-info',
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
