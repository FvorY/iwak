@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">	
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
				<li class="breadcrumb-item">Project Manajemen Pompa | SHS</li>
				<li class="breadcrumb-item"><a href="{{url('project/pilih_pengirimanbarang/pilih_pengirimanbarang')}}">Pengiriman Barang</a></li>
				<li class="breadcrumb-item active" aria-current="page">Process Pengiriman Barang Pompa</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Process Pengiriman Barang Pompa</h4>
                  
                	<div class="row">
                		<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
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
		                				<input type="text" readonly="" class="form-control form-control-sm" value="Bravo">
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
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Work Order</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" value="Project Manajemen Pompa">
		                			</div>
		                		</div>
		                		
		                	</div>
	                	</div>
	                	<div class="col-md-6 col-sm-12 col-xs-12">
                			<div class="row">
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Date</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="08-04-2018">
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
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<label>Ship to</label>
		                		</div>
		                		<div class="col-md-6 col-sm-6 col-xs-12">
		                			<div class="form-group">
		                				<input type="text" readonly="" class="form-control form-control-sm" name="" value="Surabaya">
		                			</div>
		                		</div>
		                	</div>
	                	</div>
	                	
			              	<div class="col-md-6 col-sm-12 col-xs-12">
			              		<div class="row">
					              	<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Delivery Date</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<div class="input-group">
						                        <input class="form-control datepicker" readonly="" type="text" style="cursor: pointer;">
						                        <span class="input-group-addon bg-info text-white">
						                            <i class="fa fa-calendar"></i>
						                        </span>
					                        </div>
				            			</div>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Weight</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<input type="text" class="form-control form-control-sm">
				            			</div>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<label>Shipping Charges</label>
				            		</div>
				            		<div class="col-md-6 col-sm-6 col-xs-12">
				            			<div class="form-group">
				            				<input type="text" class="form-control form-control-sm">
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
	                  		</tr>
	                  	</tbody>
	                  </table>
	              </div>

	              <div class="row">
	              	<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
	              		<button class="btn btn-sm btn-info" type="button">Process</button>
	              		<a href="{{url('projectmp/pmp_pengirimanbarang/pmp_pengirimanbarang')}}" class="btn btn-secondary btn-sm">Back</a>
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
	
</script>
@endsection