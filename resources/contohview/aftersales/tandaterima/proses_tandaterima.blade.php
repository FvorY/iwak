@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">After Sales Service</li>
					<li class="breadcrumb-item"><a href="{{url('aftersales/tandaterima/tandaterima')}}">Tanda Terima Service</a></li>
					<li class="breadcrumb-item active" aria-current="page">Process Tanda Terima Service</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Process Tanda Terima Service</h4>
		          	<div class="row">
                		<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">

                				<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>S.O.# / Q.O.#</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="QO-002/SWP/ACC/052018">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Customer</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="CUS/001">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Order By</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" value="Alpha">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Address</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<textarea class="form-control form-control-sm" readonly="">Jl. Alpha</textarea>
		                			</div>
		                		</div>
		                	</div>
	                	</div>
	                	<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Date Comes</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" class="form-control form-control-sm datepicker" name="">
		                			</div>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>W.O.#</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="B001">
		                			</div>
		                		</div>
		                	</div>
	                	</div>
                	</div>
					
                  <div class="table-responsive">
	                  <table class="table data-table table-hover" cellspacing="0">
	                  	<thead class="bg-gradient-info">
	                  		<tr>
	                  			<th>Item Code</th>
	                  			<th>Item Name</th>
	                  			<th>Qty</th>
	                  			<th>Unit</th>
	                  			<th>Checklist</th>
	                  			<th>Description of Damages</th>
	                  		</tr>
	                  	</thead>
	                  	<tbody>
	                  		<tr>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="BRG/001">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Cable">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="300">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Meter">
	                  			</td>
	                  			<td>
	                  				<div class="form-check form-check-flat">
			                            <label class="form-check-label">
			                              		<input class="form-check-input" type="checkbox">
			                          	</label>
			                        </div>
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control-sm form-control" name="">
	                  			</td>
	                  		</tr>
	                  		<tr>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="BRG/002">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Pompa Air">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="1">
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control form-control-sm" readonly="" name="" value="Pcs">
	                  			</td>
	                  			<td>
	                  				<div class="form-check form-check-flat">
			                            <label class="form-check-label">
			                              		<input class="form-check-input" type="checkbox">
			                          	</label>
			                        </div>
	                  			</td>
	                  			<td>
	                  				<input type="text" class="form-control-sm form-control" name="">
	                  			</td>
	                  		</tr>
	                  	</tbody>
	                  </table>
	              </div>
	              <div class="row">
	              	<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
	              		<button class="btn btn-sm btn-info" type="button">Save Data</button>
	              		<a href="{{url('aftersales/tandaterima/tandaterima')}}" class="btn btn-secondary btn-sm">Back</a>
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