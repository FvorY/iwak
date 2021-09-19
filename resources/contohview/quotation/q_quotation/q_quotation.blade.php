@extends('main')
@section('content')

@include('quotation/q_quotation/tambah')

{{-- @include('master/customer/tambah') --}}

@include('quotation/q_quotation/detail')

@include('quotation/q_quotation/update_status')

@include('quotation/q_quotation/detail_status')

@include('quotation/q_quotation/tambah_customer')

<style type="text/css">
.ui-autocomplete {
	z-index: 99999999999;
}
</style>
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Quotation</li>
					<li class="breadcrumb-item active" aria-current="page">Quotation</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Quotation</h4>

						<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
							@if(Auth::user()->akses('QUOTATION','tambah'))
							<button class="btn btn-info open_modal" data-toggle="modal" data-target="#tambah" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create Quotation</button>
							@endif
						</div>

						<div class="row">
							<div class="col-md-4 col-sm-12 col-xs-12">
								<div class="alert alert-success alert-dismissible" title="Approved">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<strong>Notice!</strong> <br>
										<label class="badge badge-pill badge-success">{{$won}}</label>
										Won
								</div>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<div class="alert alert-primary alert-dismissible" title="Need Approved">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<strong>Notice!</strong> <br>
										<label class="badge badge-pill badge-primary">{{$printed}}</label>
										Printed
								</div>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<div class="alert alert-warning alert-dismissible" title="Need Approved">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<strong>Notice!</strong> <br>
										<label class="badge badge-pill badge-warning">{{$release}}</label>
										Release
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table table-hover" id="table_quote" cellspacing="0" width="100%">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>Quote#</th>
							      <th>Customer Item</th>
							      <th>Customer</th>
							      <th>Marketing</th>
							      <th>Total</th>
							      <th>Status</th>
							      <th>History Status</th>
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
					pagging: true,
					dom: 'Bfrtip',
	        title: '',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ],
          ajax: {
              url:'{{ route('quote_datatable') }}',
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
                     targets: 6,
                     className: 'center'
                  },
                ],
          columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index'},
            {data: 'q_nota', name: 'q_nota'},
            {data: 'detail', name: 'detail'},
            {data: 'customer', name: 'customer'},
            {data: 'mk_name', name: 'mk_name'},
            {data: 'total', name: 'total'},
            {data: 'status', name: 'status'},
            {data: 'histori', name: 'histori'},
            {data: 'aksi', name: 'aksi'},

          ]

    	});

})

$('.open_modal').click(function(){
	var m_table       = $("#apfsds").DataTable();
	m_table.clear().draw();
});

$('.q_qty').keyup(function(){

	var qty = $(this).val();
	qty = qty.replace(/[A-Za-z$. ,-]/g, "");

	$(this).val(qty);
})


function hitung_total() {
	var tax = $('#tax').val();
	var sub = $('#subtotal').val();

	tax = tax.replace(/[^0-9\-]+/g,"")/1;
	sub = sub.replace(/[^0-9\-]+/g,"")*1;

	$('#total').val(accounting.formatMoney(tax + sub, "", 0, ".",','))
}

$('#tax').keyup(function(){
	hitung_total();
})

function hitung_dpp() {
	var total = 0;
	$('.line_total').each(function(){
		var temp = $(this).val();
		temp 	 = temp.replace(/[^0-9\-]+/g,"")*1;
		total += temp;
	})
	$('#subtotal').val(accounting.formatMoney(total, "", 0, ".",','));
	hitung_total();
}


function qty(p) {
	var par  		= $(p).parents('tr');
	var unit_price  = $(par).find('.unit_price').val();
	unit_price 	    = unit_price.replace(/[^0-9\-]+/g,"")*1;
	var qty 	    = $(par).find('.jumlah').val();
	var tmpitem = $(par).find('.tmpitem').val();

	var total_price = unit_price * qty;

	if (tmpitem == 'BRG') {

		var beforetax = total_price / 1.1;

		var tax = parseInt(total_price) - parseInt(beforetax);

	} else {
		var tmp = data.data.i_sell_price * q_qty.val();

		var beforetax = total_price / 2.5;

		var tax = parseInt(total_price) - parseInt(beforetax);
	}

	$(par).find('.tax').val(parseInt(tax));
	$(par).find('.beforetax').val(parseInt(beforetax));

    $(par).find('.line_total').val(accounting.formatMoney(unit_price * qty, "", 0, ".",','));
    hitung_dpp();
		synctax();
}

