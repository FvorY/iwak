@section('extra_style')
<style type="text/css">
  .min-width{
    min-width: 100px;
  }
  /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: visible;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
@endsection
@extends('main')

@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="col-lg-12">
		<nav aria-label="breadcrumb" role="navigation">
			<ol class="breadcrumb bg-info">
				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
				<li class="breadcrumb-item">Quotation</li>
				<li class="breadcrumb-item"><a href="{{url('quotation/q_quotation/q_quotation')}}">Quotation</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Quotation</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
  	<div class="card">
        <div class="card-body">
          	<h4 class="card-title">Edit Quotation</h4>


	<div class="row">
    <div class="loading">Loading&#8230;</div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <form class="row form_quote">
          {{ csrf_field() }}
          <input type="hidden" name="totaltax" value="{{$data->q_tax}}">
          <div class="col-md-6 col-sm-8 col-xs-8">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Customer</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="row">
                    <div class="form-group col-sm-12 customer_div disabled">
                        <select style="width: 100%" class="form-control form-control-sm customer"  name="customer">
                          <option value="0">--Select Customer--</option>
                          @foreach($customer as $i)
                          <option  @if($data->q_customer == $i->c_code) selected="" @endif  value="{{$i->c_code}}">{{$i->c_code}} - {{$i->c_name}}</option>
                          @endforeach
                        </select>
                        <label style="color: red" hidden  class="valid valid_0"><b>Customer Harus Dipilih</b></label>
                      </div>
                </div>
              </div>
              <div class="col-md-2 col-sm-0 col-xs-0">
                <!-- empty -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Address</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <textarea name="address" class="form-control address"></textarea>
                  <label style="color: red" hidden  class="valid valid_1"><b>Alamat Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-3 col-sm-0 col-xs-0">
                <!-- empty -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Type Quotation</label>
              </div>
              @if ($data->q_status == 2)
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group type_q_div">
                  <select style="width: 100%" class="form-control form-control-sm type_qo" id="type_qo" name="type_qo">
                    <option value="0">--Select Type--</option>
                    <option @if($data->q_type == 'SWP') selected="" @endif value="SWP">SWP</option>
                    <option @if($data->q_type == 'WP') selected="" @endif value="WP">WP</option>
                    <option @if($data->q_type == 'ACC') selected="" @endif value="ACC">Accesories</option>
                    <option @if($data->q_type == 'OFD') selected="" @endif value="OFD">Off Grid</option>
                    <option @if($data->q_type == 'ONG') selected="" @endif value="ONG">On Grid</option>
                  </select>
                  <label style="color: red" hidden  class="valid valid_2"><b>Type Quotation Harus Dipilih</b></label>
                </div>
              </div>
              @else
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group type_q_div disabled">
                    <select style="width: 100%" class="form-control form-control-sm type_qo" id="type_qo" name="type_qo">
                      <option value="0">--Select Type--</option>
                      <option @if($data->q_type == 'SWP') selected="" @endif value="SWP">SWP</option>
                      <option @if($data->q_type == 'WP') selected="" @endif value="WP">WP</option>
                      <option @if($data->q_type == 'ACC') selected="" @endif value="ACC">Accesories</option>
                      <option @if($data->q_type == 'OFD') selected="" @endif value="OFD">Off Grid</option>
                      <option @if($data->q_type == 'ONG') selected="" @endif value="ONG">On Grid</option>
                    </select>
                    <label style="color: red" hidden  class="valid valid_2"><b>Type Quotation Harus Dipilih</b></label>
                  </div>
                </div>
              @endif
              <div class="col-md-3 col-sm-0 col-xs-0">
                <!-- empty -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Type Product</label>
              </div>
              @if ($data->q_status == 2)
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group type_p_div">
                    <select style="width: 100%" class="form-control form-control-sm type_p" id="type_p" name="type_p">
                     <option value="0">--Select Type--</option>
                     @foreach ($type_product as $val)
                      <option @if ($val->it_code == $data->q_type_product)
                       selected=""
                      @endif value="{{$val->it_code}}">{{$val->it_code}}</option>
                     @endforeach
                    </select>
                    <label style="color: red" hidden  class="valid valid_3"><b>Type Product Harus Dipilih</b></label>
                  </div>
                </div>
              @else
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group type_p_div disabled">
                    <select style="width: 100%" class="form-control form-control-sm type_p" id="type_p" name="type_p">
                     <option value="0">--Select Type--</option>
                     @foreach ($type_product as $val)
                      <option @if ($val->it_code == $data->q_type_product)
                       selected=""
                      @endif value="{{$val->it_code}}">{{$val->it_code}}</option>
                     @endforeach
                    </select>
                    <label style="color: red" hidden  class="valid valid_3"><b>Type Product Harus Dipilih</b></label>
                  </div>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12" >
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Date</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" value="{{ carbon\carbon::parse($data->q_date)->format('d-m-Y')}}" class="form-control form-control-sm datepicker date" name="date">
                  <label style="color: red" hidden  class="valid valid_4"><b>Date Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Quote#</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" value="{{ $data->q_nota}}" class="form-control form-control-sm quote" name="quote">
                  <label style="color: red" hidden  class="valid valid_5"><b>Quote Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Ship to</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" value="{{ $data->q_ship_to}}" class="form-control form-control-sm ship_to" name="ship_to">
                  <label style="color: red" hidden  class="valid valid_6"><b>Ship to Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Marketing</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group disabled">
                  @if(Auth::user()->akses('QUOTE MARKETING','aktif'))
                    <select class="marketing form-control" name="marketing">
                      <option value="0">--Select Marketing--</option>
                      @foreach($marketing as $i)
                        <option  @if($data->q_marketing == $i->mk_id) selected="" @endif value="{{$i->mk_id}}">{{$i->mk_code}} - {{$i->mk_name}}</option>
                      @endforeach
                    </select>
                  @else
                    <input readonly="" type="text" class="form-control marketing form-control-sm" name="marketing" value="{{ $data->q_marketing}}">
                  @endif
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Item Status</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <select class="itemstatus" name="itemstatus">
                      <option>--Select Item Status--</option>
                      <option value="Y" @if ($data->q_item_status == 'Y')
                        selected
                      @endif>Ready</option>
                      <option value="N" @if ($data->q_item_status == 'N')
                        selected
                      @endif>Indent</option>
                    </select>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;margin-top: 25px;">
            <div class="row">
              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Shipping Method</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select style="width: 100%" class="form-control form-control-sm ship_method" name="ship_method">
                    <option  value="0">--Select Shipping Method--</option>
                    <option  @if($data->q_shipping_method == 'Sea') selected="" @endif value="Sea">Sea</option>
                    <option  @if($data->q_shipping_method == 'Land Freight') selected="" @endif value="Land Freight">Land Freight</option>
                    <option  @if($data->q_shipping_method == 'Air Freight') selected="" @endif value="Air Freight">Air Freight</option>
                  </select>
                  <label style="color: red" hidden  class="valid valid_7"><b>Shipping Method Harus Dipilih</b></label>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Shipping Terms</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" value="{{$data->q_term}}" class="form-control-sm form-control ship_term" name="ship_term">
                  <label style="color: red" hidden  class="valid valid_8"><b>Shipping Terms Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Delivery Date</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input value="{{ carbon\carbon::parse($data->q_delivery)->format('d-m-Y')}}" type="text" class="form-control-sm form-control datepicker delivery" name="delivery">
                  <label style="color: red" hidden  class="valid valid_9"><b>Delivery Date Harus Diisi</b></label>
                </div>
              </div>
            </div>
          </div>

        </form><!-- End div row -->

        <div class="row col-sm-12" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12">
            <div class="form-group item_div">
              <select class="form-control form-control-sm item" name="item">
                <option value="0">--Select item--</option>
                @foreach ($item as $val)
                  <option value="{{$val->i_code}}">{{$val->i_code}} - {{$val->i_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Qty</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm q_qty" name="" id="q_qty" title="Press Enter">
            </div>
          </div>
        </div>
          <div class="table-responsive" style="margin-bottom: 15px;">
            <table class="table table-hover apfsds" cellspacing="0" id="apfsds" style="width:100%;">
              <thead class="bg-gradient-info">
                <tr>
                  <th width="200">Item</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Description</th>
                  <th>Unit Price</th>
                  <th>Line Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data_dt as $val)
                  <tr>
                    <td>
                      <select onchange="edit_item(this)" name="item_name[]" style="width:200px" class="item_name">
                        @foreach($item as $i)
                        <option value="{{ $i->i_code }}" @if($val->i_code == $i->i_code) selected @endif>{{ $i->i_code }} - {{ $i->i_name }}</option>
                        @endforeach
                      </select>
                   </td>
                   <td><input type="text" onkeyup="qty(this)" name="jumlah[]" class="jumlah form-control input-sm min-width" value="{{ $val->qd_qty }}"></td>
                   <td><input type="text" readonly class="unit_item form-control input-sm min-width" value="{{ $val->u_unit }}"></td>
                   <td><input type="text" name="description[]" class="description form-control input-sm min-width" value="{{ $val->qd_description }}"></td>
                   <td><input type="text" name="unit_price[]" onkeyup="unitprice(this)" value="{{ number_format($val->qd_price,0,',','.') }}" class="unit_price form-control input-sm min-width"><input type="hidden" class="beforetax" name="beforetax[]" value="{{ (int)$val->qd_beforetax }}"><input type="hidden" class="tax" name="qd_tax[]" value="{{(int)$val->qd_tax}}"><input type="hidden" class="tmpitem" name="tmpitem[]" value="{{ $val->i_active }}"></td>
                   <td><input type="text" value="{{number_format($val->qd_price*$val->qd_qty,0,',','.')}}" name="line_total[]" readonly class="line_total form-control input-sm min-width"><input type="hidden" readonly value="{{ $val->i_lower_price }}" class="lower_price form-control input-sm min-width"></td>
                   <td><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row col-sm-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <form class="row total_form">
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Subtotal</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" value="{{ number_format($data->q_subtotal, 0, ",", ".") }}" type="text" class="form-control form-control-sm" readonly="" name="subtotal" id="subtotal">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Sales Tax</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" type="text" readonly class="form-control form-control-sm" name="tax" id="tax">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Total</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" readonly="" name="total" value="{{ number_format($data->q_total, 0, ",", ".") }}" id="total">
                  </div>
                  <label style="color: red" hidden  class="valid valid_10"><b>Total Tidak Boleh 0</b></label>
                </div>

              </form>
              <div class="pull-right ">
                	<button class="btn btn-primary save" type="button">Update</button>
        			<a type="button back" href="../q_quotation" class="btn btn-warning" data-dismiss="modal">Back</a>
               </div>
		        </div><!-- End div row -->
    		</div>
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
<script type="text/javascript">
var m_table = $('#apfsds').DataTable({
  'iDisplayLength': 100,
  'paging': false,
  columnDefs: [

                  {
                     targets: 5 ,
                     className: 'center'
                  },
                ],
});

$(document).ready(function(){

  $('.loading').css('display', 'none');

  $('.item_name').select2();
  $('.item').val('0');
  $('.item').select2();

  $('.jumlah').keyup(function(){
  var qty = $(this).val();
  qty = qty.replace(/[A-Za-z$. ,-]/g, "");
  $(this).val(qty);
  });

  $('#tax').maskMoney({
      precision : 0,
      thousands:'.',
      allowZero:true,
      defaultZero: true
  });

  $('.unit_price').maskMoney({thousands:'.', decimal:',', precision:0});

  var customer = $('.customer').val();
  $.ajax({
    url:baseUrl + '/quotation/q_quotation/customer',
    data:{customer},
    dataType:'json',
    success:function(data){
      $('.address').text(data.data.c_address)
    }
  });

  // var market = $('.marketing').val();
  //   $.ajax({
  //     url:baseUrl + '/quotation/q_quotation/cari_penawaran',
  //     data:{market},
  //     success:function(data){
  //       $('.item_div').html(data)
  //       $('.item').select2();
  //     }
  //   });
})


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
    temp   = temp.replace(/[^0-9\-]+/g,"")*1;
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

function edit_item(p) {
  var par    = $(p).parents('tr');
  var qty    = $(par).find('.jumlah').val();
  var item   = $(par).find('.item_name').val();
  var market = $('.marketing').val();

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
  @if (Auth::user()->m_jabatan == "MANAGER")
    // var ini = $(this);
    // var par = ini.parents('tr');
    // var low = par.find('.lower_price').val()*1;
    // var qty = par.find('.jumlah').val()*1;
    // var harga = ini.val().replace(/[^0-9\-]+/g,"")*1;
    // if (parseInt(harga) < parseInt(low)) {
    //   ini.val('');
    //   par.find('.line_total').val(0);
    //   iziToast.warning({
    //           icon: 'fa fa-info',
    //           message: 'Harga Jual Kurang Dari Harga Terendah Item Ini Yaitu'+accounting.formatMoney(low, "", 0, ".",','),
    //       });
    // }
  @else
    var ini = $(this);
    var par = ini.parents('tr');
    var low = par.find('.lower_price').val()*1;
    var qty = par.find('.jumlah').val()*1;
    var harga = ini.val().replace(/[^0-9\-]+/g,"")*1;

    if (parseInt(harga) < parseInt(low)) {
      ini.val(accounting.formatMoney(low, "", 0, ".",','));
      par.find('.line_total').val(accounting.formatMoney(low*qty, "", 0, ".",','));
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
  //   var market = $(this).val();
  //   $.ajax({
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

    var status = '{{ $data->q_status }}';

    if (status == 1) {
      iziToast.warning({
          icon: 'fa fa-info',
          message: 'Data Tidak Bisa Diupdate Karena Sudah Di Approve!',
      });

      return false;
    }

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
		var id = '{{ $id }}';


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

		if (delivery == '') {
			$('.valid_9').prop('hidden',false);
			array_valid.push(0);
		}else if (delivery != ''){
			$('.valid_9').prop('hidden',true);

		}


		if (total == '' || total == '0') {
			$('.valid_10').prop('hidden',false);
			array_valid.push(0);
		}else{
			$('.valid_10').prop('hidden',true);

		}



		var index = array_valid.indexOf(0);

		if (index != -1) {
			return false;
		}




		iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Update Data!',
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
				      url:baseUrl + '/quotation/q_quotation/update_quote',
				      data:m_table.$('input').serialize()+'&'+
				     	   m_table.$('.item_name').serialize()+'&'+
				      	   $('.form_quote :input').serialize()+'&'+
				      	   $('.total_form').serialize()+'&id='+id,
				      dataType:'json',
				      success:function(data){
				      	if (data.status == '1') {
				      		var table = $('#table_quote').DataTable();
          					table.ajax.reload();
				      		iziToast.success({
					            icon: 'fa fa-save',
					            message: 'Data Berhasil Disimpan!',
					        });


                  location.href = "{{ url('/quotation/q_quotation/q_quotation') }}";
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

  // @foreach($data_dt as $val)
  //
  // 	var temp;
  //
  // 	@foreach($item as $i)
  //   		var temp1 = '<option value="'+'{{ $i->i_code }}'+'">'+'{{ $i->i_code }}'+' - '+'{{ $i->i_name }}'+'</option>';
  //   		temp += temp1;
  // 	@endforeach
  //
  //   	var dropdown = '<select onchange="edit_item(this)" name="item_name[]" style="width:200px" class="item_name">'+temp+'</select>'
  //   	var deskripsi = '{{ $val->qd_description }}';
  //     var unit_price = '{{ $val->qd_price }}';
  //   	var low_price = '{{ $val->i_lower_price }}';
  //   	var line_total = '{{ $val->qd_total }}';
  //     var beforetax = '{{ $val->qd_beforetax }}';
  //     var tmpitem = '{{ $val->i_active }}';
  //     var tax = '{{ $val->qd_tax }}';
  //   	var jumlah = '{{ $val->qd_qty }}';
  //     var item = '{{ $val->qd_item }}';
  //   	var u_unit = '{{ $val->u_unit }}';
  //      m_table.row.add( [
  //         dropdown,
  //         '<input type="text" onkeyup="qty(this)" name="jumlah[]" class="jumlah form-control input-sm min-width" value="'+ jumlah +'">',
  //         '<input type="text" readonly class="unit_item form-control input-sm min-width" value="'+ u_unit +'">',
  //         '<input type="text" name="description[]" class="description form-control input-sm min-width" value="'+deskripsi+'">',
  //
  //         '<input type="text" name="unit_price[]" onkeyup="unitprice(this)" value="'+accounting.formatMoney(unit_price, "", 0, ".",',')+'" class="unit_price form-control input-sm min-width"><input type="hidden" class="beforetax" name="beforetax[]" value="'+parseInt(beforetax)+'"><input type="hidden" class="tax" name="qd_tax[]" value="'+parseInt(tax)+'"><input type="hidden" class="tmpitem" name="tmpitem[]" value="'+tmpitem+'">'+
  //         '<input type="hidden" readonly value="'+low_price+'" class="lower_price form-control input-sm min-width">',
  //
  //         '<input type="text" value="'+accounting.formatMoney(unit_price*jumlah, "", 0, ".",',')+'" name="line_total[]" readonly class="line_total form-control input-sm min-width">',
  //         '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>',
  //     ] ).draw( false );
  //
      // $('.item_name').last().val(item);
  		// $('.item_name').select2();
      // x++;
      // q_qty.val('');
      // $('.item').val('0');
  		// $('.item').select2();
      //
  		// $('.jumlah').keyup(function(){
  		// var qty = $(this).val();
  		// qty = qty.replace(/[A-Za-z$. ,-]/g, "");
  		// $(this).val(qty);
  // 	})
  // 	// hitung_dpp();
  //
  // @endforeach

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

function unitprice(p){
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

</script>
@endsection
