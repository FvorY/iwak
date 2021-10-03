<!DOCTYPE html>
<html lang="en">
<head>
	<!-- set the encoding of your site -->
	<meta charset="utf-8">
	<!-- set the viewport width and initial-scale on mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>iWak Store</title>

	<link rel="shortcut icon" href="{{asset('assets/iwak.jpeg')}}" />
	<!-- include the site stylesheet -->
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic%7cMontserrat:400,700%7cOxygen:400,300,700' rel='stylesheet' type='text/css'>
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="assets/css/bootstrap.css">
  <!-- include the site stylesheet -->
  <link rel="stylesheet" href="assets/css/animate.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="assets/css/icon-fonts.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
@if (session('password'))
<body class="side-col-active">
@else
<body>
@endif
	<!-- main container of all the page elements -->
	<div id="wrapper">
		<!-- Page Loader -->
    <div id="pre-loader" class="loader-container">
      <div class="loader">
        <img src="assets/images/rings.svg" alt="loader">
      </div>
    </div>
		<!-- W1 start here -->
		<div class="w1">
			<!-- mt header style4 start here -->
			<header id="mt-header" class="style17">
				<!-- mt top bar start here -->
				@if(Auth::check())
				<!-- mt top bar start here -->
				<div class="mt-top-bar">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-6 hidden-xs">
								<a href="#" class="tel"> <i aria-hidden="true" class="fa fa-envelope-o"></i> info@schon.chairs</a>
							</div>
							<div class="col-xs-12 col-sm-6 text-right" >
								<!-- mt top lang start here -->
								<div class="mt-top-lang">
									<a href="#" class="lang-opener text-capitalize" style="color:#A1A1A1; font-weight: bold">{{Auth::user()->fullname}}<i class="fa fa-angle-down" aria-hidden="true"></i></a>
									<div class="drop" style="width:100px; font-size:12px">
										<ul>
											<li><a href="#">My Account</a></li>
											<li><a href="{{ url('/logoutmember') }}">Log Out</a></li>
											<form id="logout-form" action="{{ url('/logoutmember') }}" method="post" style="display: none;">
												<input type="hidden" name="id_member" value="{{Auth::user()->id_account}}">
              				{{ csrf_field() }}
          						</form>
										</ul>
									</div>
								</div><!-- mt top lang end here -->
								<span class="account">
									<a href="#" style="color:#A1A1A1">History</a> 
									
								</span>
							</div>
						</div>
					</div>
				</div><!-- mt top bar end here -->
				@endif
				<!-- mt top bar start here -->
				<!-- mt bottom bar start here -->
				<div class="mt-bottom-bar">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<!-- mt logo start here -->
								<div class="mt-logo"><a href="{{url('/')}}">
								<b><h4>iWak Store</h4></b>
								<!-- <img src="images/mt-logo.png" alt="schon"> -->
								</a></div>
								<!-- mt icon list start here -->
								<ul class="mt-icon-list">
									<li class="hidden-lg hidden-md">
										<a href="#" class="bar-opener mobile-toggle">
											<span class="bar"></span>
											<span class="bar small"></span>
											<span class="bar"></span>
										</a>
									</li>
									<li class="drop">
										<a href="#" class="icon-home cart-opener"><span style="margin-bottom: -3px;" class="num">3</span></a>
										<!-- mt drop start here -->
										<div class="mt-drop">
											<!-- mt drop sub start here -->
											<div class="mt-drop-sub">
												<!-- mt side widget start here -->
												<div class="mt-side-widget">
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row total start here -->
													<div class="cart-row-total">
														<span class="mt-total">Add them all</span>
														<span class="mt-total-txt"><a href="#" class="btn-type2">add to CART</a></span>
													</div>
													<!-- cart row total end here -->
												</div><!-- mt side widget end here -->
											</div>
											<!-- mt drop sub end here -->
										</div><!-- mt drop end here -->
										<span class="mt-mdropover"></span>
									</li>
									<li class="drop">
										<a href="#" class="cart-opener">
											<span class="icon-handbag"></span>
											<span class="num">3</span>
										</a>
										<!-- mt drop start here -->
										<div class="mt-drop">
											<!-- mt drop sub start here -->
											<div class="mt-drop-sub">
												<!-- mt side widget start here -->
												<div class="mt-side-widget">
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
															<span class="mt-h-title">Qty: 1</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
															<span class="mt-h-title">Qty: 1</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row start here -->
													<div class="cart-row">
														<a href="#" class="img"><img src="http://placehold.it/75x75" alt="image" class="img-responsive"></a>
														<div class="mt-h">
															<span class="mt-h-title"><a href="#">Marvelous Modern 3 Seater</a></span>
															<span class="price"><i class="fa fa-eur" aria-hidden="true"></i> 599,00</span>
															<span class="mt-h-title">Qty: 1</span>
														</div>
														<a href="#" class="close fa fa-times"></a>
													</div><!-- cart row end here -->
													<!-- cart row total start here -->
													<div class="cart-row-total">
														<span class="mt-total">Sub Total</span>
														<span class="mt-total-txt"><i class="fa fa-eur" aria-hidden="true"></i> 799,00</span>
													</div>
													<!-- cart row total end here -->
													<div class="cart-btn-row">
														<a href="#" class="btn-type2">VIEW CART</a>
														<a href="#" class="btn-type3">CHECKOUT</a>
													</div>
												</div><!-- mt side widget end here -->
											</div>
											<!-- mt drop sub end here -->
										</div><!-- mt drop end here -->
										<span class="mt-mdropover"></span>
									</li>
														@if(Auth::check() == NULL)
									<li>
										 @if (session('password'))
										<a href="#" class="bar-opener side-opener active">
											@else
										<a href="#" class="bar-opener side-opener">
            				@endif

											<span class="bar"></span>
											<span class="bar small"></span>
											<span class="bar"></span>
										</a>
									</li>
									@endif
								</ul><!-- mt icon list end here -->
								<!-- navigation start here -->
								<nav id="nav">
									<ul>
										<li>
											<a class="drop-link" href="{{url('/')}}">HOME <i class="fa fa-angle-down hidden-lg hidden-md" aria-hidden="true"></i></a>

										</li>
										<li>
											<a class="drop-link" href="">Product <i class="fa fa-angle-down" aria-hidden="true"></i></a>
											<div class="s-drop">
												<ul>
													<li><a href="{{ url('/product') }}">For Sale</a></li>
													<li><a href="{{ url('/lelang') }}">For Auction</a></li>
												</ul>
											</div>
										</li>
										<li>
											<a href="{{ url('contact') }}">Contact <i class="fa fa-angle-down hidden-lg hidden-md" aria-hidden="true"></i></a>

										</li>
									</ul>
								</nav>
								<!-- mt icon list end here -->
							</div>
						</div>
					</div>
				</div>
				<!-- mt bottom bar end here -->
				@if (session('password'))
				<span class="mt-side-over active"></span>
				@else
				<span class="mt-side-over"></span>
				@endif
			</header>
			<!-- mt side menu start here -->
			<div class="mt-side-menu">
				<!-- mt holder start here -->
				<div class="mt-holder">
					<a href="#" class="side-close"><span></span><span></span></a>
					<strong class="mt-side-title">MY ACCOUNTss</strong>
					<!-- mt side widget start here -->
					<div class="mt-side-widget">
						<header>
							<span class="mt-side-subtitle">SIGN IN</span>
							<p>Welcome back! Sign in to Your Account</p>
						</header>
						<form class="" autocomplete="off" method="GET" action="{{ url('loginmember') }}">
          {{ csrf_field() }}
							<fieldset>
								<input type="text" placeholder="Username or email address" class="input" name="username">
								 @if (session('username'))
              	<div class="red"  style="color: red"><b>Email Tidak Ada</b></div>
            		@endif
								<input type="password" placeholder="Password" class="input" name="password">
								 @if (session('password'))
              	<div class="red"  style="color: red"><b>Passsword Tidak Ada</b></div>
            		@endif
								<div class="box">
									<span class="left"><input class="checkbox" type="checkbox" id="check1"><label for="check1">Remember Me</label></span>
									<a href="#" class="help">Help?</a>
								</div>
								<button type="submit" class="btn-type1">Login</button>
							</fieldset>
						</form>
					</div>
					<!-- mt side widget end here -->
					<div class="or-divider"><span class="txt">or</span></div>
					<!-- mt side widget start here -->
					<div class="mt-side-widget">
						<header>
							<span class="mt-side-subtitle">CREATE NEW ACCOUNT</span>
							<p>Create your very own account</p>
						</header>
						<form action="#">
							<fieldset>
								<input type="text" placeholder="Username or email address" class="input">
								<button type="submit" class="btn-type1">Register</button>
							</fieldset>
						</form>
					</div>
					<!-- mt side widget end here -->
				</div>
				<!-- mt holder end here -->
			</div><!-- mt side menu end here -->
			<!-- mt search popup start here -->
			<div class="mt-search-popup">
				<div class="mt-holder">
					<a href="#" class="search-close"><span></span><span></span></a>
					<div class="mt-frame">
						<form action="#">
							<fieldset>
								<input type="text" placeholder="Search...">
								<span class="icon-microphone"></span>
								<button class="icon-magnifier" type="submit"></button>
							</fieldset>
						</form>
					</div>
				</div>
			</div><!-- mt search popup end here -->
			<!-- mt header style4 end here -->

            @yield('content')

			<!-- footer of the Page -->
			<footer id="mt-footer" class="style1 wow fadeInUp" data-wow-delay="0.4s">
				<!-- Footer Holder of the Page -->
				<div class="footer-holder dark">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-3 mt-paddingbottomsm">
								<!-- F Widget About of the Page -->
								<div class="f-widget-about">
									<div class="logo">
										<a href="{{url('/')}}">iWak</a>
									</div>
									<p>Exercitation ullamco laboris nisi ut aliquip ex commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

								</div>
								<!-- F Widget About of the Page end -->
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 mt-paddingbottomxs">
								<!-- Footer Tabs of the Page -->
								<div class="f-widget-tabs">
									<h3 class="f-widget-heading">Product Tags</h3>
									<ul class="list-unstyled tabs">
										<li><a href="#">Sofas</a></li>
										<li><a href="#">Armchairs</a></li>
										<li><a href="#">Living</a></li>
										<li><a href="#">Bedroom</a></li>
										<li><a href="#">Lighting</a></li>
										<li><a href="#">Tables</a></li>
										<li><a href="#">Pouf</a></li>
										<li><a href="#">Wood</a></li>
										<li><a href="#">Office</a></li>
										<li><a href="#">Outdoor</a></li>
										<li><a href="#">Kitchen</a></li>
										<li><a href="#">Stools</a></li>
										<li><a href="#">Footstools</a></li>
										<li><a href="#">Desks</a></li>
									</ul>
								</div>
								<!-- Footer Tabs of the Page -->
							</div>
							<div class="col-xs-12 col-sm-6 col-md-3 text-right">
								<!-- F Widget About of the Page -->
								<div class="f-widget-about">
									<h3 class="f-widget-heading">Information</h3>
									<ul class="list-unstyled address-list align-right">
										<li><i class="fa fa-map-marker"></i><address>Connaugt Road Central Suite 18B, 148 <br>New Yankee</address></li>
										<li><i class="fa fa-phone"></i><a href="tel:15553332211">+1 (555) 333 22 11</a></li>
										<li><i class="fa fa-envelope-o"></i><a href="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#110;&#046;&#099;&#104;&#097;&#105;&#114;">&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#110;&#046;&#099;&#104;&#097;&#105;&#114;</a></li>
									</ul>
								</div>
								<!-- F Widget About of the Page end -->
							</div>
						</div>
					</div>
				</div>
				<!-- Footer Holder of the Page end -->
				<!-- Footer Area of the Page -->
				<div class="footer-area">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<p>© <a href="index.html">iWak.</a> - All rights Reserved</p>
							</div>
							{{-- <div class="col-xs-12 col-sm-6 text-right">
								<div class="bank-card">
									<img src="images/bank-card.png" alt="bank-card">
								</div>
							</div> --}}
						</div>
					</div>
				</div>
				<!-- Footer Area of the Page end -->
			</footer><!-- footer of the Page end -->
		</div><!-- W1 end here -->
		<span id="back-top" class="fa fa-arrow-up"></span>
	</div>
	<!-- include jQuery -->
	<script src="assets/js/jquery.js"></script>
	<!-- include jQuery -->
	<script src="assets/js/plugins.js"></script>
	<!-- include jQuery -->
	<script src="assets/js/jquery.main.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

</body>
</html>