function unit_price(p){
  var par     = $(p).parents('tr');
  var qty  = $(par).find('.jumlah').val();
  var unit_price       = $(par).find('.unit_price').val();
  unit_price      = unit_price.replace(/[^0-9\-]+/g,"")*1;
	var tmpitem = $(par).find('.tmpitem').val();

	var total_price = unit_price * qty;

	if (tmpitem == 'BRG') {

		var beforetax = total_price / 1.1;

		var tax = parseInt(total_price) - parseInt(beforetax);

	} else {
		var tmp = data.data.i_sell_price * q_qty.val();

		var beforetax = total_price / 2.5;

		var tax = parseInt(total_price) - parseInt(beforetax);
	}

	$(par).find('.tax').val(parseInt(tax));
	$(par).find('.beforetax').val(parseInt(beforetax));

    $(par).find('.line_total').val(accounting.formatMoney(unit_price * qty, "", 0, ".",','));
    hitung_dpp();
		synctax();
}

function edit_item(p) {
	var par    = $(p).parents('tr');
	var qty    = $(par).find('.jumlah').val();
	var item   = $(par).find('.item_name').val();
	var market = $('.marketing').val();

	var itemname = [];
	var selectedVal;
	$(".item_name").each(function(i, sel){
			selectedVal = $(sel).val();
			itemname.push(selectedVal);
	});

		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/edit_item',
	      data:{item,market},
	      dataType:'json',
	      success:function(data){

	        $(par).find('.description').val(data.data.i_description);
	        $(par).find('.unit_item').val(data.data.u_unit);
	        $(par).find('.unit_price').val(accounting.formatMoney(data.data.i_sell_price, "", 0, ".",','));
	        $(par).find('.lower_price').val(data.data.i_lower_price);
	        $(par).find('.line_total').val(accounting.formatMoney(data.data.i_sell_price * qty, "", 0, ".",','));
	        hitung_dpp();
	      }
	    });
}


$(document).on('blur','.unit_price',function(){
	@if (Auth::user()->akses('LOWER PRICE','aktif'))
		var ini = $(this);
		var par = ini.parents('tr');
		var low = par.find('.lower_price').val()*1;
		var qty = par.find('.jumlah').val()*1;
		var harga = ini.val().replace(/[^0-9\-]+/g,"")*1;
		if (harga < low) {
			ini.val('');
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Harga Jual Kurang Dari Harga Terendah Item Ini Yaitu'+accounting.formatMoney(low, "", 0, ".",','),
	        });
		}
		ini.val(accounting.formatMoney(harga, "", 0, ".",','))
		par.find('.line_total').val(accounting.formatMoney(harga*qty, "", 0, ".",','))
	@else
		var ini = $(this);
		var par = ini.parents('tr');
		var low = par.find('.lower_price').val()*1;
		var qty = par.find('.jumlah').val()*1;
		var harga = ini.val().replace(/[^0-9\-]+/g,"")*1;

		if (harga < low) {
			ini.val('');
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Tidak Boleh Kurang Dari Harga Terendah, Harga Terendah Item Ini Adalah '+accounting.formatMoney(low, "", 0, ".",','),
	        });
		}else{
			ini.val(accounting.formatMoney(harga, "", 0, ".",','))
			par.find('.line_total').val(accounting.formatMoney(harga*qty, "", 0, ".",','))
		}

	@endif
	hitung_dpp();
	synctax();
})

var q_qty         = $("#q_qty");

