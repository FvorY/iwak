@extends('main')
@section('content')


<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Inventory</li>
					<li class="breadcrumb-item active" aria-current="page">Barang Keluar</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Barang Keluar</h4>
		          	<div class="row">

						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered data-table" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							    	<th width="1%">No</th>
							    	<th>Item Code</th>
							    	<th>Item Name</th>
							    	<th>Unit</th>
							    	<th>Category</th>
							    	<th>Description</th>
							    	<th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
							    @foreach ($data as $key => $value)
							    	<tr>
							    		<td>{{$key + 1}}</td>
											<td>{{$value->i_code}}</td>
											<td>{{$value->i_name}}</td>
											<td>{{$value->u_unit}}</td>
											<td>{{$value->i_jenis}}</td>
											<td>{{$value->i_description}}</td>
											<td align="center">
												<div class="btn-group btn-group-sm">
							    			<a href="{{url('/inventory/barangkeluar/kartu_stok')}}?id={{encrypt($value->i_id)}}" title="Kartu Stok" class="btn btn-primary"><i class="fa fa-folder"></i></a>
												<a href="{{url('inventory/barangkeluar/print_kartu_stok')}}?id={{encrypt($value->i_code)}}" class="btn btn-primary" target="_blank" title="Print Kartu Stok"><i class="fa fa-print"></i></a>
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
