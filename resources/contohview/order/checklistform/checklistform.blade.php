
@extends('main')

@section('content')

@include('order.checklistform.checklist')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Order</li>
					<li class="breadcrumb-item active" aria-current="page">Checklist Form</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Checklist Form</h4>
		          	<div class="row">
		          		
						<div class="table-responsive">
							<table class="table table-hover data-table" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>Tanggal</th>
							      <th>S.O.#</th>
							      <th>Vendor</th>
							      <th>Status</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							    	<td>1</td>
							    	<td>20-02-2018</td>
							    	<td>106-107/SO/SWP/PS2 1800 5-12/02/18/ATON</td>
							    	<td>Alpha</td>
							    	<td><div class="badge badge-gradient-warning badge-pill">Unprocessed</div></td>
							    	<td>
							    		<div class="btn-group">
								    		<button class="btn btn-info" data-target="#check" data-toggle="modal">Process</button>
								    		<a href="{{url('order/checklistform/print_checklistform')}}" target="_blank" class="btn btn-primary btn-sm" title="Print"><i class="fa fa-print"></i></a>
								    		<a href="#" class="btn btn-danger" title="Delete"><i class="mdi mdi-delete"></i></a>
								    	</div>
							    	</td>
							    </tr>
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