var x = 1;
q_qty.keypress(function(e) {
	var m_table       = $("#apfsds").DataTable();
	var market   	  = $('.marketing').val();
  if(e.which == 13 || e.keyCode == 13){

  	var item = $('.item').val();

  	if (item == '0') {
  		iziToast.warning({
            icon: 'fa fa-info',
            message: 'Item Harus Diisi!',
        });
        return false;
  	}
  	$.ajax({
      url:baseUrl + '/quotation/q_quotation/append_item',
      data:{item,market},
      dataType:'json',
      success:function(data){
      	var temp;

      	for (var i = 0; i < data.item.length; i++) {
      		var temp1 = '<option value="'+data.item[i].i_code+'">'+data.item[i].i_code+' - '+data.item[i].i_name+'</option>';
      		temp += temp1;
      	}

				if (data.data.i_active == 'BRG') {
					var tmp = data.data.i_sell_price * q_qty.val();

					var beforetax = tmp / 1.1;

					var tax = parseInt(tmp) - parseInt(beforetax);

				} else {
					var tmp = data.data.i_sell_price * q_qty.val();

					var beforetax = tmp / 2.5;

					var tax = parseInt(tmp) - parseInt(beforetax);
				}

				var itemname = [];
				var selectedVal;
				$(".item_name").each(function(i, sel){
						selectedVal = $(sel).val();
						itemname.push(selectedVal);
				});

				var tmp = "no";
				for (var i = 0; i < itemname.length; i++) {
					if (itemname[i] == item) {
						tmp = "yes";
					}
				}

				if (tmp == "yes") {
					iziToast.warning({
						icon: 'fa fa-times',
						message: 'Sudah ada item yang sama!',
					});
				} else {
					var dropdown = '<select onchange="edit_item(this)" name="item_name[]" style="width:200px" class="item_name">'+temp+'</select>'
	         m_table.row.add( [
	            dropdown,
	            '<input type="text" onkeyup="qty(this)" name="jumlah[]" class="jumlah form-control input-sm min-width" value="'+ q_qty.val() +'">',

	            '<input type="text" readonly class="unit_item form-control input-sm min-width" value="'+ data.data.u_unit +'">',
	            '<input type="text" name="description[]" class="description form-control input-sm min-width" value="'+data.data.i_description+'">',

	            '<input type="text" name="unit_price[]" onkeyup="unit_price(this)" value="'+accounting.formatMoney(data.data.i_sell_price, "", 0, ".",',')+'" class="unit_price form-control input-sm min-width"><input type="hidden" class="beforetax" name="beforetax[]" value="'+parseInt(beforetax)+'"><input type="hidden" class="tax" name="qd_tax[]" value="'+parseInt(tax)+'"><input type="hidden" class="tmpitem" name="tmpitem[]" value="'+data.data.i_active+'">'+
	            '<input type="hidden" readonly value="'+data.data.i_lower_price+'" class="lower_price form-control input-sm min-width">',

	            '<input type="text" value="'+accounting.formatMoney(data.data.i_sell_price*q_qty.val(), "", 0, ".",',')+'" name="line_total[]" readonly class="line_total form-control input-sm min-width">',
	            '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>',
	        ] ).draw( false );
					$('.unit_price').mask('000.000.000.000.000', {reverse: true});

					m_table.$('.item_name').last().val(data.data.i_code).trigger('change');
					m_table.$('.item_name').select2();
					x++;
					q_qty.val('');
					$('.item').val('0');
				$('.item').select2();
				synctax();

				$('.jumlah').keyup(function(){
				var qty = $(this).val();
				qty = qty.replace(/[A-Za-z$. ,-]/g, "");
				$(this).val(qty);
				})
				hitung_dpp();
				}
      }
    });

  }
});



