@extends('layouts.homepage.app_home')
@include('penjualpesanan.detailpesanan')
@section('content')
<!-- Main of the Page -->
<main id="mt-main">
        <!-- Mt Product Table of the Page -->
        <div class="mt-product-table wow fadeInUp" data-wow-delay="0.4s">
          <div class="container">
            <div class="row border">
              <div class="col-xs-12 col-sm-2">
                <strong class="title">NOTA</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="title">TOTAL</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="title">DATE</strong>
              </div>
              <div class="col-xs-12 col-sm-4">
                <strong class="title">STATUS</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="title">ACTION</strong>
              </div>
            </div>
            @foreach($data as $list)
            <div class="row border">
              <div class="col-xs-12 col-sm-2">
                  <strong class="price" style="font-size: 18px;">{{$list->nota}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="price">{{FormatRupiahFront($list->subtotal)}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="price"> {{date('j F Y', strtotime($list->date))}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                @if($list->pay == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled> Sudah Dibayar </button></strong>
                @elseif($list->deliver == 'P')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled=""> Proses Pengiriman </button></strong>
                @elseif($list->deliver == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled=""> Sudah Dikirim </button></strong>
                @elseif($list->cancelled == 'Y')
                <strong class="price"><button class="btn btn-sm btn-danger" style="margin-bottom: 20px;" disabled=""> Pesanan Dibatalkan </button></strong>
                @elseif($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled> Pesanan Dibuat </button></strong>
                @endif
              </div>
              <div class="col-xs-12 col-sm-1">
                <strong class="price">
                  <!-- <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</button> -->
                  <a onclick="detail({{$list->id_transaction}})" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</a>
                </strong>
              </div>
                @if($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
                <div class="col-xs-12 col-sm-1">
                  <strong class="price"><button type="submit" onclick="cancel({{$list->id_transaction}})" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Cancel Order</button></strong>
                </div>
                <div class="col-xs-12 col-sm-1">
                  <strong class="price"><button type="submit" onclick="pay({{$list->id_transaction}})" class="btn btn-sm btn-success"> <i class="fa fa-money"></i> Upload Bukti Transfer</button></strong>
                </div>
                @else
                  @if ($list->cancelled != "Y" && $list->pay != "Y")
                    <div class="col-xs-12 col-sm-1">
                      <strong class="price"><button type="submit" class="btn btn-sm btn-success" disabled=""> <i class="fa fa-money"></i> Upload pembayaran</button></strong>
                    </div>
                  @endif
                @endif
            </div>
            @endforeach

          </div>
        </div><!-- Mt Product Table of the Page end -->
        <!-- Mt Detail Section of the Page -->

        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end here -->
@endsection

@section('extra_script')
  <script type="text/javascript">

  function detail(id) {
    var html = "";
    $.ajax({
      url: "{{url('/penjual/listorder')}}" + '/detail',
      data:{id},
      dataType:'json',
      success:function(response){

        var subtotal = 0
        for (var i = 0; i < response.length; i++) {

          let detail = response[i];

          subtotal += detail.qty * detail.price;

          html += "<tr>"+
                  "<td> "+(i+1)+" </td>"+
                  "<td> "+detail.name+" </td>"+
                  "<td> "+detail.qty+" </td>"+
                  "<td> "+"Rp. " + accounting.formatMoney(detail.price,"",0,'.',',')+" </td>"+
                  "<td> "+"Rp. " + accounting.formatMoney((detail.qty * detail.price),"",0,'.',',')+" </td>"+
                  "<tr>";
        }

        $('#subtotal').text(accounting.formatMoney(subtotal,"",0,'.',','));
        $('#bodydetail').html(html);
        $('#detailpesanan').modal('show');

      }
    })
  }

  function cancel(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Cancel pesanan',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: "{{url('/penjual/listorder')}}" + '/cancel',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dicancel!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dicancel!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Pesanan Berhasil Dicancel!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pesanan Gagal Dicancel!',
                });
            }


            }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  }
  </script>
@endsection
