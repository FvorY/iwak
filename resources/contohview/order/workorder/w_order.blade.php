@extends('main')
@section('content')
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Order</li>
  				<li class="breadcrumb-item active" aria-current="page">Work Order</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">
  	          <h4 class="card-title">Work Order</h4>

              <div class="row">
    						<div class="col-md-6 col-sm-12 col-xs-12">
    							<div class="alert alert-primary alert-dismissible" title="Released">
    							    <button type="button" class="close" data-dismiss="alert">&times;</button>
    							    <strong>Notice!</strong> <br>
    							    Released
    							    <label class="badge badge-pill badge-primary">{{$printed}}</label>
    							</div>
    						</div>
    						<div class="col-md-6 col-sm-12 col-xs-12">
    							<div class="alert alert-success alert-dismissible" title="Printed">
    							    <button type="button" class="close" data-dismiss="alert">&times;</button>
    							    <strong>Notice!</strong> <br>
    							    Printed
    							    <label class="badge badge-pill badge-success">{{$released}}</label>
    							</div>
    						</div>
    					</div>

    					<div class="table-responsive">
    						<table id="table_quote" class="table table-hover table-bordered " cellspacing="0">
    							<thead class="bg-gradient-info">
    								<tr>
    									<th>W.O.#</th>
    									<th>S.I.#</th>
    									<th>Customer</th>
    									<th>Total </th>
    									<th>Status</th>
    									<th>Action</th>
                    				</tr>
    							</thead>
    							<tbody>

    				            </tbody>
    						</table>
    					</div>

  	      	</div>
      	</div>
  	</div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>
$(document).ready(function(){
	$('#table_quote').DataTable({
      processing: true,
      serverSide: true,
      aaSorting: [],
      ajax: {
          url:'{{ route('datatable_wo') }}',
      },
      columnDefs: [
              {
                 targets: 3,
                 className: 'right'
              },
              {
                 targets: 4,
                 className: 'center'
              },
              {
                 targets: 5,
                 className: 'center'
              },
            ],
      columns: [
        {data: 'wo_nota', name: 'wo_nota'},
        {data: 'q_nota', name: 'q_nota'},
        {data: 'customer', name: 'customer'},
        {data: 'total', name: 'total'},
        {data: 'status', name: 'status'},
        {data: 'aksi', name: 'aksi'},

      ]

	});
})

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
