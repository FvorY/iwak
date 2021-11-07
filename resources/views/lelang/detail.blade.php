@extends('layouts.homepage.app_home')

@section('content')
@include('lelang.formbid')
@include('lelang.buylelang')
<!-- mt main start here -->
<main id="mt-main">
                    @foreach ($data as $list)
				<!-- Mt Product Detial of the Page -->
				<section class="mt-product-detial wow fadeInUp" data-wow-delay="0.4s">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<!-- Slider of the Page -->
								<div class="slider">
									<br>
									<br>
									<!-- Product Slider of the Page -->
									<div class="product-slider">
                                    @foreach ($image as $img)
										<div class="slide">
											<img src="{{url('/')}}/{{$img->image}}" class="imageproduk" style="width:100%; height: 35vw;object-fit: cover;" alt="{{$img->name}}">
										</div>
										<!-- <div class="slide">
											<img src="http://placehold.it/610x490" alt="image descrption">
										</div>
										<div class="slide">
											<img src="http://placehold.it/610x490" alt="image descrption">
										</div>
										<div class="slide">
											<img src="http://placehold.it/610x490" alt="image descrption">
										</div>
                                        <div class="slide">
											<img src="http://placehold.it/610x490" alt="image descrption">
										</div> -->
                                        @endforeach
									</div>

									<!-- Product Slider of the Page end -->
									<!-- Pagg Slider of the Page -->
									<ul class="list-unstyled slick-slider pagg-slider">
                                        @foreach ($image as $img)

										<li><div class="img"><img src="{{url('/')}}/{{$img->image}}"class="imageproduk" style="height: 8vw;object-fit: cover;" alt="{{$img->name}}"></div></li>
										<!-- <li><div class="img"><img src="http://placehold.it/105x105" alt="image description"></div></li>
										<li><div class="img"><img src="http://placehold.it/105x105" alt="image description"></div></li>
										<li><div class="img"><img src="http://placehold.it/105x105" alt="image description"></div></li>
										<li><div class="img"><img src="http://placehold.it/105x105" alt="image description"></div></li> -->
                                        @endforeach
									</ul>
									<!-- Pagg Slider of the Page end -->
								</div>
								<!-- Slider of the Page end -->
								<!-- Detail Holder of the Page -->
								<div class="detial-holder">

									<h2>{{$list->name}}</h2>
									<!-- Rank Rating of the Page -->
									<div class="rank-rating">
										<span class="total-price">Reviews ({{count($feedback)}})</span>
										<ul class="list-unstyled rating-list">
										@for($x = 0; $x < $list->star ; $x++)
											<li><a href="#"><i class="fa fa-star"></i></a></li>

										@endfor
										@for($x = 5; $x > $list->star ; $x--)

											<li><a href="#"><i class="fa fa-star-o"></i></a></li>
										@endfor
										</ul>
									</div>
									<!-- Rank Rating of the Page end -->
									<div class="text-holder">

										<span class="price"><span id="pricebid">{{FormatRupiahFront($list->price)}}</span>
											<span style="font-size:18px; color:#B8B8B8"> &nbsp;&nbsp;Start From</span>

										</span>
									</div>
									<!-- Product Form of the Page -->
									<form action="#" class="product-form" style="margin-bottom: 40px">
										<fieldset id="btnbid">
                      @if(Auth::check())

                        @if ($list->isactive == "N")
                          <div class="row-val">
    												<button type="submit" class="btn btn-secondary" disabled style="background-color:grey;">Bidding Closed</button>
    											</div>
                        @else
                          <div class="row-val">
                            <button type="button" onclick="addbid({{$list->id_lelang}})">Next Bid</button>
    											</div>
                        @endif

                      @else

  											<div class="row-val">
                          <button type="button" onclick="addbid({{$list->id_lelang}})" disabled style="background-color:grey;">Next Bid</button>
  											</div>

                      @endif
										</fieldset>
									</form>
									<div class="txt-wrap">
										<p>{{$list->description}}</p>

									</div>

								</div>
								<!-- Detail Holder of the Page end -->
							</div>
						</div>
					</div>
				</section><!-- Mt Product Detial of the Page end -->
				<!-- profile toko -->
				<br>
				<div class="container-fluid" style="background-color:#F6F6F6;width:100%;padding:30px 0">
					<div class="row">
						<div class="col-xs-12">
							<div class="container">
								<div class="row">
									<div class="col-xs-4"></div>
									<div class="col-xs-2">
									<center>
									<img src="{{url('/')}}/{{$list->profile_toko}}"class=" img-circle" style="width:70% ;height: 9vw;border-radius:50%" alt="{{$list->profile_toko}}">
									</center>
									</div>
									<div class="col-xs-4">
										<div class="row">
											<div class="col-xs-12">
												<h2>{{$list->namatoko}}</h2>
											</div>
											<div class="col-xs-12">
												<a href="{{route('profilToko', $list->id_account)}}" class="btn btn-md btn-success">Kunjungi Toko</a>
											</div>
										</div>
									</div>
									<div class="col-xs-5"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- end profil toko -->
				<div class="product-detail-tab wow fadeInUp" data-wow-delay="0.4s">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<ul class="mt-tabs text-center text-uppercase">
									<li><a href="#tab1">DESCRIPTION</a></li>
									<li><a href="#tab3" class="active">REVIEWS ({{count($feedback)}})</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab1">
										<p>{{$list->description}}</p>

									</div>
									<div id="tab3">
										<div class="product-comment">
											@foreach ($feedback as $feedbacks)
											<div class="mt-box">
												<div class="mt-hold">

													<ul class="mt-star">
													@for($x = 0; $x < $feedbacks->star ; $x++)
														<li><i class="fa fa-star"></i></li>

													@endfor
													@for($x = 5; $x > $feedbacks->star ; $x--)

														<li><i class="fa fa-star-o"></i></li>
													@endfor
														<!-- <li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star-o"></i></li> -->
													</ul>

													<span class="name">{{$feedbacks->fullname}}</span>
													<time datetime="2016-01-01">{{date("j M Y", strtotime($feedbacks->created_at))}}</time>
												</div>
												<p>{{$feedbacks->feedback}}</p><br>
												@if ($feedbacks->image != "")
													<a href="{{url('/')}}/{{$feedbacks->image}}" target="_blank">
													<img src="{{url('/')}}/{{$feedbacks->image}}" class="imageproduk" style="width:18%; height: 8vw;" alt="{{$feedbacks->image}}">
													</a>
													@endif
											</div>
											@endforeach

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                @endforeach

			</main><!-- mt main end here -->
