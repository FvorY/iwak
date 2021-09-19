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
          <li class="breadcrumb-item">Belanja Langsung</li>
          <li class="breadcrumb-item active" aria-current="page">Tambah Belanja Langsung</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <form id="form-save">
              <div class="card-body">
                <h4 class="card-title">Tambah Belanja Langsung</h4>


                <div class="row">



                        <div class="col-md-7 col-sm-12 col-xs-12">
                          <div class="row">

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Vendor Id</label>
                            </div>

                            <div class="col-md-10 col-sm-6 col-xs-12">
                              <div class="form-group">
                                  <div class="form-group">
                                    <select class="form-control form-control-sm" name="dbl_vendor" id="dbl_vendor">
                                      <option>--Select Vendor--</option>
                                      @foreach ($vendor as $el)
                                        <option value="{{ $el->s_kode }}" data-alamat="{{ $el->s_address }}" data-name="{{ $el->s_name }}">{{ $el->s_kode }} - {{ $el->s_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Vendor Name</label>
                            </div>

                            <div class="col-md-10 col-sm-6 col-xs-12">
                              <div class="form-group">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm readonly" name="dbl_name" id="dbl_name" value="{{-- {{ $data_header->s_name }} - {{ $data_header->s_company }} --}}">
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Adress</label>
                            </div>

                            <div class="col-md-10 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <textarea class="form-control readonly" name="dbl_address" id="dbl_address">{{-- {{ $data_header->s_address }} --}}</textarea>
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
                              <input type="text" class="form-control form-control-sm datepicker_today" name="dbl_date">
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>P.O.#</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm readonly"  name="dbl_code" value="( Auto )">
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Ship to</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm" name="dbl_ship_to">
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
                          <select name="dbl_shippinethod">
                            <option selected="" value="">- Pilih -</option>
                            <option value="Sea">Sea</option>
                            <option value="Land Freight">Land Freight</option>
                            <option value="Air Freight">Air Freight</option>
                          </select>
                        </div>
                      </div>



                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <label>Shipping Term</label>
                      </div>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm" name="dbl_shipp_term">
                        </div>
                      </div>



                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <label>Delivery Date</label>
                      </div>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-sm datepicker" name="dbl_shipp_date">
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
                      <select class="form-control form-control-sm" id="dbldt_kodeitem">
                        <option selected="" value="">- Pilih -</option>
                        @foreach ($item as $i)
                          <option value="{{ $i->i_code }}" data-name="{{ $i->i_name }}" data-price="{{ $i->i_price }}" data-jenis="{{ $i->i_jenis }}"
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
                  <div class="col-md-1 col-sm-12 col-xs-12">
                    <label>Price</label>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm right readonly" name="" id="dbldt_item">
                    </div>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12">
                    <label>Qty</label>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm right hanya_angka"  name="" id="dbldt_qty" >
                    </div>
                  </div>
                </div>

               <div class="table-responsive" style="margin-bottom: 15px;">
                 <table class="table table-bordered table-hover" cellspacing="0" id="t80b">
                   <thead class="bg-gradient-info">
                     <tr>
                       <th>Item Code</th>
                       <th width="30%">Item Name</th>
                       <th>Qty Requested</th>
                       <th>Unit</th>
                       <th>Unit Price</th>
                       <th>Line Total</th>
                       <th>PPn</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>

                   </tbody>
                 </table>
               </div>
               <div id="taxshow">

               </div>
               <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Subtotal</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right dbldt_subtotal" readonly="" name="po_subtotal" id="dbldt_subtotal">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Sales Tax</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right format_money dbldt_tax" name="dbldt_tax" value="0" id="dbldt_tax">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Total</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right format_money total_net" readonly="dbldt_total_net" name="total_net" id="total_net">
                      </div>
                    </div>
                  </div>

                 </div>
               </div>
                <div align="right" style="margin-top: 15px;">
                  <div id="change_function">
                    <button class="btn-info btn-sm btn" type="button" id="save_data">Create Belanja Langsung</button>
                    <a href="{{ route('belanjalangsung') }}" class="btn btn-secondary btn-sm">Back</a>
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

  $(document).ready(function() {

   $('#dbl_vendor').change(function(){

    var name = $(this).find(':selected').data('name');
    var address = $(this).find(':selected').data('alamat');

    $('#dbl_name').val(name);
    $('#dbl_address').val(address);

   });

    var counter = 1;
    var table           = $("#t80b").DataTable();
    var dbldt_qty         = $("#dbldt_qty");
    var dbldt_item          = $("#dbldt_item");
    var dbldt_kodeitem       = $("#dbldt_kodeitem");


    $('#dbldt_qty').attr('disabled',true);
    $('#dbldt_kodeitem').change(function(){
      var this_val = $(this).find(':selected').data('price');
          if($(this).val() != '') {
            $('#dbldt_qty').attr('disabled',false);
          }else{
            $('#dbldt_qty').attr('disabled',true);
          }
      var price = dbldt_item.val(accounting.formatMoney(this_val,"",0,'.',','));
    });

    $('#dbldt_qty').keypress(function(e){
      if (e.which == 13 || e.keyCode == 13) {

      var qty = dbldt_qty.val();
      var harga_1 = dbldt_item.val();

      qty = qty.replace(/[^0-9\-]+/g,"");
      harga_1 = harga_1.replace(/[^0-9\-]+/g,"");

      var total = parseInt(harga_1)*parseInt(qty);

      var i_kode  = $('#dbldt_kodeitem').val();
      var i_name  = $('#dbldt_kodeitem').find(':selected').data('name');
      var i_price = $('#dbldt_kodeitem').find(':selected').data('price');
      var i_qty   = $('#dbldt_qty').val();
      var i_satuan = $('#dbldt_kodeitem').find(':selected').data('jenis');

      var find = $('.namaitem').attr('data');

      if (find == i_name) {
        iziToast.warning({
          icon: 'fa fa-times',
          message: 'Sudah ada item yang sama!, coba pilih item yang berbeda :)',
        });
      } else {
        table.row.add( [
            '<input type="text" name="kode[]" class="form-control form-control-sm" value="'+i_kode+'" readonly>',
            '<input type="text" name="nama[]" id="namaitem" data="'+i_name+'" class="form-control namaitem form-control-sm" value="'+i_name+'" readonly>',
            '<input type="text" name="qty[]" onkeyup="qtydinamis('+counter+')" class="form-control form-control-sm" id="qty'+counter+'" value="'+i_qty+'">',
            '<input type="text" name="satuan[]" class="form-control form-control-sm" value="'+i_satuan+'" readonly>',
            '<input type="text" name="price[]" onkeyup="total('+counter+')" class="price form-control rp" id="price'+counter+'" value="'+accounting.formatMoney(i_price,"",0,'.',',')+'">',
            '<input type="text" name="total[]" class="form-control form-control-sm total_price" id="total'+counter+'" value="'+accounting.formatMoney(total,"",0,'.',',')+'" readonly>',
            '<input type="checkbox" class="form-control form-control-sm ppn" onchange="ppn_10(this)">',
            '<center><button type="button" class="delete btn btn-outline-danger icon-btn btn-sm"><i class="fa fa-trash"></i></button></center>'

        ] ).draw( false );
      }

        $('.rp').mask('000.000.000.000.000', {reverse: true});
        counter++;
        $('#dbldt_qty').val('');
        $('#dbldt_item').val('');
        dbldt_kodeitem.val('').trigger('change');


        var total_price = 0;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });
        $("#dbldt_subtotal").val(accounting.formatMoney(total_price,"",0,'.',','));

        tax = $('#dbldt_tax').val();
        tax = tax.replace(/[^0-9\-]+/g,"");

        total_net = total_price + parseInt(tax);

        $("#total_net").val(accounting.formatMoney(total_net,"",0,'.',','));

      }
    });


    $('#t80b tbody').on( 'click', '.delete', function () {
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();


        var parents = $(this).parents('tr');

        var total_price_seq = $(parents).find('.total_price').val();
        var total = $("#dbldt_subtotal").val();
        var total_net = $("#total_net").val();
        total_price_seq = total_price_seq.replace(/[^0-9\-]+/g,"");
        total = total.replace(/[^0-9\-]+/g,"");
        total_net = total_net.replace(/[^0-9\-]+/g,"");

        var ppn_value = $(parents).find('.ppn');
        if (ppn_value.prop('checked') == true) {
          var hitung = parseInt(total_price_seq)*(10/parseInt(100));

        }else if(ppn_value.prop('checked') == false){
          var hitung = 0;

        }        

        var tmp =  $('#dbldt_tax').val();
        tmp = tmp.replace(/[^0-9\-]+/g,"");
        var tmp1 = parseInt(tmp) - parseInt(hitung);
        $('#dbldt_tax').val(tmp1);


        var kurang_total = parseInt(total)-parseInt(total_price_seq);
        var total_net = parseInt(total)-parseInt(total_price_seq);

        $("#dbldt_subtotal").val(accounting.formatMoney(kurang_total,"",0,'.',','));
        $("#total_net").val(accounting.formatMoney(total_net,"",0,'.',','));



    } );


    //HITUNG SALES TAX
    $('#dbldt_tax').keyup(function(){
      var total_net = $("#dbldt_subtotal").val();
      var this_val = $(this).val();
      total_net = total_net.replace(/[^0-9\-]+/g,"");
      this_val = this_val.replace(/[^0-9\-]+/g,"");
      var hitung = parseInt(total_net)+parseInt(this_val);
      $('#total_net').val(accounting.formatMoney(hitung,"",0,'.',','));
    })





});

    function ppn_10 (a) {
      var total_sub   = $('.dbldt_subtotal').val();
      total_sub       = total_sub.replace(/[^0-9\-]+/g,"")*1;
      var tax = [];

      var hitung_tax = 0;
      var total_net_hitung = 0;
      $('.ppn').each(function(){
          if ($(this).is(':checked') == true) {
            var par = $(this).parents('tr');
            var total_price = $(par).find('.total_price').val()
            total_price     = total_price.replace(/[^0-9\-]+/g,"")*1;
            total_price     *= 10/100;
            hitung_tax    += parseInt(total_price);
          }
          tax.push(total_price);
      });
      var html = '';
      for (var i = 0; i < tax.length; i++) {
        html += '<input type="hidden" name="tax[]" value="'+tax[i]+'">';
      }

      $('#taxshow').html(html);

      $('#dbldt_tax').val(accounting.formatMoney(hitung_tax,"",0,'.',','));
      $('#total_net').val(accounting.formatMoney(total_sub+hitung_tax,"",0,'.',','));


    }

    $('#save_data').on('click', function(){
      waitingDialog.show();
      var codevendor = $('#dbl_vendor').val();
      $.ajax({
        type: 'get',
        data: $('#form-save').serialize(),
        url: baseUrl + '/purchase/belanjalangsung/simpan',
        dataType: 'json',
        success : function(result){
          if (result.status == 'berhasil') {
            iziToast.success({
              icon: 'fa fa-check',
              message: 'Berhasil Disimpan!',
            });
            setTimeout(function () {
                          window.location.href = baseUrl + '/purchase/belanjalangsung/belanjalangsung';
                      }, 500);
          } else {
            iziToast.warning({
              icon: 'fa fa-times',
              message: 'Gagal Disimpan!',
            });
            setTimeout(function () {
                          waitingDialog.hide();
                      }, 500);
          }
        }
      });
    });

    function total(counter){
      var values = [];
      $(".price").each(function(i, sel){
          var selectedVal = $(sel).val();
          values.push(parseInt(selectedVal.replace('.','')));
      });
      var total = 0;
      for (var i = 0; i < values.length; i++) {
        total += values[i] << 0;
      }

      var qty = $('#qty'+counter).val();
      var hasil = total * qty;

      $('#total'+counter).val(accounting.formatMoney(hasil,"",0,'.',','));
      linetotal();
      ppn_10();
    }

    function linetotal(){
      var values = [];
      $(".total_price").each(function(i, sel){
          var selectedVal = $(sel).val();
          values.push(parseInt(selectedVal.replace('.','')));
      });
      var total = 0;
      for (var i = 0; i < values.length; i++) {
        total += values[i] << 0;
      }

      $('#dbldt_subtotal').val(accounting.formatMoney(total,"",0,'.',','))
    }

    function qtydinamis(counter){
      var price = $('#price'+counter).val();
      var qty = $('#qty'+counter).val();

      var hasil = parseInt(price.replace('.','')) * parseInt(qty.replace('.',''));

      $('#total'+counter).val(accounting.formatMoney(hasil,"",0,'.',','));
      linetotal();
      ppn_10();
    }

</script>
@endsection
