@extends('main')
@section('extra_style')
<style type="text/css">
  .min-width{
    min-width: 120px;
  }
  .min-width2{
    min-width: 50px;
  }
</style>
@endsection
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Purchase</li>
          <li class="breadcrumb-item">Purchase Order</li>
          <li class="breadcrumb-item active" aria-current="page">Edit Purchase Order</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <form id="form-save">
              <div class="card-body">
                <h4 class="card-title">Edit Purchase Order</h4>


                <div class="row">



                        <div class="col-md-7 col-sm-12 col-xs-12">
                          <div class="row">

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Vendor Id</label>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <div class="form-group">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm readonly" name="po_vendor" value="{{ $data[0]->ro_vendor }}">
                                    <input type="hidden" name="nomor_ro" value="{{ $data[0]->ro_code }}">
                                    <input type="hidden" name="vedor_ro" value="{{ $data[0]->ro_vendor }}">
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Vendor Name</label>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <div class="form-group">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm readonly" name="po_name" value="{{ $data[0]->s_name }} - {{ $data[0]->s_company }}">
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Adress</label>
                            </div>

                            <div class="col-md-10 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <textarea class="form-control readonly" name="po_address">{{ $data[0]->s_address }}</textarea>
                              </div>
                            </div>

                          </div>
                       </div>


                       <div class="col-md-5 col-sm-12 col-xs-12" style="height: 1%;">

                        <div class="row">

                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Date</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm datepicker_today" name="po_date">
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>P.O.#</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm readonly"  name="po_nopo" value="{{ $data[0]->po_code }}">
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Customer ID</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm readonly" name="po_noro" value="{{$data[0]->po_nomor_ro}}">
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Ship to</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm" name="po_shipping_to" value="{{$data[0]->po_shipping_to}}">
                            </div>
                          </div>
                        </div>

                       </div>

                </div>

                <div class="row" style="margin-top: 15px;">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                     <div class="col-md-2 col-sm-6 col-xs-12">
                        <label>Shipping Method</label>
                      </div>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group" >
                          <select style="width: 100%" class="form-control form-control-sm ship_method select2-hidden-accessible" name="po_shipping_method" tabindex="-1" aria-hidden="true">
                              <option value="0" @if($data[0]->po_shipping_method == "0") selected @endif>--Select Shipping Method--</option>
                              <option value="Sea" @if($data[0]->po_shipping_method == "Sea") selected @endif>Sea</option>
                              <option value="Land Freight" @if($data[0]->po_shipping_method == "Land Freight") selected @endif>Land Freight</option>
                              <option value="Air Freight" @if($data[0]->po_shipping_method == "Air Freight") selected @endif>Air Freight</option>
                          </select>
                        </div>
                      </div>



                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <label>Shipping Term</label>
                      </div>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="po_shipping_term" value="{{$data[0]->po_shipping_term}}">
                        </div>
                      </div>



                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <label>Delivery Date</label>
                      </div>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm datepicker" name="po_shipping_date" value="{{Carbon\Carbon::parse($data[0]->po_delivery_date)->format('d-m-Y')}}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
                  <div class="col-md-3 col-sm-6 col-xs-12">

                    <label>Item</label>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="form-control form-control-sm" id="rp_kodeitem">
                        <option selected="" value="">- Pilih -</option>
                        @foreach ($item as $i)
                          <option value="{{ $i->i_code }}" data-name="{{ $i->i_name }}" data-unit="{{$i->u_unit}}" data-price="{{ $i->i_price }}"
                            @if ($i->sg_qty != null)
                              data-qty="{{ $i->sg_qty }}"
                            @else
                              data-qty='0'
                            @endif
                          >{{ $i->i_code }} - {{ $i->i_name }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm right readonly" name="" id="rp_item">
                    </div>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12">
                    <label>Qty</label>
                  </div>
                  <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm right hanya_angka"  name="" id="rp_qty" >
                    </div>
                  </div>
                </div>

               <div class="table-responsive" style="margin-bottom: 15px;">
                 <table class="table table-bordered table-hover" cellspacing="0" id="t72a">
                   <thead class="bg-gradient-info">
                     <tr>
                       <th>Item Code</th>
                       <th width="30%">Item Name</th>
                       <th>Qty Requested</th>
                       <th>Qty Approved</th>
                       <th>Unit</th>
                       <th>Unit Price</th>
                       <th>Line Total</th>
                       <th>PPn</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>
                     @foreach ($data_seq as $seq)
                       <tr>
                          <td><input type="text" class="form-control form-control-sm min-width readonly" name="podt_barang[]" value="{{ $seq->podt_item }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width readonly" name="podt_name[]" value="{{ $seq->i_name }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width2 right format_money readonly qty" value="{{ $seq->podt_qty }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width2 right format_money qty_approved_value"  onkeyup="hitung_qty(this)" name="podt_qty[]" value="{{ $seq->podt_qty_approved }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width2 readonly" name="podt_unit[]" value="{{ $seq->u_unit }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width right format_money readonly unit_price" name="podt_unit_price[]" value="{{ number_format($seq->podt_unit_price,0,',','.') }}"></td>
                          <td><input type="text" class="form-control form-control-sm min-width right format_money total_price readonly" name="podt_price[]" onchange="hitung_total(this)" value="{{ number_format($seq->podt_price,0,',','.') }}"></td>
                          <td><input type="checkbox" name="podt_ppn[]" class="ppn" onchange="ppn_10(this)">10%</td>
                          <td><button type="button" class="delete btn btn-outline-danger btn-sm hapus"><i class="fa fa-trash"></i></button></td>
                       </tr>
                     @endforeach
                   </tbody>
                 </table>
               </div>

               <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Subtotal</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right" readonly="" name="po_subtotal" id="po_subtotal">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Sales Tax</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right format_money" name="po_tax" value="0" id="po_tax">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Total</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right format_money" readonly="po_total_net" name="total_net" id="total_net">
                      </div>
                    </div>
                  </div>

                 </div>
               </div>

                <div align="right" style="margin-top: 15px;">
                  <div id="change_function">
                    <button class="btn-info btn-sm btn" type="button" id="save_data">Create Po</button>
                    <a href="{{ route('purchaseorder') }}" class="btn btn-secondary btn-sm">Back</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">



  $('#rp_kodeitem').change(function(){
      var this_val = $(this).find(':selected').data('price');
          if($(this).val() != '') {
            $('#rp_qty').attr('disabled',false);
          }else{
            $('#rp_qty').attr('disabled',true);
          }
      var price = $('#rp_item').val(accounting.formatMoney(this_val,"",0,'.',','));
  });





    var table           = $("#t72a").DataTable({
      "scrollX": true
    });
    var rp_qty         = $("#rp_qty");
    var rp_item          = $("#rp_item");
    var rp_kodeitem       = $("#rp_kodeitem");

    var x = 1;

    $('#rp_qty').attr('disabled',true);
    $('#rp_kodeitem').change(function(){
      var this_val = $(this).find(':selected').data('price');
          if($(this).val() != '') {
            $('#rp_qty').attr('disabled',false);
          }else{
            $('#rp_qty').attr('disabled',true);
          }
      var price = $('#rp_item').val(accounting.formatMoney(this_val,"",0,'.',','));
    });


    rp_qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        var qty = rp_qty.val();
        var harga_1 = rp_item.val();

        qty = qty.replace(/[^0-9\-]+/g,"");
        harga_1 = harga_1.replace(/[^0-9\-]+/g,"");

        var total = parseInt(harga_1)*parseInt(qty);
        table.row.add( [
            '<input type="text" id="item_kode[]"    name="podt_barang[]"    class="form-control input-sm min-width readonly" readonly value="'+ rp_kodeitem.val() +'">',
            '<input type="text" id="podt_name[]"    name="podt_name[]"   class="form-control input-sm min-width readonly" value="'+ rp_kodeitem.find(':selected').data('name') +'">',
            '<input type="text" id="podt_qty_requested[]"   class="form-control input-sm min-width right readonly " value="'+rp_qty.val()+'">',
            '<input type="text" id="podt_qty[]"     name="podt_qty[]"    class="form-control input-sm min-width right readonly qty_approved_value qty" onkeyup="hitung_qty(this)" value="'+rp_qty.val()+'">',
            '<input type="text" class="form-control form-control-sm min-width2 readonly" name="podt_unit[]" value="'+rp_kodeitem.find(':selected').data('unit')+'">',
            '<input type="text" id="podt_unit_price[]"   name="podt_unit_price[]"    class="form-control input-sm min-width right readonly unit_price" value="'+ accounting.formatMoney(rp_kodeitem.find(':selected').data('price'),"",0,'.',',') +'">',
            '<input type="text" id="podt_price[]"   name="podt_price[]"    class="form-control input-sm min-width right readonly total_price " value="'+ accounting.formatMoney(total,"",0,'.',',') +'">',
            '<td><input type="checkbox" name="podt_ppn[]" class="ppn" onchange="ppn_10(this)">10%</td>',
            '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>',
        ] ).draw( false );

        x++;

        var total_price = 0;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });
        $("input[name='ro_total_header']").val(accounting.formatMoney(total_price,"",0,'.',','));

        var total_qty = 0;
        $('.total_qty').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_qty += parseInt(total);
        });
        $("input[name='ro_qty_header']").val(accounting.formatMoney(total_qty,"",0,'.',','));

        var tax =  $('#po_tax').val();
        tax = tax.replace(/[^0-9\-]+/g,"");
        hitung_tax = parseInt(total_price)+parseInt(tax);
        $('#total_net').val(accounting.formatMoney(hitung_tax,"",0,'.',','));

        rp_item.focus();
        rp_item.val('');
        rp_kodeitem.val('').trigger('change');
        rp_qty.val('');
      }
    });



    $('#t72a tbody').on( 'click', '.delete', function () {

        table
            .row($(this).parents('tr'))
            .remove()
            .draw();

        var parents = $(this).parents('tr');
        var total_price = $('#po_subtotal').val();
          total_price = total_price.replace(/[^0-9\-]+/g,"");
        var ppn_value = $(parents).find('.ppn');
        if (ppn_value.prop('checked') == true) {
          var hitung = parseInt(total_price)*(10/parseInt(100));

        }else if(ppn_value.prop('checked') == false){
          var hitung = 0;

        }

        var total_price = 0;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });

        $("input[name='po_subtotal']").val(accounting.formatMoney(total_price,"",0,'.',','));

        var tmp =  $('#po_tax').val();
        tmp = tmp.replace(/[^0-9\-]+/g,"");
        var tmp1 = parseInt(tmp) - parseInt(hitung);

        $('#po_tax').val(tmp1);

        var tax =  $('#po_tax').val();
        tax = tax.replace(/[^0-9\-]+/g,"");
        hitung_tax = parseInt(total_price)+parseInt(tax);
        $('#total_net').val(accounting.formatMoney(hitung_tax,"",0,'.',','));

    });




    //HITUNG SALES TAX
    $('#po_tax').keyup(function(){
      var total_net = $("#po_subtotal").val();
      var this_val = $(this).val();
      total_net = total_net.replace(/[^0-9\-]+/g,"");
      this_val = this_val.replace(/[^0-9\-]+/g,"");
      var hitung = parseInt(total_net)+parseInt(this_val);
      $('#total_net').val(accounting.formatMoney(hitung,"",0,'.',','));
    })




   $('#datatable tbody').on( 'click', '.delete', function () {
    var parents = $(this).parents('tr');

    var total_price = $(parents).find('.total_price').val();
    var sub_total = $('#po_subtotal').val();
    var po_tax = $('#po_tax').val();
    total_price = total_price.replace(/[^0-9\-]+/g,"");
    sub_total = sub_total.replace(/[^0-9\-]+/g,"");
    po_tax = po_tax.replace(/[^0-9\-]+/g,"");
    var kurang_subtotal = parseInt(sub_total)-parseInt(total_price);
    var kurang_totalnet = parseInt(sub_total)-parseInt(total_price)+parseInt(po_tax);
    table
        .row(parents)
        .remove()
        .draw();


        $("#po_subtotal").val(accounting.formatMoney(kurang_subtotal,"",0,'.',','));
        $("#total_net").val(accounting.formatMoney(kurang_totalnet,"",0,'.',','));
    });


    //HITUNG TOTAL NET DAN SUB TOTAL
    var total_price = 0;
      $('.total_price').each(function(){
        var total = $(this).val();
        total = total.replace(/[^0-9\-]+/g,"");
        total_price += parseInt(total);
    });
    $("#po_subtotal").val(accounting.formatMoney(total_price,"",0,'.',','));
    $('#total_net').val(accounting.formatMoney(total_price,"",0,'.',','));
    //



    function hitung_qty(a){
      //HITUNG QTY PADA TABLE
      var parents_qty = $(a).parents('tr');
      var qty_value = $(parents_qty).find('.qty').val();
      var qty_approved_value = $(parents_qty).find('.qty_approved_value').val();
      var unit_value = $(parents_qty).find('.unit_price').val();
      //regex
      qty_approved_value = qty_approved_value.replace(/[^0-9\-]+/g,"");
      unit_value = unit_value.replace(/[^0-9\-]+/g,"");
      qty_value = qty_value.replace(/[^0-9\-]+/g,"");


      //PERINGATAN MELEBIHI BATAS QTY
      if (parseInt(qty_approved_value) > parseInt(qty_value)) {
        iziToast.warning({
            icon: 'fa fa-times',
            message: 'Qty Melebihi Batas MAX!',
        });

        $(parents_qty).find('.qty_approved_value').val(0);

      }

      var hitung = parseInt(qty_approved_value)*parseInt(unit_value);
      var replace_price = $(parents_qty).find('.total_price').val(accounting.formatMoney(hitung,"",0,'.',','));


      //HITUNG SUBTOTAL DAN TOTAL NET PADA TABLE
      var total_price = 0;
      $('.total_price').each(function(){
        var total = $(this).val();
        total = total.replace(/[^0-9\-]+/g,"");
        total_price += parseInt(total);
      });

      $("#po_subtotal").val(accounting.formatMoney(total_price,"",0,'.',','));

      //PENGURANGAN TAX
      var tax =  $('#po_tax').val();
      tax = tax.replace(/[^0-9\-]+/g,"");
      hitung_tax = parseInt(total_price)+parseInt(tax);
      $('#total_net').val(accounting.formatMoney(hitung_tax,"",0,'.',','));

    }


    function ppn_10 (a) {
      var parents_ppn = $(a).parents('tr');
      var ppn_value = $(parents_ppn).find('.ppn').val();
      var total_price = $(parents_ppn).find('.total_price').val();
      total_price = total_price.replace(/[^0-9\-]+/g,"");

      if ($('.ppn').prop('checked') == true) {
        var hitung = parseInt(total_price)*(10/parseInt(100));
        var total  = $('#po_tax').val();
        var hitung = parseInt(total)+parseInt(hitung);

        $('#po_tax').val(hitung);
      }else if($('.ppn').prop('checked') == false){
        var hitung = parseInt(total_price)*(10/parseInt(100));
        var total  = $('#po_tax').val();
        var hitung = parseInt(total)-parseInt(hitung);

        $('#po_tax').val(hitung);
      }
    }





  $('#change_function').on("click","#save_data",function(){

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

                  $.ajax({
                   type: "get",
                   url: baseUrl + '/purchase/purchaseorder/update',
                   data: $('#form-save').serialize(),
                   success: function(data){


                      iziToast.success({
                        icon: 'fas fa-check-circle',
                        message: 'Data Telah Tersimpan!',
                      });
                      if (data.status == 1) {
                        window.location.href=('{{ route('purchaseorder') }}')
                      }
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


  })



</script>
@endsection
