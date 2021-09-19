@extends('main')

@section('extra_styles')
<style type="text/css">
	.float-left{
		float: left;
	}
	.float-right{
		float: right;
	}
</style>
@endsection
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Order</li>
					<li class="breadcrumb-item active" aria-current="page">Sales Invoice</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Sales Invoice</h4>

		          	<div class="">
		          		<div class="table-responsive">
		          			<table class="table table-hover table-bordered data-table" cellspacing="0">
		          				<thead class="bg-gradient-info">
		          					<tr>
		          						<th>No</th>
		          						<th>S.I.#</th>
													<th>Q.O.#</th>
		          						<th>Customer</th>
		          						<th>Total Bill</th>
		          						<th>DP</th>
		          						<th>Payment</th>
		          						<th>Status</th>
		          						<th>Action</th>
		          					</tr>
		          				</thead>
		          				<tbody>
													@foreach ($data as $key => $value)
														<tr>
				          						<td>{{$key + 1}}</td>
				          						<td>{{$value->si_nota}}</td>
															<td>{{$value->si_ref}}</td>
				          						<td>{{$value->c_name}}</td>
				          						<td>
				          							<span class="float-left">Rp.</span>
				          							<span class="float-right">{{number_format($value->q_total,2,',','.')}}</span>
				          						</td>
				          						<td>
				          							<span class="float-left">Rp.</span>
				          							<span class="float-right">{{number_format($value->q_dp,2,',','.')}}</span>
				          						</td>
				          						<td>
				          							{{$value->q_shipping_method}}
				          						</td>
				          						<td>
				          							<span class="badge badge-success badge-pill">paid off</span>
				          						</td>
				          						<td>
				          							<div class="btn-group btn-group-xs">
				          								<a href="{{url('order/s_invoice/detail_s_invoice')}}?id={{$value->si_id}}" class="btn btn-info">Detail</a>
					          							<a href="{{url('order/s_invoice/print_salesinvoice')}}?id={{$value->q_id}}&status=no" title="Print Without Tax" target="_blank" class="btn btn-primary" title="Print"><i class="fa fa-print"></i></a>
																	<a href="{{url('order/s_invoice/print_salesinvoice')}}?id={{$value->q_id}}&status=yes" title="Print With Tax" target="_blank" class="btn btn-success" title="Print"><i class="fa fa-print"></i></a>
					          						</div>
				          						</td>
				          					</tr>
													@endforeach
		          				</tbody>
		          			</table>
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

@endsection
