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
          <li class="breadcrumb-item active" aria-current="page">Custom Belanja Langsung</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <form id="form-save">
              <input type="hidden" name="id" value="{{$id}}">
              <div class="card-body">
                <h4 class="card-title">Custom Belanja Langsung</h4>
                <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="row">
                            <div class="col-md-2 col-sm-6 col-xs-12">
                              <label>Shop Name</label>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" name="storename" style="text-transform:uppercase;" class="form-control" value="{{$custom[0]->blc_shop_name}}">
                                  </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Date</label>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <input type="text" class="form-control form-control-sm datepicker_today1" name="dbl_date" value="{{Carbon\Carbon::parse($custom[0]->blc_date)->format('d-m-Y')}}">
                            </div>
                          </div>

                <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
                  <div class="col-md-3 col-sm-6 col-xs-12">

                  <label>Item</label>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" name="item" style="text-transform:uppercase;" class="form-control" id="dbldt_item">
                    </div>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12">
                    <label>Price</label>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm mask" name="" id="dbldt_price">
                    </div>
                  </div>
                  <div class="col-md-1 col-sm-12 col-xs-12">
                    <label>Qty</label>
                  </div>
                  <div class="col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm hanya_angka" name="qty" id="dbldt_qty">
                    </div>
                  </div>
                </div>

               <div class="table-responsive" style="margin-bottom: 15px;">
                 <table class="table table-bordered table-hover" cellspacing="0" id="t80b">
                   <thead class="bg-gradient-info">
                     <tr>
                       <th width="30%">Item Name</th>
                       <th>Qty Requested</th>
                       <th>Unit Price</th>
                       <th>Total</th>
                       <th>Action</th>
                     </tr>
                   </thead>
                   <tbody>
                     @foreach ($customdt as $key => $value)
                       <tr>
                         <td><input type="text" name="nama[]" id="namaitem" data="{{$value->blcd_item}}" style="text-transform:uppercase;" class="form-control namaitem form-control-sm" value="{{$value->blcd_item}}" readonly></td>
                         <td><input type="text" name="qty[]" onkeyup="qtydinamis({{$key}})" class="form-control form-control-sm" id="qty{{$key}}" value="{{$value->blcd_qty}}"></td>
                         <td><input type="text" name="price[]" onkeyup="total({{$key}})" class="price form-control rp" id="price{{$key}}" value="{{number_format($value->blcd_price,0,',','.')}}"></td>
                         <td><input type="text" name="total[]" class="form-control form-control-sm total_price" id="total{{$key}}" value="{{number_format($value->blcd_total,0,',','.')}}" readonly></td>
                         <td><center><button type="button" class="delete btn btn-outline-danger icon-btn btn-sm"><i class="fa fa-trash"></i></button></center></td>
                       </tr>
                       <input type="hidden" name="key" value="{{$key}}">
                     @endforeach
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
                        <input type="text" class="form-control form-control-sm right dbldt_subtotal" readonly="" name="po_subtotal" id="dbldt_subtotal" value="{{number_format($custom[0]->blc_subtotal,0,',','.')}}">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Sales Tax</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right rp format_money dbldt_tax" name="dbldt_tax" id="dbldt_tax" value="{{number_format($custom[0]->blc_tax,0,',','.')}}">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                      <label>Total</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm right format_money total_net" readonly="dbldt_total_net" name="total_net" id="total_net" value="{{number_format($custom[0]->blc_totalnet,0,',','.')}}">
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
</div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">

  $(document).ready(function() {

  $("#dbldt_item").autocomplete({
    source: baseUrl + '/purchase/belanjalangsung/autocomplete',
    select: function(event, ui) {
      $('#dbldt_item').val(ui.item.label);
      $('#dbldt_price').val(accounting.formatMoney(ui.item.id,"",0,'.',','));
    }
  });

    $('.rp').mask('000.000.000.000.000', {reverse: true});

    var counter = $('input[name=key]').val();
    var table           = $("#t80b").DataTable();
    var dbldt_qty         = $("#dbldt_qty");
    var dbldt_price         = $("#dbldt_price");
    var dbldt_kodeitem       = $("#dbldt_item");

    $('#dbldt_qty').keypress(function(e){
      if (e.which == 13 || e.keyCode == 13) {

      var qty = dbldt_qty.val();
      var harga_1 = dbldt_price.val();

      qty = qty.replace(/[^0-9\-]+/g,"");
      harga_1 = harga_1.replace(/[^0-9\-]+/g,"");

      var total = parseInt(harga_1)*parseInt(qty);

      var i_name  = $('#dbldt_item').val();
      var i_price = $('#dbldt_price').val();
      var i_qty   = $('#dbldt_qty').val();

      var find = $('.namaitem').val();

      if (find == undefined) {
        find = '';
      }

      if (i_name != '' || i_price != '') {
        if (find.toString().toUpperCase() == i_name.toString().toUpperCase()) {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Sudah ada item yang sama!, coba pilih item yang berbeda :)',
          });
        } else {
          table.row.add( [
              '<input type="text" name="nama[]" id="namaitem" data="'+i_name+'" style="text-transform:uppercase;" class="form-control namaitem form-control-sm" value="'+i_name+'" readonly>',
              '<input type="text" name="qty[]" onkeyup="qtydinamis('+counter+')" class="form-control form-control-sm" id="qty'+counter+'" value="'+i_qty+'">',
              '<input type="text" name="price[]" onkeyup="total('+counter+')" class="price form-control rp" id="price'+counter+'" value="'+i_price+'">',
              '<input type="text" name="total[]" class="form-control form-control-sm total_price" id="total'+counter+'" value="'+accounting.formatMoney(total,"",0,'.',',')+'" readonly>',
              '<center><button type="button" class="delete btn btn-outline-danger icon-btn btn-sm"><i class="fa fa-trash"></i></button></center>'

          ] ).draw( false );
        }
      } else {
        iziToast.warning({
          icon: 'fa fa-times',
          message: 'Item, Price, Harus terisi :)',
        });
      }

        $('.rp').mask('000.000.000.000.000', {reverse: true});
        counter++;
        $('#dbldt_qty').val('');
        $('#dbldt_price').val('');
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

        var total_sub   = $('.dbldt_subtotal').val();
        total_sub       = total_sub.replace(/[^0-9\-]+/g,"")*1;
        var tax = 0.1;

        var hasiltax = parseInt(total_sub) * tax;

        var hasil = parseInt(total_sub) + parseInt(hasiltax);

        $('#dbldt_tax').val(accounting.formatMoney(hasiltax,"",0,'.',','));
        $('#total_net').val(accounting.formatMoney(hasil,"",0,'.',','));

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


        var kurang_total = parseInt(total)-parseInt(total_price_seq);
        var total_net = parseInt(total)-parseInt(total_price_seq);

        $("#dbldt_subtotal").val(accounting.formatMoney(kurang_total,"",0,'.',','));
        $("#total_net").val(accounting.formatMoney(total_net,"",0,'.',','));

        var total_sub   = $('.dbldt_subtotal').val();
        total_sub       = total_sub.replace(/[^0-9\-]+/g,"")*1;
        var tax = 0.1;

        var hasiltax = parseInt(total_sub) * tax;

        var hasil = parseInt(total_sub) + parseInt(hasiltax);

        $('#dbldt_tax').val(accounting.formatMoney(hasiltax,"",0,'.',','));
        $('#total_net').val(accounting.formatMoney(hasil,"",0,'.',','));

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


    $('#save_data').on('click', function(){
      waitingDialog.show();
      $.ajax({
        type: 'get',
        data: $('#form-save').serialize(),
        url: baseUrl + '/purchase/belanjalangsung/customupdate',
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
      var total_sub   = $('.dbldt_subtotal').val();
      total_sub       = total_sub.replace(/[^0-9\-]+/g,"")*1;
      var tax = 0.1;

      var hasiltax = parseInt(total_sub) * tax;

      var hasil = parseInt(total_sub) + parseInt(hasiltax);

      $('#dbldt_tax').val(accounting.formatMoney(hasiltax,"",0,'.',','));
      $('#total_net').val(accounting.formatMoney(hasil,"",0,'.',','));
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
      var total_sub   = $('.dbldt_subtotal').val();
      total_sub       = total_sub.replace(/[^0-9\-]+/g,"")*1;
      var tax = 0.1;

      var hasiltax = parseInt(total_sub) * tax;

      var hasil = parseInt(total_sub) + parseInt(hasiltax);

      $('#dbldt_tax').val(accounting.formatMoney(hasiltax,"",0,'.',','));
      $('#total_net').val(accounting.formatMoney(hasil,"",0,'.',','));
    }

    $('.mask').maskMoney({thousands:'.', decimal:',', precision:0});

</script>
@endsection
