@extends('main')
@section('content')

@include('projectmp.pmp_salescommon.tambah_sales')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">	
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Project Manajemen Pompa | SHS</li>
				<li class="breadcrumb-item"><a href="{{url('project/pilih_salescommon/pilih_salescommon')}}">Sales Common</a></li>
				<li class="breadcrumb-item active" aria-current="page">Sales Common Pompa</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sales Common Pompa</h4>
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                  	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                  </div>
                  <div class="table-responsive">
	                  <table class="table data-table table-hover" cellspacing="0">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>No</th>
	                  			<th>Company</th>
	                  			<th>Vendor Name</th>
	                  			<th>Address</th>
	                  			<th>Phone Number</th>
	                  			<th>Fax</th>
	                  			<th>Information</th>
	                  			<th>Limit</th>
	                  			<th>Action</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<tr>
	                  			<td>1</td>
	                  			<td>PT. Alpha</td>
	                  			<td>Alpha</td>
	                  			<td>Jl. Alpha</td>
	                  			<td>085123123123</td>
	                  			<td></td>
	                  			<td></td>
	                  			<td>1.500.000</td>
	                  			<td>
	                  				<button class="btn btn-outline-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>
	                  				<button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>
	                  			</td>

	                  		</tr>
	                  		<tr>
	                  			<td>2</td>
	                  			<td>PT. Bravo</td>
	                  			<td>Bravo</td>
	                  			<td>Jl. Bravo</td>
	                  			<td>085123123123</td>
	                  			<td></td>
	                  			<td></td>
	                  			<td>1.500.000</td>
	                  			<td>
	                  				<button class="btn btn-outline-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>
	                  				<button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>
	                  			</td>

	                  		</tr>
	                  		<tr>
	                  			<td>3</td>
	                  			<td>PT. Charlie</td>
	                  			<td>Charlie</td>
	                  			<td>Jl. Charlie</td>
	                  			<td>085331219757</td>
	                  			<td></td>
	                  			<td></td>
	                  			<td>1.500.000</td>
	                  			<td>
	                  				<button class="btn btn-outline-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>
	                  				<button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>
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