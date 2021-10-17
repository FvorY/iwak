@extends('layouts.homepage.app_home')

@section('content')

  <main id="mt-main">
    <!-- Mt Process Section of the Page -->
    <div class="mt-process-sec wow fadeInUp" data-wow-delay="0.4s">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <ul class="list-unstyled process-list">
              <li class="active">
                <span class="counter">01</span>
                <strong class="title">Shopping Cart</strong>
              </li>
              <li>
                <span class="counter">02</span>
                <strong class="title">Check Out</strong>
              </li>
              <li>
                <span class="counter">03</span>
                <strong class="title">Order Complete</strong>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- Mt Process Section of the Page end -->
    <!-- Mt Product Table of the Page -->
    <div class="mt-product-table wow fadeInUp" data-wow-delay="0.4s">
      <div class="container">
        <div class="row border">
          <div class="col-xs-12 col-sm-6">
            <strong class="title">PRODUCT</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">PRICE</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">QUANTITY</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="title">TOTAL</strong>
          </div>
        </div>
        <div class="row border">
          <div class="col-xs-12 col-sm-2">
            <div class="img-holder">
              <img src="http://placehold.it/105x105" alt="image description">
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <strong class="product-name">Marvelous Modern 3 Seater</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <form action="#" class="qyt-form">
              <fieldset>
                <select>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </fieldset>
            </form>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
            <a href="#"><i class="fa fa-close"></i></a>
          </div>
        </div>
        <div class="row border">
          <div class="col-xs-12 col-sm-2">
            <div class="img-holder">
              <img src="http://placehold.it/105x105" alt="image description">
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <strong class="product-name">Marvelous Modern 3 Seater</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <form action="#" class="qyt-form">
              <fieldset>
                <select>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </fieldset>
            </form>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
            <a href="#"><i class="fa fa-close"></i></a>
          </div>
        </div>
        <div class="row border">
          <div class="col-xs-12 col-sm-2">
            <div class="img-holder">
              <img src="http://placehold.it/105x105" alt="image description">
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <strong class="product-name">Marvelous Modern 3 Seater</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
          </div>
          <div class="col-xs-12 col-sm-2">
            <form action="#" class="qyt-form">
              <fieldset>
                <select>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
              </fieldset>
            </form>
          </div>
          <div class="col-xs-12 col-sm-2">
            <strong class="price"><i class="fa fa-eur"></i> 599,00</strong>
            <a href="#"><i class="fa fa-close"></i></a>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <form action="#" class="coupon-form">
              <fieldset>
                <div class="mt-holder">
                  <input type="text" class="form-control" placeholder="Your Coupon Code">
                  <button type="submit">APPLY</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div><!-- Mt Product Table of the Page end -->
    <!-- Mt Detail Section of the Page -->
    <section class="mt-detail-sec style1 wow fadeInUp" data-wow-delay="0.4s">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <h2>CALCULATE SHIPPING</h2>
            <form action="#" class="bill-detail">
              <fieldset>
                <div class="form-group">
                  <select class="form-control">
                    <option value="1">Select Country</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control">
                    <option value="1">State / Country</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control">
                    <option value="1">Zip / Postal Code</option>
                  </select>
                </div>
                <div class="form-group">
                  <button class="update-btn" type="submit">UPDATE TOTAL <i class="fa fa-refresh"></i></button>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="col-xs-12 col-sm-6">
            <h2>CART TOTAL</h2>
            <ul class="list-unstyled block cart">
              <li>
                <div class="txt-holder">
                  <strong class="title sub-title pull-left">CART SUBTOTAL</strong>
                  <div class="txt pull-right">
                    <span><i class="fa fa-eur"></i> 1299,00</span>
                  </div>
                </div>
              </li>
              <li>
                <div class="txt-holder">
                  <strong class="title sub-title pull-left">SHIPPING</strong>
                  <div class="txt pull-right">
                    <strong>Free Shipping</strong>
                  </div>
                </div>
              </li>
              <li style="border-bottom: none;">
                <div class="txt-holder">
                  <strong class="title sub-title pull-left">CART TOTAL</strong>
                  <div class="txt pull-right">
                    <span><i class="fa fa-eur"></i> 1299,00</span>
                  </div>
                </div>
              </li>
            </ul>
            <a href="#" class="process-btn">PROCEED TO CHECKOUT <i class="fa fa-check"></i></a>
          </div>
        </div>
      </div>
    </section>
    <!-- Mt Detail Section of the Page end -->
  </main>

@endsection

@section('extra_script')
<script type="text/javascript">
</script>

@endsection
