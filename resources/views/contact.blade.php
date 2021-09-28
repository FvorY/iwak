@extends('layouts.homepage.app_home')

@section('content')
<!-- mt side menu start here -->
      <div class="mt-side-menu">
        <!-- mt holder start here -->
        <div class="mt-holder">
          <a href="#" class="side-close"><span></span><span></span></a>
          <strong class="mt-side-title">MY ACCOUNT</strong>
          <!-- mt side widget start here -->
          <div class="mt-side-widget">
            <header>
              <span class="mt-side-subtitle">SIGN IN</span>
              <p>Welcome back! Sign in to Your Account</p>
            </header>
            <form action="#">
              <fieldset>
                <input type="text" placeholder="Username or email address" class="input">
                <input type="password" placeholder="Password" class="input">
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
      <!-- Main of the Page -->
      <main id="mt-main">
        <!-- Mt Contact Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url(http://placehold.it/1920x205);">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text-center">
                <h1>CONTACT</h1>
                <nav class="breadcrumbs">
                  <ul class="list-unstyled">
                    <li><a href="index.html">Home <i class="fa fa-angle-right"></i></a></li>
                    <li><a href="#">Contact</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </section><!-- Mt Contact Banner of the Page -->
        <!-- Mt Contact Detail of the Page -->
        <section class="mt-contact-detail content-info wow fadeInUp" data-wow-delay="0.4s">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12 col-sm-8">
                <div class="txt-wrap">
                  <h1>schön. chair maker</h1>
                  <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut <br>enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br>aliquip ex ea commodo consequat. </p>
                </div>
                <ul class="list-unstyled contact-txt">
                  <li>
                    <strong>Address</strong>
                    <address>Suite 18B, 148 Connaught Road <br>Central <br>New Yankee</address>
                  </li>
                  <li>
                    <strong>Phone</strong>
                    <a href="#">+1 (555) 333 22 11</a>
                  </li>
                  <li>
                    <strong>E_mail</strong>
                    <a href="#">info@schon.chair</a>
                  </li>
                </ul>
              </div>
              <div class="col-xs-12 col-sm-4">
                <h2>Have a question?</h2>
                <!-- Contact Form of the Page -->
                <form action="#" class="contact-form">
                  <fieldset>
                    <input type="text" class="form-control" placeholder="Name">
                    <input type="email" class="form-control" placeholder="E-Mail">
                    <input type="text" class="form-control" placeholder="Subject">
                    <textarea class="form-control" placeholder="Message"></textarea>
                    <button class="btn-type3" type="submit">Send</button>
                  </fieldset>
                </form>
                <!-- Contact Form of the Page end -->
              </div>
            </div>
          </div>
        </section><!-- Mt Contact Detail of the Page end -->
        <!-- Mt Map Holder of the Page -->
        <div class="mt-map-holder wow fadeInUp" data-wow-delay="0.4s" data-lat="52.392363" data-lng="1.480408" data-zoom="8">
          <div class="map-info">
            <h2>Sochan</h2>
            <p>Lorem ipsum dolor sit amet...</p>
          </div>
        </div><!-- Mt Map Holder of the Page end -->
      </main>
@endsection