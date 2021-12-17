@extends('layouts.homepage.app_home')

@section('content')
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
										@for($x = 0; $x < $avgfeed ; $x++)
											<li><a href="#"><i class="fa fa-star"></i></a></li>

										@endfor
										@for($x = 5; $x > $avgfeed ; $x--)

											<li><a href="#"><i class="fa fa-star-o"></i></a></li>
										@endfor
										</ul>
									</div>
									<!-- Rank Rating of the Page end -->
									<div class="text-holder">
										@if($list->isdiskon == "Y")
											<?php
											$diskon = ($list->diskon/100)*$list->price;
											$total = $list->price - $diskon
											?>
										<span class="price">{{FormatRupiahFront($total)}}

										@else
										<span class="price">{{FormatRupiahFront($list->price)}}
										@endif
											@if($list->isdiskon == "Y")
											<del>{{FormatRupiahFront($list->price)}}</del>
											@else

											@endif
										</span>
									</div>
									<!-- Product Form of the Page -->
									<form action="#" class="product-form" style="margin-bottom: 40px">
										<fieldset>
                                        @if($list->stock == 0)
											<div class="row-val">
												<label for="qty">qty</label>
												<input type="number" id="qty" placeholder="1" disabled>
											</div>
											<div class="row-val">
												<button type="submit" class="btn btn-secondary" disabled style="background-color:grey;">Out of Stock</button>
											</div>
                                            @else
                                            <div class="row-val">
												<label for="qty">qty</label>
												<input type="number" id="qty" placeholder="1" >
											</div>
											<div class="row-val">
                                                <button type="button" onclick="addtocard({{$list->id_produk}})">Add to Cart</button>
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
												<a href="{{route('profilToko', $list->id_account)}}" class="btn btn-md btn-success">Visit Store</a>
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
									<li><a href="#tab3" class="active">REVIEWS ({{count($feedback)}})</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab3">
										<div class="product-comment">
											@foreach ($feedback as $feedbacks)
											<div class="mt-box">
												<div class="mt-hold">

													<ul class="mt-star">
													@for($x = 0; $x < $feedbacks->star ; $x++)
														<li><i class="fa fa-star"></i></li>

													@endfor
													@for($x = 0; $x < (5 - $feedbacks->star) ; $x++)
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
