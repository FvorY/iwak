@extends('layouts.homepage.app_home')

@section('content')

  <main id="mt-main">
    <!-- Mt Process Section of the Page -->
    <div class="mt-process-sec wow fadeInUp" data-wow-delay="0.4s">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <ul class="list-unstyled process-list">
              <li class="active" id="part1">
                <span class="counter">01</span>
                <strong class="title">Shopping Cart</strong>
              </li>
              <li id="part2">
                <span class="counter">02</span>
                <strong class="title">Check Out</strong>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- Mt Process Section of the Page end -->
    <!-- Mt Product Table of the Page -->
    <div class="mt-product-table wow fadeInUp iditempart1" data-wow-delay="0.4s">
      <div class="container">
        <div class="row border">
          <div class="col-xs-12 col-sm-6">
            <strong class="title">PRODUCT</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">PRICE</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">QUANTITY</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">TOTAL</strong>
          </div>
        </div>

        @foreach ($cart as $key => $value)
          <div class="row border">
            <div class="col-xs-12 col-sm-2">
              <div class="img-holder">
                <img src="{{url('/')}}/{{$value->image}}" alt="image" style="width:105px; height:105px;" class="img-responsive">
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <strong class="product-name">{{$value->name}}</strong>
              <input type="hidden" class="id_produk" name="id_produk[]" value="{{$value->id_produk}}">
            </div>
            <div class="col-xs-12 col-sm-2">
              <strong class="price">{{FormatRupiahFront($value->price)}}</strong>
              <input type="hidden" id="priceproduk{{$value->id_cart}}" name="price[]" class="priceproduk" value="{{$value->price}}">
            </div>
            <div class="col-xs-12 col-sm-2">
              <form class="qyt-form">
                <fieldset>
                  <input type="number" name="qty[]" onkeyup="qtychange({{$value->id_cart}})" id="qtyvalue{{$value->id_cart}}" class="form-control qtyvalue" style="font-weight:bold; font-size: 20px;" value="{{$value->qty}}">
                </fieldset>
              </form>
            </div>
            <div class="col-xs-12 col-sm-2">
              <strong class="price" id="pricetotal{{$value->id_cart}}">{{FormatRupiahFront($value->price * $value->qty)}}</strong>
              <input type="hidden" class="hiddenpricetotal" id="hiddenpricetotal{{$value->id_cart}}" name="hiddenpricetotal[]" value="{{$value->price * $value->qty}}">
              <a onclick="closecart({{$value->id_cart}})"><i class="fa fa-close"></i></a>
            </div>
          </div>

          @php
            $total = $value->price * $value->qty;
          @endphp
        @endforeach

      </div>
    </div><!-- Mt Product Table of the Page end -->
    <!-- Mt Detail Section of the Page -->
    <section class="mt-detail-sec style1 wow fadeInUp iditempart1" data-wow-delay="0.4s">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <h2>CART TOTAL</h2>
            <ul class="list-unstyled block cart">
              <li style="border-bottom: none;">
                <div class="txt-holder">
                  <strong class="title sub-title pull-left">CART TOTAL</strong>
                  <div class="txt pull-right">
                    <span id="totalcart">{{FormatRupiahFront($total)}}</span>
                  </div>
                </div>
              </li>
            </ul>
            <a onclick="changepart()" class="process-btn">PROCEED TO CHECKOUT <i class="fa fa-check"></i></a>
          </div>
        </div>
      </div>
    </section>

    <section class="mt-detail-sec toppadding-zero wow fadeInUp iditempart2" data-wow-delay="0.4s" style="display:none;">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="holder">
              <h2>YOUR ORDER</h2>
              <ul class="list-unstyled block">
                <li>
                  <div class="txt-holder">
                    <div class="text-wrap pull-left">
                      <strong class="title">PRODUCTS</strong>
                      @foreach ($cart as $key => $value)
                        <span>{{$value->name}}       <label id="label{{$value->id_cart}}"> x{{$value->qty}}</label></span>
                      @endforeach
                    </div>
                    <div class="text-wrap txt text-right pull-right">
                      <strong class="title">TOTALS</strong>
                      @foreach ($cart as $key => $value)
                        <span id="totalperitem{{$value->id_cart}}">{{FormatRupiahFront($value->price * $value->qty)}}</span>
                      @endforeach
                    </div>
                  </div>
                </li>
                <li style="border-bottom: none;">
                  <div class="txt-holder">
                    <strong class="title sub-title pull-left">ORDER TOTAL</strong>
                    <div class="txt pull-right">
                      <span id="ordertotal">{{FormatRupiahFront($total)}}</span>
                    </div>
                  </div>
                </li>
              </ul>
              <h2>PAYMENT</h2>
              <!-- Panel Group of the Page -->
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="alert alert-warning" role="alert">
                  <h4> Mohon upload bukti pembayaran dengan benar, dan transfer sesuai dengan informasi bank dibawah ini dan transfer sesuai dengan total pembelian. </h4>
                </div>
                <!-- Panel Panel Default of the Page -->

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      STORE NAME : {{$cart[0]->namatoko}}
                    </h4>
                  </div>
                </div>


                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      BANK NAME : {{$cart[0]->bank}}
                    </h4>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      NO ACCOUNT : {{$cart[0]->nomor_rekening}}
                    </h4>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
      								<input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">


                    </h4>
                  </div>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                      <div class="col-md-8 col-sm-6 col-xs-12 image-holder" id="image-holder">

                          {{-- <img src="#" class="thumb-image img-responsive" height="100px" alt="image" style="display: none"> --}}

                      </div>
                    </h4>
                  </div>
                </div>
              </div>
              <!-- Panel Group of the Page end -->
            </div>
            <a class="process-btn save" id="simpan">PROCEED TO CHECKOUT <i class="fa fa-check"></i></a>
          </div>
        </div>
      </div>
    </section>
    <!-- Mt Detail Section of the Page end -->
  </main>

