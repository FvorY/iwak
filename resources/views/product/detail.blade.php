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

										<li><div class="img"><img src="{{url('/')}}/{{$img->image}}" alt="image description"></div></li>
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

											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star-o"></i></a></li>
										</ul>
									</div>
									<!-- Rank Rating of the Page end -->
									<div class="text-holder">
										@if($list->isdiskon == "Y")
											<?php
											$price = ($list->diskon/100)*$list->price;
											?>
										<span class="price">{{FormatRupiahFront($price)}}

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
												<a onclick="addtocard({{$list->id_produk}})">
                                                <button type="submit" >Add to Cart</button>
												</a>
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
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star-o"></i></li>
													</ul>
													<span class="name">{{$feedbacks->fullname}}</span>
													<time datetime="2016-01-01">{{date("j M Y", strtotime($feedbacks->created_at))}}</time>
												</div>
												<p>{{$feedbacks->feedback}}</p>
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