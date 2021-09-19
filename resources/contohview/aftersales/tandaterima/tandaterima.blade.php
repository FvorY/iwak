@extends('main')
@section('content')

@include('aftersales/tandaterima/tambah_tandaterima')

@include('aftersales/tandaterima/detail_item')
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">After Sales Service</li>
					<li class="breadcrumb-item active" aria-current="page">Tanda Terima Service</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Tanda Terima Service</h4>
		          	<div class="row">
		          		
						<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
							<button class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
						</div>
						<div class="table-responsive">
							<table class="table table-hover data-table" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>Customer Name</th>
							      <th title="Tanggal Barang Datang">Date Comes</th>
							      <th title="S.O.# / Q.O.#">SN</th> <!-- S.O.# / W.O.# -->
							      <th>Address</th>
							      <th>Item</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							    	<td>1</td>
							    	<td>Alpha</td>
							    	<td>04-06-2018</td>
							    	<td>QO-002/SWP/ACC/052018</td>
							    	<td>Jl. Alpha</td>
							    	<td>
							    		<button type="button" data-toggle="modal" data-target="#detail" class="btn btn-outline-primary btn-sm">Detail</button>
							    	</td>
							    	<td>
							    		<div class="btn-group">
							    			<button class="btn btn-info btn-sm" type="button" title="Edit"><i class="fa fa-pencil-alt"></i></button>
							    			<button class="btn btn-danger btn-sm" type="button" title="Delete"><i class="fa fa-trash"></i></button>
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