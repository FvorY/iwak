@extends('main')
@section('content')

@include('projectmp/pmp_pengirimanbarang/pmp_editpengirimanbarang')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">	
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Project Manajemen Pompa | SHS</li>
				<li class="breadcrumb-item"><a href="{{url('project/pilih_pengirimanbarang/pilih_pengirimanbarang')}}">Pengiriman Barang</a></li>
				<li class="breadcrumb-item active" aria-current="page">Pengiriman Barang Pompa</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengiriman Barang Pompa</h4>

                  <div class="table-responsive">
	                  <table class="table data-table table-hover" cellspacing="0">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>No</th>
	                  			<th>Delivery Date</th>
	                  			<th>Customer</th>
	                  			<th>Address</th>
	                  			<th>Status</th>
	                  			<th title="Tanggal Terima">Date of Receipt</th>
	                  			<th>Action</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<tr>
	                  			<td>1</td>
	                  			<td>13-05-2018</td>
	                  			<td>Alpha</td>
	                  			<td>Jl. Alpha</td>
	                  			<td><span class="badge badge-pill badge-success">Delivered</span></td>
	                  			<td>16-05-2018</td>
	                  			<td>
	                  				<div class="btn-group">
	                  					<button class="btn btn-danger btn-sm" disabled="" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>
	                  				</div>
	                  			</td>
	                  		</tr>
	                  		<tr>
	                  			<td>2</td>
	                  			<td>16-05-2018</td>
	                  			<td>Bravo</td>
	                  			<td>Jl. Bravo</td>
	                  			<td><span class="badge badge-pill badge-primary">Process Delivery</span></td>
	                  			<td>-</td>
	                  			<td>
	                  				<div class="btn-group">
	                  					<button data-target="#edit" data-toggle="modal" data class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>
	                  					<button class="btn btn-danger btn-sm" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>
	                  				</div>
	                  			</td>
	                  		</tr>
	                  		<tr>
	                  			<td>3</td>
	                  			<td>-</td>
	                  			<td>Charlie</td>
	                  			<td>Jl. Charlie</td>
	                  			<td><span class="badge badge-pill badge-warning">Process</span></td>
	                  			<td>-</td>
	                  			<td>
	                  				<div class="btn-group">
	                  					<a href="{{url('projectmp/pmp_pengirimanbarang/pmp_prosespengirimanbarang')}}" class="btn btn-info btn-sm" title="Process"><i class="fa fa-sign-in"></i></a>
	                  					<button class="btn btn-danger btn-sm" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>
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
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

@endsection