@extends('main')
@section('content')
<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Order</li>
				<li class="breadcrumb-item">Sales Order</li>
				<li class="breadcrumb-item active" aria-current="page">Process Sales Order</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
      	<div class="card">
	        <div class="card-body">
	          	<h4 class="card-title">Sales Order</h4>
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<label>W.O.#</label>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="text" readonly="" class="form-control-sm form-control so_nota" value="{{ $data->wo_nota }}" name="so_nota">
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
												<th>Before Tax</th>
												<th>Tax</th>
			                  <th>Line Total</th>
			                </tr>
			              </thead>
			              <tbody>
			                @foreach($data_dt as $i=>$val)
			                <tr>
			                	<td>{{$val->i_code}} - {{ $val->i_name }}</td>
			                	<td>{{ $val->qd_qty }}</td>
			                	<td>{{ $val->u_unit }}</td>
												@if ($val->qd_description == 'null')
														<td></td>
												@else
													<td>{{ $val->qd_description }}</td>
												@endif
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
				                <input value="{{ 'Rp. '. number_format($data->q_subtotal, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" value="600000" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Sales Tax</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_tax, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" value="100000" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Total</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_total, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" value="700000" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>DP</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_dp, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" value="700000" readonly="">
				              </div>
				            </div>
				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Select Payment</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <select class="form-control" disabled="">
				                  <option @if($data->wo_method == 'tunai') selected="" @endif value="tunai">Tunai</option>
				                  <option @if($data->wo_method == 'transfer') selected="" @endif value="transfer">Transfer</option>
				                </select>
				              </div>
				            </div>

				            <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
				              <label>Remaining Balance</label>
				            </div>
				            <div class="col-md-2 col-sm-6 col-xs-12">
				              <div class="form-group">
				                <input value="{{ 'Rp. '. number_format($data->q_remain, 2, ",", ".") }}" type="text" class="form-control form-control-sm" name="" readonly="" value="0">
				              </div>
				            </div>
				            <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
					            <a onclick="printing('{{$id}}')" style="color:white"  class="btn btn-info" target="_blank"><i class="fa fa-print"></i>Print</a>
					            <a href="{{url('order/salesorder/s_order')}}" class="btn btn-secondary">Back</a>
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
function printing(id) {
	iziToast.show({
        overlay: true,
        close: false,
        timeout: 20000,
        color: 'dark',
        icon: 'fas fa-question-circle',
        title: 'Print Data!',
        message: 'Apakah Anda Yakin ?!',
        position: 'center',
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
          [
            '<button style="background-color:#32CD32;">Print</button>',
            function (instance, toast) {
              window.open("{{ url('/order/workorder/print_workorder') }}"+"/"+id )
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
