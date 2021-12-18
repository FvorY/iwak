@extends('layouts.homepage.app_home')
@section('content')

@include('modal_sendchat')

  <!-- Modal -->
  <style media="screen">
  .rating {
  display: inline-block;
  position: relative;
  height: 30px;
  line-height: 30px;
  font-size: 30px;
  }

  .rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
  }

  .rating label:last-child {
  position: static;
  }

  .rating label:nth-child(1) {
  z-index: 5;
  }

  .rating label:nth-child(2) {
  z-index: 4;
  }

  .rating label:nth-child(3) {
  z-index: 3;
  }

  .rating label:nth-child(4) {
  z-index: 2;
  }

  .rating label:nth-child(5) {
  z-index: 1;
  }

  .rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  }

  .rating label .icon {
  float: left;
  color: transparent;
  }

  .rating label:last-child .icon {
  color: #000;
  }

  .rating:not(:hover) label input:checked ~ .icon,
  .rating:hover label:hover input ~ .icon {
  color: rgb(249, 201, 31);
  }

  .rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px rgb(249, 201, 31);
  }
  </style>

@include('penjualpesanan.detailpesanan')
@include('pembelihistory.pay')
@include('pembelihistory.ulasan')
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
                @if($list->pay == 'Y' && $list->deliver == "Y")
                <strong class="price"><button class="btn btn-sm btn-primary" style="margin-bottom: 20px;" disabled> Order Complete </button></strong>
                @elseif($list->pay == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled> Already paid </button></strong>
                @elseif($list->deliver == 'P')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled=""> Delivery process </button></strong>
                @elseif($list->deliver == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled=""> Received </button></strong>
                @elseif($list->cancelled == 'Y')
                <strong class="price"><button class="btn btn-sm btn-danger" style="margin-bottom: 20px;" disabled=""> Order Canceled </button></strong>
                @elseif($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled> Order Made </button></strong>
                @endif
              </div>
              <div class="col-xs-12 col-sm-1">
                <strong class="price">
                  <!-- <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</button> -->
                  <a onclick="detail({{$list->id_transaction}})" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</a>
                  <a onclick="showChat({{$list->penjual->id_account}})" class="btn btn-sm btn-info"> <i class="fa fa-comment"></i> Chat Seller </a>
                </strong>
              </div>
                @if($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
                <div class="col-xs-12 col-sm-1">
                  <strong class="price"><button type="submit" onclick="cancel({{$list->id_transaction}})" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Cancel Order</button></strong>
                </div>
                <div class="col-xs-12 col-sm-1">
                  <strong class="price"><button type="submit" onclick="pay(this)" data-id_transaction="{{$list->id_transaction}}" data-namatoko="{{$list->penjual->namatoko}}" data-nomor_rekening="{{$list->penjual->nomor_rekening}}" data-bank="{{$list->penjual->bank}}" class="btn btn-sm btn-success"> <i class="fa fa-money"></i> Upload Payment Proof</button></strong>
                </div>
                @else
                  @if($list->pay == 'Y' && $list->deliver == "Y" && $list->ulasan == null)
                    <div class="col-xs-12 col-sm-1">
                      <strong class="price"><button type="submit" onclick="review({{$list->id_transaction}})" class="btn btn-sm btn-warning"> <i class="fa fa-comment"></i> Send Review?</button></strong>
                    </div>
                  @elseif ($list->deliver == "P")
                    <div class="col-xs-12 col-sm-1">
                      <strong class="price"><button type="submit" onclick="deliverdone({{$list->id_transaction}})" class="btn btn-sm btn-primary"> <i class="fa fa-check"></i> Order Received?</button></strong>
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

  var rating = 0;

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

  function deliverdone(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Order completed',
      message: 'Are you sure ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: "{{url('/penjual/listorder')}}" + '/deliverdone',
            data:{id},
            dataType:'json',
            success:function(response){
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Order Sent!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Order Failed to Deliver!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Order Sent!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Order Failed to Deliver!',
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

  function cancel(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Cancel Order',
  		message: 'Are You Sure ?',
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
                    message: 'Order Successfully Canceled!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Order Failed to Cancel!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Order Successfully Canceled!',
                });
                setTimeout(function(){
                      window.location.reload();
              }, 1000);
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Order Failed to Cancel!',
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

  function pay(parm) {
    $('#namatoko').text($(parm).data("namatoko"));
    $('#nomor_rekening').text($(parm).data("nomor_rekening"));
    $('#bank').text($(parm).data("bank"));
    $('#id_transaction').val($(parm).data("id_transaction"));

    $('#pay').modal('show');
  }

  $('#simpan').click(function(){

  var formdata = new FormData();
  formdata.append('image', $('.uploadGambar')[0].files[0]);
  formdata.append('id', $('#id_transaction').val());

  $.ajax({
    type: "post",
    url: "{{url('/pembeli')}}" + '/pay?_token='+"{{csrf_token()}}",
    data: formdata,
    processData: false, //important
    contentType: false,
    cache: false,
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Proof of Payment Successfully Saved',
        });
        $('#pay').modal('hide');
      }else if(data.status == 2){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Payment Proof Failed to save!, Check your data and connection!',
        });
      }else if (data.status == 3){
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Proof of Payment Successfully Saved',
        });
        $('#pay').modal('hide');
      }else if (data.status == 4){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Payment Proof Failed to Save!',
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

function review(id) {
  rating = 0;
  $('input:checked').attr("checked", false);
  $('#txtulasan').val('');
  $('.image-holder').empty();
  $('#id_transaction').val(id);

  $('#ulasan').modal('show');
}

$(':radio').change(function() {
  rating = this.value;
});

$(".uploadGambar").on('change', function () {
        $('.save').attr('disabled', false);
        // waitingDialog.show();
      if (typeof (FileReader) != "undefined") {
          var image_holder = $(".image-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img style="width: 30px; height: 30px;" src="{{ asset('assets/demo/images/loading.gif')}}" class="img-responsive">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "class": "thumb-image img-responsive",
                      "style": "height: 100px; width:100px; border-radius: 0px;",
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

  $('#simpanulasan').click(function(){

  var formdata = new FormData();
  formdata.append('image', $('#uploadGambar1')[0].files[0]);
  formdata.append('rating', rating);
  formdata.append('id', $('#id_transaction').val());

  $.ajax({
    type: "post",
    url: "{{url('/pembeli')}}" + '/inputulasan?_token='+"{{csrf_token()}}&"+$('.table_modalulasan :input').serialize(),
    data: formdata,
    processData: false, //important
    contentType: false,
    cache: false,
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Review Successfully Saved!',
        });
        setTimeout(function(){
              window.location.reload();
      }, 1000);
      }else if(data.status == 2){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Review Failed to save!, Check your data and connection!',
        });
      }else if (data.status == 3){
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Review Successfully Saved!',
        });
        setTimeout(function(){
              window.location.reload();
      }, 1000);
      }else if (data.status == 4){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Review Failed to save!',
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

function showChat(id) {
  $("#message-text").val("");
  $("#idtoko").val(id);
  $("#modalchat").modal("show");
}

$("#simpanmessage").on('click', function() {
  let message = $('#message-text').val();
  let idtoko = $("#idtoko").val();

  $.ajax({
    url: "{{url('/')}}" + "/newchat",
    data: {idtoko: idtoko, message: message},
    success: function(data) {
      window.location.href = "{{url('/')}}/chat";
    }
  });
})

  </script>
@endsection
