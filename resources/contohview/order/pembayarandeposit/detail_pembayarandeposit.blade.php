@extends('main')
@section('content')

@include('order.pembayarandeposit.pilihpembayaran')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Order</li>
				<li class="breadcrumb-item">Pembayaran Deposit</li>
				<li class="breadcrumb-item active" aria-current="page">Process Pembayaran Deposit</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
      	<div class="card">
	        <div class="card-body">
	          	<h4 class="card-title">Pembayaran Deposit</h4>
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>S.O.#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								@if($so->so_nota != null)
								<input type="text" readonly="" class="form-control-sm form-control so_nota" value="{{ $so->so_nota }}" name="so_nota">
								@else
								<input type="text" readonly="" class="form-control-sm form-control so_nota" value="{{ $nota_so }}" name="so_nota">
								@endif
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>W.O.#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								@if($wo->wo_nota != null)
								<input type="text" readonly="" class="form-control-sm form-control wo_nota" value="{{ $wo->wo_nota }}" name="wo_nota">
								@else
								<input type="text" readonly="" class="form-control-sm form-control wo_nota" value="{{ $nota_wo }}" name="wo_nota">
								@endif
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>Quote#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control form-control-sm" value="{{ $data->q_nota }}" name="">
							</div>
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
								<input type="text" readonly="" class="form-control-sm form-control" value="{{ carbon\carbon::parse($data->q_date)->format('d-m-Y') }}" name="">
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
					</div>
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
						    	<td>{{ $val->i_code }} - {{ $val->i_name }}</td>
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
			          	<form class="row detail_bayar">
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
													@if ($percent == null)
														<input type="text" class="form-control form-control-sm" name="dp" id="dp" readonly="" value="{{ 'Rp. '. number_format((0 / 100) * $data->q_total , 2, ",", ".") }}">
													@else
														<input type="text" class="form-control form-control-sm" name="dp" id="dp" readonly="" value="{{ 'Rp. '. number_format(($percent->p_percent / 100) * $data->q_total , 2, ",", ".") }}">
													@endif
				                @endif
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Log Payment</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				            	<div class="form-group">
				              		<button type="button" class="btn btn-primary btn-sm btn-block pilihpembayaran" data-toggle="modal" data-target="#pilihpembayaran">Detail</button>
				              	</div>
				            </div>

				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Remaining Balance</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				              	@if($data->q_remain != null)
				                <input value="{{'Rp. '. number_format($data->q_remain, 2, ",", ".")}}" type="text" class="form-control form-control-sm" name="remain" readonly="" id="remaining_dp">
												<input type="hidden" name="remaintmp" value="{{$data->q_remain}}">
										    @else
				                <input value="0" type="text" class="form-control form-control-sm" name="remain" readonly="" id="remaining_dp">
												<input type="hidden" name="remaintmp" value="0">
												@endif
				              </div>
				            </div>
				            <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
					            <a type="button" onclick="save_data()" class="btn btn-info" style="color: white">Save Data</a>
					            <a href="{{url('order/pembayarandeposit/pembayarandeposit')}}" class="btn btn-secondary">Back</a>
					        </div>
					    </form>
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
		var total = $('#total_harga').val();
		total     = total.replace(/[^0-9\-]+/g,"")/100;
		var tmppercent = $('input[name=percent]').val();
				tmppercent = tmppercent.replace(' %', '');

		var percent = tmppercent / 100 * total;

		$('#amount').val(accounting.formatMoney(percent,"", 0, ".",','));
		$('#batasamount').val(percent);
	});

	function save_detail(){

		var amount 	= $('#amount').val();
		amount     = amount.replace(/[^0-9\-]+/g,"");
		var dp     	= $('#dp');
		var remaining_dp = $('#remaining_dp');
		var total_harga = $('#total_harga').val();
		total_harga     = total_harga.replace(/[^0-9\-]+/g,"")/100;
		var limit = total_harga;
		if(amount > total_harga){
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Nominal Melebihi Total!',
	        });
	        return false;
		}
		var bayar_dp	= dp.val(accounting.formatMoney(amount,"Rp .", 2, ".",','));

		var hasil = total_harga - amount;

		remaining_dp.val(accounting.formatMoney(hasil,"Rp. ", 2, ".",','));
		$('#pilihpembayaran').modal('hide');
	}

	function amountup(){
		var amount = $('#amount').val();
		amount = amount.replace(/[^0-9\-]+/g,"");
		var batas = $('#batasamount').val();
		var remain = $('input[name=remaintmp]').val();
		var tmppercent = $('input[name=percent]').val();
		if (parseInt(amount) < parseInt(batas)) {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Tidak boleh kurang dari '+tmppercent+'!',
	        });

			$('#amount').val(accounting.formatMoney(batas,"", 0, ".",','));
		} else if (parseInt(amount) > parseInt(remain)) {			
			var lebih = parseInt(amount) - parseInt(remain);
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Nominal melebihi remain!',
	        });
			$('#amount').val(accounting.formatMoney(remain,"", 0, ".",','));
			$('#akunsisa').css('display', '');
			$('#labelakunsisa').css('display', '');
			$('input[name=lebih]').val(accounting.formatMoney(lebih,"", 0, ".",','));
		}
	}

	function save_data() {
		var amount 	= $('#dp').val();
		amount     = amount.replace(/[^0-9\-]+/g,"");
		var so_nota = $('.so_nota').val();
		var wo_nota = $('.wo_nota').val();
		var id = '{{ $id }}';
		var status_so = '{{ $so->so_status }}';
		var status_wo = '{{ $wo->wo_status }}';

		if (amount == 0 || amount == '') {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'DP Tidak Boleh 0',
	        });
	        return false;
		}

		// if (status_so == 'Printed' || status_wo == 'Printed') {
		// 	iziToast.warning({
	  //           icon: 'fa fa-info',
	  //           message: 'Data Telah Di Print',
	  //       });
	  //       return false;
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
				      url:baseUrl + '/order/pembayarandeposit/save_deposit',
				      data:$('.detail_bayar :input').serialize()+'&'+$('.log :input').serialize()+'&so_nota='+so_nota+'&id='+id+'&wo_nota='+wo_nota,
				      dataType:'json',
				      success:function(data){
				      	if (data.status == 1) {
				      		location.href = "{{ url('/order/pembayarandeposit/pembayarandeposit') }}";
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
