@extends('layouts.homepage.app_home')

@section('content')

			<!-- mt main start here -->
			<main id="mt-main">
				<div class="container">
					<div class="row">
						<!-- sidebar of the Page start here -->
						<aside id="sidebar" class="col-xs-12 col-sm-4 col-md-3 wow fadeInLeft" data-wow-delay="0.4s">
							<!-- shop-widget filter-widget of the Page start here -->
							<section class="shop-widget filter-widget bg-grey">
								<h2>FILTER</h2>
								<!-- nice-form start here -->
								<span class="sub-title">Filter keyword, address or store name</span>
								<input type="text" name="keyword" class="form-control" id="keyword" value="{{$keyword}}" placeholder="Input keyword, address, store name">
							</section><!-- shop-widget filter-widget of the Page end here -->
							<!-- shop-widget of the Page start here -->
							<section class="shop-widget">
								<h2>CATEGORIES</h2>
								<!-- category list start here -->
								<ul class="list-unstyled category-list">
									@foreach ($categorydata as $key => $value)
										<li>
											<a href="{{url('/')}}/product?sort=ASC&sortfield=name&category={{$value->id_category}}&keyword={{$keyword}}">
												<span class="name">{{$value->category_name}}</span>
												<span class="num">{{$value->total}}</span>
											</a>
										</li>
									@endforeach
								</ul><!-- category list end here -->
							</section><!-- shop-widget of the Page end here -->
							<!-- shop-widget of the Page start here -->

						</aside><!-- sidebar of the Page end here -->
						<div class="col-xs-12 col-sm-8 col-md-9 wow fadeInRight" data-wow-delay="0.4s">
							<!-- mt shoplist header start here -->
							<header class="mt-shoplist-header">
								<!-- btn-box start here -->
								<div class="btn-box">
									<ul class="list-inline">
										<li>
											<a href="#" class="drop-link">
												{{$sort}} <i aria-hidden="true" class="fa fa-angle-down"></i>
											</a>
											<div class="drop">
												<ul class="list-unstyled">
													<li><a href="{{url('/')}}/product?sort=ASC&sortfield=name&category={{$category}}&keyword={{$keyword}}">ASC</a></li>
													<li><a href="{{url('/')}}/product?sort=DESC&sortfield=name&category={{$category}}&keyword={{$keyword}}">DESC</a></li>
													<li><a href="{{url('/')}}/product?sort=DESC&sortfield=price&category={{$category}}&keyword={{$keyword}}">Highest Price</a></li>
													<li><a href="{{url('/')}}/product?sort=ASC&sortfield=price&category={{$category}}&keyword={{$keyword}}">Lowest Price</a></li>
												</ul>
											</div>
										</li>

									</ul>
								</div><!-- btn-box end here -->
								<div class="mt-textbox">
									<p>Showing  <strong>1–{{$data->perPage()}}</strong> of  <strong>{{$data->total()}}</strong> results</p>
								</div>
							</header><!-- mt shoplist header end here -->
							<!-- mt productlisthold start here -->
							<ul class="mt-productlisthold list-inline">
								@foreach ($data as $key => $value)
									<li>
										<!-- mt product2 start here -->
										<div class="mt-product2 large bg-grey">
											<!-- box start here -->
											<div class="box">
												<img src="{{url('/')}}/{{$value->image}}" style="width:275px; height:290px;" class="imageproduk" alt="{{$value->name}}">
												<span class="caption">
													@if ($value->isdiskon == "Y")
														<span class="off">{{$value->diskon}}% off</span>
													@endif
												</span>
												<ul class="links">
													<li><a onclick="addtocard({{$value->id_produk}})"><i class="icon-handbag"></i></a></li>
													<li><a href="{{route('detailproduct', $value->url_segment)}}"><i class="fa fa-eye"></i></a></li>
												</ul>
											</div><!-- box end here -->
											<!-- txt end here -->
											<div class="txt">
												<strong class="title"><a>{{$value->name}}</a></strong>
												@if ($value->isdiskon == "Y")
													<?php
													$diskonval = $value->price * $value->diskon / 100;
													$res = $value->price - $diskonval;
													?>
													<span class="price"><span>{{FormatRupiahFront($res)}}</span></span> <del>{{$value->price}}</del>
												@else
													<span class="price"><span>{{FormatRupiahFront($value->price)}}</span></span>
												@endif
												<ul class="mt-stars">
													@for ($i=0; $i < $value->starproduk; $i++)
														<li><i class="fa fa-star"></i></li>
													@endfor
													@for ($i=0; $i < (5 - $value->starproduk); $i++)
														<li><i class="fa fa-star-o"></i></li>
													@endfor
												</ul>
												<?php
												$string = $value->address;
												$output = explode(" ",$string);
												?>
												<strong class="title"><a><span class="fa fa-map-marker"></span> {{end($output)}}</a></strong>
												<strong class="title"><a href="{{url('/')}}/toko/{{$value->id_account}}"> <span class="fa fa-store"></span> {{$value->namatoko}}</a></strong>

											</div><!-- txt end here -->
										</div><!-- mt product2 end here -->
									</li>
								@endforeach
							</ul><!-- mt productlisthold end here -->
							<!-- mt pagination start here -->
							<nav class="mt-pagination">
								<ul class="list-inline">

									@if ($data->currentPage() != $data->lastPage())
										<?php
						        $interval = isset($interval) ? abs(intval($interval)) : 3 ;
						        $from = $data->currentPage() - $interval;
						        if($from < 1){
						            $from = 1;
						        }

						        $to = $data->currentPage() + $interval;
						        if($to > $data->lastPage()){
						            $to = $data->lastPage();
						        }
						        ?>

										@if($data->currentPage() > 1)
						            <li>
						                <a href="{{ $data->url(1) }}&sortfield={{$sortfield}}&sort={{$sort}}&category={{$category}}&keyword={{$keyword}}" aria-label="First">
						                    <span aria-hidden="true">&laquo;</span>
						                </a>
						            </li>

						            <li>
						                <a href="{{ $data->url($data->currentPage() - 1) }}&sortfield={{$sortfield}}&sort={{$sort}}&category={{$category}}&keyword={{$keyword}}" aria-label="Previous">
						                    <span aria-hidden="true">&lsaquo;</span>
						                </a>
						            </li>
						        @endif

										{{-- {{ $data->links() }} --}}

										@for($i = $from; $i <= $to; $i++)
											 <?php
											 $isCurrentPage = $data->currentPage() == $i;
											 ?>
											 <li class="{{ $isCurrentPage ? 'active' : '' }}">
													 <a href="{{ !$isCurrentPage ? $data->url($i) : '' }}&sortfield={{$sortfield}}&sort={{$sort}}&category={{$category}}&keyword={{$keyword}}">
															 {{ $i }}
													 </a>
											 </li>
									 @endfor

									 <!-- next/last -->
						        @if($data->currentPage() < $data->lastPage())
						            <li>
						                <a href="{{ $data->url($data->currentPage() + 1) }}&sortfield={{$sortfield}}&sort={{$sort}}&category={{$category}}&keyword={{$keyword}}" aria-label="Next">
						                    <span aria-hidden="true">&rsaquo;</span>
						                </a>
						            </li>

						            <li>
						                <a href="{{ $data->url($data->lastpage()) }}&sortfield={{$sortfield}}&sort={{$sort}}&category={{$category}}&keyword={{$keyword}}" aria-label="Last">
						                    <span aria-hidden="true">&raquo;</span>
						                </a>
						            </li>
						        @endif
									@endif

								</ul>
							</nav><!-- mt pagination end here -->
						</div>
					</div>
				</div>
			</main><!-- mt main end here -->
@endsection

@section('extra_script')
	<script type="text/javascript">
		$("#keyword").on('keyup', function (e) {
			if (e.key === 'Enter' || e.keyCode === 13) {
					window.location.href = "{{url('/')}}/product?sort=ASC&sortfield=name&category={{$category}}&keyword="+$('#keyword').val()+"";
			}
		});
	</script>
@endsection
