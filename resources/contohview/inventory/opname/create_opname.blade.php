@extends('main')
@section('content')

<style type="text/css">

	.right-border{
		border-right: white 1px solid;
	}

</style>

<form id="form-save">
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Inventory</li>
					<li class="breadcrumb-item"><a href="{{route('stockopname')}}">Stock Opname</a></li>
					<li class="breadcrumb-item active" aria-current="page">Process Stock Opname</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Process Stock Opname</h4>
					<div class="row">

				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Kode Opname</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm readonly" value="{{ $nota }}" name="so_code" id="so_code">
				      </div>
				    </div>


				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Item</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				      	<select class="form-control" name="so_item" id="so_item">
				      		<option>- Pilih -</option>
				      		<optgroup label="All">
				      			<option value="all">Show All</option>
				      		</optgroup>
				      		<optgroup label="Item">
				      			@foreach ($item as $e)
				      				<option value="{{ $e->i_code }}">{{ $e->i_code }} - {{ $e->i_name }}</option>
				      			@endforeach
				      		</optgroup>

				      	</select>
				      </div>
				    </div>

				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <label>Date of Receipt</label>
				    </div>
				    <div class="col-md-3 col-sm-6 col-xs-12">
				      <div class="form-group">
				        <input type="text" class="form-control form-control-sm datepicker_today" id="so_date" name="so_date">
				      </div>
				    </div>

				    </div>
				    <div class="table-responsive" style="margin-top: 15px;">
				      <table class="table table-hover data-table">
				        <thead class="bg-gradient-info">
					        <tr>
				                <th rowspan="2" class="right-border" style="width: 15px;">No</th>
				                <th rowspan="2" class="right-border" width="150px">Item</th>
				                <th rowspan="2" class="right-border" width="100px">Unit</th>
				                <th colspan="2" class="right-border">Stock Item</th>
				                <th colspan="2" class="right-border">Stock difference</th>
				                <th rowspan="2" class="right-border">Description</th>
				            </tr>
				            <tr>
				                <th class="right-border" style="width: 60px;">Stock Sistem</th>
				                <th class="right-border" style="width: 60px;">Stock Real</th>
				                <th class="right-border" style="width: 100px;">Status Item</th>
				                <th class="right-border" style="width: 60px;">Status Total</th>
				            </tr>
				        </thead>
				        <tbody id="replace">
			        		 @foreach ($data as $index => $a)
							  <tr>
						        <td>{{ $index+1 }}</td>
						        <td><input type="hidden" name="so_item[]" value="{{ $a->i_code }}">{{ $a->i_name }}</td>
						        <td>{{ $a->i_unit }}</td>

						        <td><input type="text" name="so_system[]" value="{{ $a->sg_qty }}" class="form-control right stock_system" readonly=""></td>
						        <td><input type="text" name="so_real[]" class="form-control stock_real format_money_kosongan right" value="0" onkeyup="stock_real(this)"></td>
						        <td><input type="text" name="so_status_item[]" class="form-control status_item" readonly=""></td>
						        <td><input type="text" name="so_status_total[]" class="form-control right status_total" readonly=""></td>
						        <td><input type="text" name="so_description[]" class="form-control" ></td>
						      </tr>
						    @endforeach
				        </tbody>
				      </table>
				    </div>



		      <div class="pull-right" style="margin-top: 10px">
				<button type="button" class="btn btn-info btn-sm" onclick="save_data()" >Save Data</button>
				<a href="{{route('stockopname')}}" class="btn btn-secondary btn-sm">Back</a>
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

	$('#so_item').change(function(){
		var id = $(this).find(':selected').val();
		 $.ajax({
	         type: "get",
	         url: '{{ route('cari_stockopname') }}',
	         data: {id},
	         success: function(data){
	           $('#replace').html(data);
	         },
	         error: function(){
	          iziToast.warning({
	            icon: 'fa fa-times',
	            message: 'Terjadi Kesalahan!',
	          });
	         },
	         async: false
	    });
	})

	function stock_real(a) {
     var par   = $(a).parents('tr');
     var stock_real = $(par).find('.stock_real').val();
     var stock_system = $(par).find('.stock_system').val();
     var status_item = $(par).find('.status_item').val();
     var status_total = $(par).find('.status_total').val();

     if (parseFloat(stock_real) > parseFloat(stock_system)) {
     	$(par).find(".status_item").val('LEBIH');
     	var hitung = parseFloat(stock_real)-parseFloat(stock_system);
     	$(par).find(".status_total").val(hitung);
     }else if (parseFloat(stock_real) == parseFloat(stock_system)){
     	$(par).find(".status_item").val('SAMA');
     	var hitung = 0;
     	$(par).find(".status_total").val(hitung);
     }else{
     	$(par).find(".status_item").val('KURANG');
     	var hitung = parseFloat(stock_system)-parseFloat(stock_real);
     	$(par).find(".status_total").val(hitung);
     }
	}

	function save_data() {

		iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Important!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
              [
                '<button style="background-color:#44d7c9;">Process</button>',
                function (instance, toast) {
								waitingDialog.show();
                  $.ajax({
			         type: "get",
			         url: '{{ route('save_stockopname') }}',
			         data: $('#form-save').serialize(),
			         success: function(data){
			          iziToast.success({
			            icon: 'fa fa-times',
			            message: 'Data Tersimpan!',
			          });
								setTimeout(function () {
									window.location.reload();
								}, 1000);
			         },
			         error: function(){
			          iziToast.warning({
			            icon: 'fa fa-times',
			            message: 'Terjadi Kesalahan!',
			          });
								setTimeout(function () {
									window.location.reload();
								}, 1000);			
			         },
			         async: false
			    });



                }
              ],
              [
                '<button style="background-color:red;">Cancel</button>',
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