$('#apfsds tbody').on( 'click', '.delete', function () {
	var m_table       = $("#apfsds").DataTable();

    m_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
        hitung_dpp();
});

	$('.customer').change(function(){
		var customer = $(this).val();
		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/customer',
	      data:{customer},
	      dataType:'json',
	      success:function(data){
	        $('.address').text(data.data.c_address)
	      }
	    });
	})

	$('.type_qo').change(function(){
		var type_q = $('.type_qo').val();
		var type_p = $('.type_p').val();
		var date   = $('.date').val();

		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/nota_quote',
	      data:{type_q,type_p,date},
	      dataType:'json',
	      success:function(data){
	        $('.quote').val(data.nota)
	      }
	    });
	})
	// $('.marketing').change(function(){
	// 	var market = $(this).val();
	// 	$.ajax({
	//       url:baseUrl + '/quotation/q_quotation/cari_penawaran',
	//       data:{market},
	//       success:function(data){
	//         $('.item_div').html(data)
	//         $('.item').select2();
	//       }
	//     });
	// });


	$('.type_p').change(function(){
		var type_q = $('.type_qo').val();
		var type_p = $('.type_p').val();
		var date   = $('.date').val();

		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/nota_quote',
	      data:{type_q,type_p,date},
	      dataType:'json',
	      success:function(data){
	        $('.quote').val(data.nota)
	      }
	    });
	})

	$('.save').click(function(){

		var array_valid = [];
		var customer = $('.customer').val();
		var address = $('.address').text();
		var type_qo = $('.type_qo').val();
		var type_p  = $('.type_p').val();
		var ship_method  = $('.ship_method').val();
		var ship_term  = $('.ship_term').val();
		var delivery  = $('.delivery').val();
		var date  = $('.date').val();
		var quote  = $('.quote').val();
		var ship_to  = $('.ship_to').val();
		var total = $('#total').val();
		var subtotal = $('#subtotal').val();
		var tax = $('#tax').val();


		if (customer == '0') {
			$('.valid_0').prop('hidden',false);
			array_valid.push(0);
		}else if (customer != '0'){
			$('.valid_0').prop('hidden',true);

		}

		if (address == '') {
			$('.valid_1').prop('hidden',false);
			array_valid.push(0);
		}else if (address != ''){
			$('.valid_1').prop('hidden',true);

		}

		if (type_qo == '0') {
			$('.valid_2').prop('hidden',false);
			array_valid.push(0);
		}else if (type_qo != '0'){
			$('.valid_2').prop('hidden',true);

		}

		if (type_p == '0') {
			$('.valid_3').prop('hidden',false);
			array_valid.push(0);
		}else if (type_p != '0'){
			$('.valid_3').prop('hidden',true);

		}


		if (date == '') {
			$('.valid_4').prop('hidden',false);
			array_valid.push(0);
		}else if (date != ''){
			$('.valid_4').prop('hidden',true);

		}

		if (quote == '') {
			$('.valid_5').prop('hidden',false);
			array_valid.push(0);
		}else if (quote != ''){
			$('.valid_5').prop('hidden',true);

		}

		if (ship_to == '') {
			$('.valid_6').prop('hidden',false);
			array_valid.push(0);
		}else if (ship_to != ''){
			$('.valid_6').prop('hidden',true);

		}


		if (ship_method == '0') {
			$('.valid_7').prop('hidden',false);
			array_valid.push(0);
		}else if (ship_method != '0'){
			$('.valid_7').prop('hidden',true);

		}

		if (ship_term == '') {
			$('.valid_8').prop('hidden',false);
			array_valid.push(0);
		}else if (ship_term != ''){
			$('.valid_8').prop('hidden',true);

		}

		// if (delivery == '') {
		// 	$('.valid_9').prop('hidden',false);
		// 	array_valid.push(0);
		// }else if (delivery != ''){
		// 	$('.valid_9').prop('hidden',true);
    //
		// }


		if (total == '' || total == '0') {
			$('.valid_10').prop('hidden',false);
			array_valid.push(0);
		}else{
			$('.valid_10').prop('hidden',true);

		}



		var index = array_valid.indexOf(0);

		if (index != -1) {
			iziToast.warning({
	            icon: 'fa fa-info',
	            message: 'Periksa Kembali Data Anda!',
	        });
			return false;
		}




		var m_table = $("#apfsds").DataTable();
	iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Simpan Data!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
              [
                '<button style="background-color:#32CD32;">Save</button>',
                function (instance, toast) {

                  $.ajaxSetup({
				      headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
				    });

                  $.ajax({
				      url:baseUrl + '/quotation/q_quotation/save_quote',
				      data:m_table.$('input').serialize()+'&'+
				     	   m_table.$('.item_name').serialize()+'&'+
				      	   $('.form_quote :input').serialize()+'&'+
				      	   $('.total_form').serialize(),
				      dataType:'json',
				      success:function(data){
				      	if (data.status == '1') {
				      		var table = $('#table_quote').DataTable();
          					table.ajax.reload();
				      		iziToast.success({
					            icon: 'fa fa-save',
					            message: 'Data Berhasil Disimpan!',
					        });


					         $('.customer').val('0');
							 $('.address').text('');
							 $('.type_qo').val('0');
							 $('.type_p').val('0');
							 $('.ship_method').val('0');
							 $('.ship_term').val('');
							 $('.quote').val('');
							 $('.ship_to').val('');
							 $('#total').val('0');
							 $('#subtotal').val('0');
							 $('#tax').val('0');
							 $('.delivery').val('');
							 $('.type_qo').select2();
							 $('.type_p').select2();
							 $('.customer').select2();
							 $('.ship_method').select2();

							 m_table.clear().draw();
				      		{{-- window.open("{{ url('quotation/q_quotation/print_quote') }}"+'/'+data.id); --}}
				      	}
				      },error:function(){
			      		iziToast.warning({
				            icon: 'fa fa-info',
				            message: 'Terjadi Kesalahan!',
				        });
				      }
				    });
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

	})


	function hapus(nota) {

		iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Hapus Data!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
              [
                '<button style="background-color:red;">Delete</button>',
                function (instance, toast) {
                  $.ajax({
				      url:baseUrl + '/quotation/q_quotation/hapus_quote',
				      data:{nota},
				      dataType:'json',
				      success:function(data){
				      	if (data.status == '1') {
				      		var table = $('#table_quote').DataTable();
          					table.ajax.reload();
				      		iziToast.success({
					            icon: 'fa fa-trash',
					            message: 'Data Berhasil Dihapus!',
					        });

				      	}
				      },error:function(){
			      		iziToast.warning({
				            icon: 'fa fa-info',
				            message: 'Terjadi Kesalahan!',
				        });
				      }
				    });
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


	function printing(id) {
		window.open("{{ url('quotation/q_quotation/print_quote') }}"+'/'+id+'/detail');
		window.location.reload();
	}

	function printing_global(id){
		window.open("{{ url('quotation/q_quotation/print_quote') }}"+'/'+id + '/global');
		window.location.reload();
	}

	function edit(id) {
		window.open("{{ url('quotation/q_quotation/edit_quotation') }}"+'/'+id);
		window.location.reload();
	}

	function detail(p) {
		var par = $(p).parents('tr');
		var id  = $(par).find('.q_id').val();

		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/detail',
	      data:{id},
	      success:function(data){
	        $('.detail_table').html(data)
	      }
	    });
	}

	function histori(p) {
		var par = $(p).parents('tr');
		var id  = $(par).find('.q_id').val();

		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/histori',
	      data:{id},
	      success:function(data){
	        $('.histori_status').html(data)
	      }
	    });
	}

	function status(id) {
		$('.q_id_status').val(id)
		$('#update_status').modal({backdrop: 'static', keyboard: false});
	}
	$('.update_status').click(function(){
		$.ajax({
	      url:baseUrl + '/quotation/q_quotation/update_status',
	      data:$('.table_status :input').serialize(),
	      success:function(data){
	      	if (data.status == 1) {
	      		iziToast.success({
		            icon: 'fa fa-check',
		            message: 'Status Berhasil Di Update!',
		        });

		        var table = $('#table_quote').DataTable();
          		table.ajax.reload();
	      	}else{
	      		iziToast.warning({
		            icon: 'fa fa-info',
		            message: 'Data Sudah Di Approve!',
		        });
	      	}
	      }
	    });
	})

	function synctax(){
		var values = [];
		var selectedVal;
		$(".tax").each(function(i, sel){
				selectedVal = $(sel).val();
				selectedVal = selectedVal.replace(/[^0-9\-]+/g,"");
				values.push(selectedVal);
		});

		var total = values.reduce(getSum);
		$('input[name=totaltax]').val(total);
	}

	function getSum(total, num) {
	return parseInt(total) + parseInt(num);
	}

	$('#change_function').on("click", "#save_data",function(){
    $.ajax({
         type: "get",
         url: baseUrl + '/master/simpancustomer/simpan_customer',
         data: $('#form_save').serialize(),
         success: function(data){
            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
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
         },
         async: false
       });
  })

</script>
@endsection
