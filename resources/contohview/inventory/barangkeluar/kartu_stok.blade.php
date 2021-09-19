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
					<li class="breadcrumb-item"><a href="{{route('barangkeluar')}}">Barang Keluar</a></li>
					<li class="breadcrumb-item active" aria-current="page">Kartu Stok</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
			<form id="formsimpan">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Kartu Stok</h4>
		          	<div class="row">

		          		<div class="col-md-3 col-sm-6 col-xs-12">
		          			<label>Card No</label>
		          		</div>

		          		<div class="col-md-9 col-sm-6 col-xs-12">
		          			<div class="form-group form-group-sm">
		          				<input type="text" class="form-control" readonly="" value="{{$finalkode}}" name="pb_code">
		          			</div>
		          		</div>

		          		<div class="col-md-3 col-sm-6 col-xs-12">
		          			<label>Date</label>
		          		</div>

		          		<div class="col-md-9 col-sm-6 col-xs-12">
		          			<div class="form-group form-group-sm">
		          				<input type="text" class="form-control datepicker" id="date" value="{{date('d-m-Y')}}" name="pb_date">
		          			</div>
		          		</div>

		          		<div class="col-md-3 col-sm-6 col-xs-12">
		          			<label>Receive From</label>
		          		</div>

		          		<div class="col-md-9 col-sm-6 col-xs-12">
		          			<div class="form-group form-group-sm">
		          				<textarea class="form-control" id="receive" name="d_receive_from"></textarea>
		          			</div>
		          		</div>

		          		<fieldset class="fieldset">
		          			<div class="row">
			          			<div class="col-md-3 col-sm-12">
			          				<div class="row">
			          					<div class="col-lg-12">
					          				<label>Item Code</label>
					          			</div>
					          			<div class="col-lg-12">
					          				<div class="form-group form-group-sm">
					          					<input type="text" class="form-control" readonly="" value="{{$item[0]->i_code}}" id="item_code" name="pbd_item">
					          				</div>
					          			</div>
				          			</div>
			          			</div>
			          			<div class="col-md-7 col-sm-12">
			          				<div class="row">
			          					<div class="col-lg-12">
					          				<label>Item Name</label>
					          			</div>
					          			<div class="col-lg-12">
					          				<div class="form-group form-group-sm">
					          					<input type="text" class="form-control" readonly="" value="{{$item[0]->i_name}}" id="item_name" name="itemname">
					          				</div>
					          			</div>
				          			</div>
			          			</div>
			          			<div class="col-md-2 col-sm-12">
			          				<div class="row">
			          					<div class="col-lg-12">
					          				<label>Qty Out</label>
					          			</div>
					          			<div class="col-lg-12">
					          				<div class="form-group form-group-sm">
					          					<input type="number" min="0" class="form-control" id="qty" name="">
					          				</div>
					          			</div>
				          			</div>
			          			</div>
			          		</div>
		          		</fieldset>

		          		<h4 class="ml-3 mt-2 mb-3">History Stock Mutation</h4>

						<div class="table-responsive mb-3">
							<table class="table table-hover table-striped table-bordered" id="tabel_history" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							    	<th>Date</th>
							    	<th>No Reff</th>
							    	<th>In</th>
							    	<th>Out</th>
							    	<th>Remain</th>
										<th>Description</th>
							    </tr>
							  </thead>
							  <tbody>
									@foreach ($mutasi as $key => $value)
										<tr>
											<td>{{Carbon\Carbon::parse($value->sm_insert)->format('d-m-Y h:m:i:s')}}</td>
											<td>{{$value->sm_ref}}</td>
											<td>{{$value->sm_qty}}</td>
											<td>{{$value->sm_use}}</td>
											<td>{{$value->sm_sisa}}</td>
											<td>{{$value->sm_description}}</td>
										</tr>
									@endforeach
							  </tbody>
							</table>
						</div>

						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered" id="tabel_kartu_stok" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							    	<th>Date</th>
							    	<th>Receive From</th>
							    	<th>Out</th>
										<th width="1%"></th>
							    </tr>
							  </thead>
							  <tbody id="showkartu">

							  </tbody>
							</table>
						</div>
						<div class="content-footer">
							@if (App\mMember::akses('PENGELUARAN BARANG', 'tambah')) 
							<button class="btn btn-primary btn-simpan" onclick="simpan()" type="button">Save</button>
							@endif
							<a href="{{route('barangkeluar')}}" class="btn btn-secondary">Back</a>
						</div>
		        	</div>
		      	</div>
	    	</div>
			</form>
		</div>
	</div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
	// var tabel = $('#tabel_kartu_stok').DataTable({
	// 	"pageLength": 10,
 //        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
 //        "language": {
 //            "searchPlaceholder": "Search",
 //            "sSearch": '<i class="fa fa-search"></i>'
 //           }
	// });
	$('#tabel_history').DataTable({
		"pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Search",
            "sSearch": '<i class="fa fa-search"></i>'
           }
	});

	$('#tabel_kartu_stok').DataTable({
		"pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Search",
            "sSearch": '<i class="fa fa-search"></i>'
           }
	});

	function tabel_append(){
		var newDate = new Date();
		var date = newDate.getDate();
		var month = newDate.getMonth()+1;
		var year = newDate.getFullYear();
		var tgl = date+'-'+month+'-'+year;

		// console.log(month);
		$('#showkartu').html('');
		$('#tabel_kartu_stok tbody').append(
			'<tr>'+
				'<td><input type="hidden" value="'+$('#date').val()+'" class="date"><span>'+$('#date').val()+'</span></td>'+
				'<td><input type="hidden" name="pbd_receive_from" value="'+$('#receive').val()+'" class="receive"><pre>'+$('#receive').val()+'</pre></td>'+
				'<td><input type="hidden" name="pbd_qty" value="'+$('#qty').val()+'" class="qty"><span>'+$('#qty').val()+'</span></td>'+
				'<td><button type="button" class="btn btn-warning btn-xs btn-edit" title="Edit"><i class="fa fa-pencil-alt"></i></button></td>'+
			'</tr>'
			);

		$('#qty').val('');
		$('#receive').val('');
		$('#date').datepicker('setDate', tgl);
		$('#qty').attr('disabled',true);


	}

	$(document).on('click', '.btn-edit', function(){
		var qty = $(this).parents('tr').find('.qty').val();
		var receive = $(this).parents('tr').find('.receive').val();
		var date = $(this).parents('tr').find('.date').val();

		$('#qty').attr('disabled', false);
		$('#date').datepicker('setDate',date);
		$('#receive').val(receive);
		$('#qty').val(qty);

		$(this).parents('tr').remove();
		$('html, body').animate({scrollTop:0}, 'slow');
	});

	$('#qty').on('keypress', function(e){
		if(e.which === 13 || e.keyCode === 13){
			tabel_append();
		}
	});

	function simpan(){
		waitingDialog.show();
			$.ajax({
				type: 'get',
				data: $('#formsimpan').serialize(),
				dataType: 'json',
				url: baseUrl + '/inventory/barangkeluar/simpankartu',
				success : function(result){
					if (result.status == 'berhasil') {
						iziToast.success({
							icon: 'fas fa-check-circle',
							message: 'Data Telah Tersimpan!',
						});
						setTimeout(function () {
							window.location.reload();
						}, 1000);
					} else if (result.status == 'stock kurang') {
						iziToast.warning({
							icon: 'fa fa-times',
							message: 'Stock Gudang Kurang!',
						});
						waitingDialog.hide();
					} else {
						iziToast.warning({
							icon: 'fa fa-times',
							message: 'Terjadi Kesalahan!',
						});
						waitingDialog.hide();
					}
			 }
			});
	}

</script>
@endsection
