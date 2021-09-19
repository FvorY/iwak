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
					<li class="breadcrumb-item active" aria-current="page">Payment</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          	<h4 class="card-title">Payment</h4>
		          	<div class="row">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
							    <button type="button" class="close" data-dismiss="alert">×</button>
							    <strong>Notice!</strong> <br>
							    Untuk Merubah History Payment Order, Dapat Dilihat Di Proforma Invoice.
							</div>
						</div>
					</div>
		          	<div class="row">
						<div class="table-responsive">
							<table class="table table-hover" id="table_quote" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
									<th>No</th>
									<th>Q.O.#</th>
									<th>Customer</th>
									<th>Total Bill</th>
									<th>DP</th>
									<th>Remain</th>
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
</div>

@include('order.payment_order.modalpembayaran')
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
var tablepembayaran;
$(document).ready(function(){
	tablepembayaran = $('#tablepembayaran').DataTable({
		dom: 'Bfrtip',
		title: '',
		buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
		],
	});
	$('#table_quote').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
          url:'{{ route('datatable_payment_order') }}',
      },
      columnDefs: [

              {
                 targets: 0 ,
                 className: 'center'
              },
              {
                 targets: 1 ,
                 className: 'q_nota'
              },
              {
                 targets: 3,
                 className: 'right'
              },
              {
                 targets: 4,
                 className: 'right'
              },
              {
                 targets: 5,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'center'
              },
            ],
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index'},
        {data: 'q_nota', name: 'q_nota'},
        {data: 'c_name', name: 'c_name'},
        {data: 'total', name: 'total'},
        {data: 'dp', name: 'dp'},
        {data: 'remain', name: 'remain'},
        {data: 'status', name: 'status'},
        {data: 'aksi', name: 'aksi'},

      ]
	});
})

function showpembayaran(id){
	tablepembayaran.clear();
	var html = "";
	var total = 0;
	$.ajax({
		type: 'get',
		data: {id},
		dataType: 'json',
		url: baseUrl + '/order/payment_order/detailpemayaran',
		success : function(response){
			tablepembayaran.clear();
			for (var i = 0; i < response.length; i++) {
				if (i == 0) {
					tablepembayaran.clear();
				} else if (i == 1) {
					tablepembayaran.row.add([
						'DP '+i,
						'Rp. '+get_currency(response[i].po_dp),
						response[i].po_pay
					]).draw(false);

					total += parseInt(response[i].po_dp);
				} else {
					tablepembayaran.row.add([
						'DP '+i,
						'Rp. '+get_currency(response[i].po_total),
						response[i].po_pay
					]).draw(false);

					total += parseInt(response[i].po_total);
				}
			}
			$('#total').text('Rp. '+get_currency(total));
			$('#noqo').text(response[0].po_ref);
			$('#noqo').attr('colspan', '3');
			$('#2clm').css('display', 'none');
			$('#3clm').css('display', 'none');
			$('#pembayaran').modal('show');
		}
	});
}
</script>
@endsection