@endsection

@section('extra_script')
  <script type="text/javascript">
  @if (Auth::check())

  $.ajax({
    url: "{{url('/')}}" + "/updateprice",
    data: {id: "{{$list->id_lelang}}"},
    success: function(data) {
        $('#pricebid').text("Rp. " + accounting.formatMoney(data.price,"",0,'.',','));

          if (data.lastbid.id_account == "{{Auth::user()->id_account}}") {
              $('#btnbid').html('<button type="button" disabled style="background-color:grey;" onclick="addbid({{$list->id_lelang}})">Next Bid</button>')
          }

          if (data.pemenang.id_account == "{{Auth::user()->id_account}}") {
              $('#btnbid').html('<button type="button" onclick="buylelang({{$list->id_lelang}})">Anda pemenang, Beli sekarang?</button>')
          }
    }
  });

  setInterval(function(){

    $.ajax({
      url: "{{url('/')}}" + "/updateprice",
      data: {id: "{{$list->id_lelang}}"},
      success: function(data) {
          $('#pricebid').text("Rp. " + accounting.formatMoney(data.price,"",0,'.',','));

            if (data.lastbid.id_account == "{{Auth::user()->id_account}}") {
                $('#btnbid').html('<button type="button" disabled style="background-color:grey;" onclick="addtocard({{$list->id_produk}})">Next Bid</button>')
            }

            if (data.pemenang.id_account == "{{Auth::user()->id_account}}") {
                $('#btnbid').html('<button type="button" onclick="buylelang({{$list->id_lelang}})">Anda pemenang, Beli sekarang?</button>')
            }
      }
    });

  }, 3000);

  function addbid(id) {
    $('.price').val('');
    $('.id').val(id);
    $('#formbid').modal('show');
  }

  function buylelang(id) {
    $('#namatoko').text("{{$list->namatoko}}");
    $('#bankname').text("{{$list->bank}}");
    $('#nomor_rekening').text("{{$list->nomor_rekening}}");
    $('#buylelang').modal('show');
  }

  $('#simpan').click(function(){
  $.ajax({
    type: "get",
    url: "{{url('/')}}" + '/addbid?_token='+"{{csrf_token()}}&"+$('.table_modal :input').serialize(),
    processData: false, //important
    contentType: false,
    cache: false,
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Data Berhasil Disimpan!',
        });
        $('#formbid').modal('hide');
      }else if(data.status == 2){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Data Gagal disimpan!, Periksa data dan koneksi anda!',
        });
      }else if (data.status == 3){
        iziToast.success({
            icon: 'fa fa-save',
            message: 'Data Berhasil Diubah!',
        });
        $('#formbid').modal('hide');
      }else if (data.status == 4){
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Data Gagal Diubah!',
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

$('#simpanbuy').click(function(){

var formdata = new FormData();
formdata.append('image', $('.uploadGambar')[0].files[0]);

// console.log(arridproduk);
formdata.append('arridproduk', "[{{$list->id_produk}}]");
formdata.append('arrprice', "[{{$list->price}}]");
formdata.append('arrqty', "[1]");
formdata.append('id_lelang', "{{$list->id_lelang}}");

$.ajax({
  type: "post",
  url: "{{url('/')}}" + '/checkoutlelang?_token='+"{{csrf_token()}}&"+"id_penjual={{$list->id_account}}&subtotal={{$list->price}}",
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


  @endif
  </script>
@endsection
