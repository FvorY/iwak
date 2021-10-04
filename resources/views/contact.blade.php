@extends('layouts.homepage.app_home')

@section('content')

      <!-- Main of the Page -->
      <main id="mt-main">
        {{-- <!-- Mt Contact Banner of the Page -->
        <section class="mt-contact-banner wow fadeInUp" data-wow-delay="0.4s" style="background-image: url({{url('/')}}/{{$backgroundheader->image}});">
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
        </section><!-- Mt Contact Banner of the Page --> --}}
        <!-- Mt Contact Detail of the Page -->
        <section class="mt-contact-detail content-info wow fadeInUp" data-wow-delay="0.4s">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12 col-sm-12">
                <div class="txt-wrap">
                  <h1>iWak</h1>
                  <p class="desctext">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut <br>enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br>aliquip ex ea commodo consequat. </p>
                </div>
                <ul class="list-unstyled contact-txt">
                  <li>
                    <strong>Address</strong>
                    <address class="addresstext">Suite 18B, 148 Connaught Road <br>Central <br>New Yankee</address>
                  </li>
                  <li>
                    <strong>E_mail</strong>
                    <a class="mailto" href="mailto"><span class="mailtotext">info@schon.chair</span></a>
                  </li>
                </ul>
              </div>
              {{-- <div class="col-xs-12 col-sm-4">
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
              </div> --}}
            </div>
          </div>
        </section><!-- Mt Contact Detail of the Page end -->
        <!-- Mt Map Holder of the Page -->
        {{-- <div class="mt-map-holder wow fadeInUp" data-wow-delay="0.4s" data-lat="52.392363" data-lng="1.480408" data-zoom="8">
          <div class="map-info">
            <h2>Sochan</h2>
            <p>Lorem ipsum dolor sit amet...</p>
          </div>
        </div><!-- Mt Map Holder of the Page end --> --}}
      </main>
@endsection