@endsection

@section('extra_script')
<script type="text/javascript">

function closecart(id) {

  $('#cartrow'+id).css('display','none');

  $.ajax({
    url: "{{url('/')}}" + "/deletecart",
    data: {id},
    success: function(data) {
        window.location.reload();
    }
  });
}

function qtychange(id) {
   let qty = $('#qtyvalue'+id).val();
   let price = $('#priceproduk'+id).val();

   let total = qty * price;

   $('#label'+id).text(" x"+qty);
   $('#pricetotal'+id).text("Rp. " + accounting.formatMoney(total,"",0,'.',','));

   $('#totalperitem'+id).text("Rp. " + accounting.formatMoney(total,"",0,'.',','));

   $('#hiddenpricetotal'+id).val(total);

    var arr = $('.hiddenpricetotal').map(function() {
        return parseInt(this.value);
    }).get();

   $('#totalcart').text("Rp." + accounting.formatMoney(arr.reduce(sum),"",0,'.',','));
   $('#ordertotal').text("Rp." + accounting.formatMoney(arr.reduce(sum),"",0,'.',','));
}

function sum(total, num) {
  return total + num;
}

function changepart() {
  $('.iditempart1').css('display', 'none');

  $('.iditempart2').css('display', '');

  $('#part2').attr('class', 'active');
}

$(".uploadGambar").on('change', function () {
        $('.save').attr('disabled', false);
        // waitingDialog.show();
      if (typeof (FileReader) != "undefined") {
          var image_holder = $(".image-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/demo/images/loading.gif') }}" class="img-responsive" style="width: 100px; height: 100px;">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "style": "height: 200px; width:200px; border-radius: 0px;",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);

          // waitingDialog.hide();
      } else {
          // waitingDialog.hide();
          alert("This browser does not support FileReader.");
      }
  });

  $('#simpan').click(function(){

  var formdata = new FormData();
  formdata.append('image', $('.uploadGambar')[0].files[0]);

  var arridproduk = $('.id_produk').map(function() {
      return this.value;
  }).get();

  var arrprice = $('.priceproduk').map(function() {
      return this.value;
  }).get();

  var arrqty = $('.qtyvalue').map(function() {
      return this.value;
  }).get();

  // console.log(arridproduk);
  formdata.append('arridproduk', JSON.stringify(arridproduk));
  formdata.append('arrprice', JSON.stringify(arrprice));
  formdata.append('arrqty', JSON.stringify(arrqty));

  console.log(formdata);

  $.ajax({
    type: "post",
    url: "{{url('/')}}" + '/checkout?_token='+"{{csrf_token()}}&"+"id_penjual={{$cart[0]->id_account}}&subtotal="+$('#ordertotal').text(),
    data: formdata,
    processData: false, //important
    contentType: false,
    cache: false,
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Pesanan Berhasil Disimpan!',
        });

        setTimeout(function(){
              window.location.href = "{{url('/')}}"
      }, 1000);
      }else if(data.status == 2){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Pesanan Gagal disimpan!, Periksa data dan koneksi anda!',
        });
      }else if (data.status == 3){
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Pesanan Berhasil Disimpan!',
        });

        setTimeout(function(){
              window.location.href = "{{url('/')}}"
      }, 1000);
      }else if (data.status == 4){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Pesanan Gagal Disimpan!',
        });
      } else if (data.status == 7) {
        iziToast.warning({
            icon: 'fa fa-info',
            message: data.message,
        });
      }

    }
  });
})

</script>

@endsection
