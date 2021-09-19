@extends('main')
@section('content')


@include('projectms.shs_pengadaanbarang.detail_shs_pengadaanbarang')


<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">	
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Project Manajemen Pompa | SHS</li>
				<li class="breadcrumb-item"><a href="{{url('project/pilih_pengadaanbarang/pilih_pengadaanbarang')}}">Pengadaan Barang</a></li>
				<li class="breadcrumb-item active" aria-current="page">Pengadaan Barang SHS</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengadaan Barang SHS</h4>
                  <div class="row">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
							    <button type="button" class="close" data-dismiss="alert">&times;</button>
							    <strong>Notice!</strong> <br>
							    <label class="badge badge-pill badge-primary">1</label>
							    Check
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="alert alert-warning alert-dismissible" title="DP belum Lunas">
							    <button type="button" class="close" data-dismiss="alert">&times;</button>
							    <strong>Notice!</strong> <br>
							    <label class="badge badge-pill badge-warning">1</label>
							    Uncheck
							</div>
						</div>
					</div>
	            	<div class="table-responsive">
	                  <table class="table data-table table-hover" cellspacing="0" id="chieftain_mk5">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>No</th>
	                  			<th>Date</th>
	                  			<th>W.O.#</th>
	                  			<th>Customer</th>
	                  			<th>Item</th>
	                  			<th>Status</th>
	                  			<th>Action</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<tr>
	                  			<td>1</td>
	                  			<td></td>
	                  			<td>B001</td>
	                  			<td>Alpha</td>
	                  			<td><button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#detail_item">2</button></td>
	                  			<td>
	                  				<span class="badge badge-pill badge-success">Check</span>
	                  			</td>
	                  			<td>
	                  				<div class="btn-group">
	                  					<a class="btn btn-info btn-sm" href="{{url('projectms/shs_pengadaanbarang/shs_prosespengadaanbarang')}}" title="Process"><i class="fa fa-sign-in"></i></a>
	                  					<button class="btn btn-danger btn-sm" type="button" title="Delete"><i class="fa fa-trash-o"></i></button>
	                  				</div>
	                  			</td>
	                  		</tr>
	                  		<tr>
	                  			<td>2</td>
	                  			<td></td>
	                  			<td>B002</td>
	                  			<td>Bravo</td>
	                  			<td><button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#detail_item">2</button></td>
	                  			<td>
	                  				<span class="badge badge-pill badge-warning">Uncheck</span>
	                  			</td>
	                  			<td>
	                  				<div class="btn-group">
	                  					<a class="btn btn-info btn-sm" href="{{url('projectms/shs_pengadaanbarang/pmp_prosespengadaanbarang')}}" title="Process"><i class="fa fa-sign-in"></i></a>
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