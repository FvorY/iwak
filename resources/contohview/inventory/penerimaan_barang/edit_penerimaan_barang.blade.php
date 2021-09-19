@extends('main')
@section('content')
<form id="form-save">
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Inventory</li>
					<li class="breadcrumb-item"><a href="{{url('inventory/penerimaan_barang/penerimaan_barang')}}">Penerimaan Barang</a></li>
					<li class="breadcrumb-item active" aria-current="page">Process Penerimaan Barang</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Process Penerimaan Barang</h4>
					<div class="row">

						{{-- hidden --}}

							<input type="hidden" name="nota" value="{{ $id }}">

						{{-- end --}}

				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Kode Vendor</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm readonly" value="{{ $header_penerimaan->pb_vendor }}" name="pb_vendor">
				      </div>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Vendor Name</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm readonly" value="{{ $header_penerimaan->s_company }} - {{ $header_penerimaan->s_name }}" name="">
				      </div>
				    </div>

				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>No Delivery Order</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm" placeholder="Isi Surat Jalan" name="pb_delivery_order">
				      </div>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Date of Receipt</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm datepicker" value="" placeholder="Isi Tanggal" name="pb_date">
				      </div>
				    </div>

				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>No P.O.#</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm readonly" value="{{ $header_penerimaan->pb_ref }}" name="pb_ref">
				      </div>
				    </div>

				    <div class="table-responsive " style="margin-top: 15px;">
				      <table class="table table-hover data-table">
				        <thead class="bg-gradient-info">
				          <tr>
				            <th>No</th>
				            <th>Item Name</th>
				            <th>Unit</th>
				            <th>Amount Sent</th>
				            <th>Amount Received</th>
				            <th>Remains</th>
				          </tr>
				        </thead>
				        <tbody>
			        	@foreach ($seq_penerimaan as $a)
			        		<tr>
				            <td><input type="hidden" class="form-control form-control-sm" value="{{ $a->i_price }}" name="po_harga[]">{{ $a->pbdt_id }}</td>
				            <td><input type="hidden" class="form-control form-control-sm po_item" value="{{ $a->i_code }}" name="po_item[]">{{$a->i_code}} - {{ $a->i_name }}</td>
				            <td><input type="hidden" class="form-control form-control-sm po_id" value="{{ $a->pbdt_id }}" name="po_id[]">{{ $a->u_unit }}</td>
				            <td><input type="text" class="form-control form-control-sm qty_approved right readonly" value="{{ $a->pbdt_qty_sent }}" name="qty_approved[]"></td>
				            <td><input type="text" class="form-control form-control-sm qty_received right format_money_kosongan" value="{{ $a->pbdt_qty_received }}" onkeyup="qty_received(this);" name="qty_received[]"></td>
				            <td><input type="text" class="form-control form-control-sm qty_remain right readonly" value="{{ $a->pbdt_qty_remains }}" name="qty_remain[]"></td>
				          </tr>
			        	@endforeach
				        </tbody>
				      </table>
				    </div>



		      	</div>
		      <div class="pull-right" style="margin-top: 10px">
				<button type="button" class="btn btn-info btn-sm" onclick="save_data()" >Save Data</button>
				<a href="{{url('inventory/penerimaan_barang/penerimaan_barang')}}" class="btn btn-secondary btn-sm">Back</a>
			  </div>
	    	</div>

		</div>
	</div>
</div>
</div>
</form>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">

	function qty_received(a) {
    var par   = $(a).parents('tr');
    var qty_received = $(par).find('.qty_received').val();
    var qty_approved = $(par).find('.qty_approved').val();
		if (parseInt(qty_received) > parseInt(qty_approved) ) {
			iziToast.warning({
	            icon: 'fa fa-times',
	            message: 'Qty Melebihi Batas MAX!',
	          });
			$(par).find('.qty_received').val(0);
		}

	}

	function save_data(){

		 $.ajax({
           type: "get",
             url: '{{ route('update_penerimaan_barang') }}',
             data:$('#form-save').serialize(),
             success: function(data){

              iziToast.success({
                icon: 'fas fa-check-circle',
                message: 'Data Telah Tersimpan!',
              });

							setTimeout(function () {
								// window.location.href= '{{ route('penerimaan_barang') }}';
							}, 1000);

             },
             error: function(){
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!',
              });
             },
             async: false
           });
	}
	var check = 0;
	// function centang(){
	// 	var check = 0;
	// 		if ($('.checkbox').is(':checked')) {
	// 				var count = $('#jumlah').val();
	// 				for (var i = 0; i < count; i++) {
	// 					var qtyapproved = $('.qty_approved'+i).val();
	// 					$('.qty_received'+i).val(qtyapproved);
	// 					$('.qty_remain'+i).val(0);
	// 				}
	// 			}
	// 	}

</script>
@endsection
