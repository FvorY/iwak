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
									<!-- Comment List of the Page -->
									<ul class="list-unstyled comment-list">
										<li><a href="#"><i class="fa fa-heart"></i>27</a></li>
										<li><a href="#"><i class="fa fa-comments"></i>12</a></li>
										<li><a href="#"><i class="fa fa-share-alt"></i>14</a></li>
									</ul>
									<!-- Comment List of the Page end -->
									<!-- Product Slider of the Page -->
									<div class="product-slider">
                                    @foreach ($image as $img)
										<div class="slide">
											<img src="{{url('/')}}/{{$img->image}}" alt="image descrption">
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
									<!-- Breadcrumbs of the Page -->
									<ul class="list-unstyled breadcrumbs">
										<li><a href="#">Chairs <i class="fa fa-angle-right"></i></a></li>
										<li>Products</li>
									</ul>
									<!-- Breadcrumbs of the Page end -->
									<h2>{{$list->name}}</h2>
									<!-- Rank Rating of the Page -->
									<div class="rank-rating">
										<span class="total-price">Reviews (12)</span>
										<ul class="list-unstyled rating-list">
											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star"></i></a></li>
											<li><a href="#"><i class="fa fa-star-o"></i></a></li>
										</ul>
									</div>
									<!-- Rank Rating of the Page end -->
									<div class="text-holder">
										<span class="price">Rp. {{$list->price}}<del>399,00</del></span>
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
                                                <button type="submit" >Add to Cart</button>
											</div>
                                            @endif
										</fieldset>
									</form>
									<div class="txt-wrap">
										<p>{{$list->description}}</p>
										
									</div>
									<!-- Product Form of the Page end -->
									<ul class="list-unstyled list">
										<li><a href="#"><i class="fa fa-share-alt"></i>SHARE</a></li>
										<!-- <li><a href="#"><i class="fa fa-exchange"></i>COMPARE</a></li> -->
										<li><a href="#"><i class="fa fa-heart"></i>ADD TO WISHLIST</a></li>
									</ul>
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
									<li><a href="#tab2">INFORMATION</a></li>
									<li><a href="#tab3" class="active">REVIEWS (12)</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab1">
										<p>{{$list->description}}</p>
										
									</div>
									<div id="tab2">
										<p>Koila is a chair designed for restaurants and food lovers in general. Designed in collaboration with restaurant professionals, it ensures comfort and an ideal posture, as there are armrests on both sides of the chair. </p>
										<p>Koila is a seat designed for restaurants and gastronomic places in general. Designed in collaboration with professional of restaurants and hotels field, this armchair is composed of a curved shell with a base in oak who has pinched the back upholstered in fabric or leather. It provides comfort and holds for ideal sitting position,the arms may rest on the sides ofthe armchair. <br>Solid oak construction.<br> Back in plywood (2  faces oak veneer) or upholstered in fabric, leather or eco-leather.<br> Seat upholstered in fabric, leather or eco-leather. <br> H 830 x L 585 x P 540 mm.</p>
									</div>
									<div id="tab3">
										<div class="product-comment">
											<div class="mt-box">
												<div class="mt-hold">
													<ul class="mt-star">
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star-o"></i></li>
													</ul>
													<span class="name">John Wick</span>
													<time datetime="2016-01-01">09:10 Nov, 19 2016</time>
												</div>
												<p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit sse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
											</div>
											<div class="mt-box">
												<div class="mt-hold">
													<ul class="mt-star">
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star"></i></li>
														<li><i class="fa fa-star-o"></i></li>
														<li><i class="fa fa-star-o"></i></li>
													</ul>
													<span class="name">John Wick</span>
													<time datetime="2016-01-01">09:10 Nov, 19 2016</time>
												</div>
												<p>Usmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit sse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non</p>
											</div>
											<form action="#" class="p-commentform">
												<fieldset>
													<h2>Add  Comment</h2>
													<div class="mt-row">
														<label>Rating</label>
														<ul class="mt-star">
															<li><i class="fa fa-star"></i></li>
															<li><i class="fa fa-star"></i></li>
															<li><i class="fa fa-star-o"></i></li>
															<li><i class="fa fa-star-o"></i></li>
														</ul>
													</div>
													<div class="mt-row">
														<label>Name</label>
														<input type="text" class="form-control">
													</div>
													<div class="mt-row">
														<label>E-Mail</label>
														<input type="text" class="form-control">
													</div>
													<div class="mt-row">
														<label>Review</label>
														<textarea class="form-control"></textarea>
													</div>
													<button type="submit" class="btn-type4">ADD REVIEW</button>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                @endforeach

				<!-- related products start here -->
				<div class="related-products wow fadeInUp" data-wow-delay="0.4s">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
							<h2>RELATED PRODUCTS</h2>   
								<div class="row">
									<div class="col-xs-12">
										<!-- mt product1 center start here -->
                                        @foreach ($related as $relateds)
										<div class="mt-product1 mt-paddingbottom20">
											<div class="box">
												<div class="b1">
													<div class="b2">
														<a href="product-detail.html"><img src="{{url('/')}}/{{$relateds->image}}" alt="image description"></a>
														<span class="caption">
															<span class="new">NEW</span>
														</span>
														<ul class="mt-stars">
															<li><i class="fa fa-star"></i></li>
															<li><i class="fa fa-star"></i></li>
															<li><i class="fa fa-star"></i></li>
															<li><i class="fa fa-star-o"></i></li>
														</ul>
														<ul class="links">
															<li><a href="#"><i class="icon-handbag"></i><span>Add to Cart</span></a></li>
															<li><a href="#"><i class="icomoon icon-heart-empty"></i></a></li>
															<li><a href="#"><i class="icomoon icon-exchange"></i></a></li>
														</ul>
													</div>
												</div>
											</div>
											<div class="txt">
												<strong class="title"><a href="product-detail.html">{{$relateds->name}}</a></strong>
												<span class="price"><i class="fa fa-eur"></i> <span>287,00</span></span>
											</div>
										</div><!-- mt product1 center end here -->
                                        @endforeach
									</div>
								</div>
							</div>
						</div>
					</div><!-- related products end here -->
				</div>
			</main><!-- mt main end here -->
@endsection