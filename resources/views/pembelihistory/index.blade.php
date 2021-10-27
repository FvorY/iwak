@extends('layouts.homepage.app_home')

@section('content')
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
              <div class="col-xs-12 col-sm-2">
                <strong class="title">STATUS</strong>
              </div>
              <div class="col-xs-12 col-sm-4">
                <strong class="title">ACTION</strong>
              </div>
            </div>
            @foreach($data as $list)
            <div class="row border">
              <div class="col-xs-12 col-sm-2">
                  <strong class="price" style="font-size: 18px;">{{$list->nota}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="price"> RP. {{$list->subtotal}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                <strong class="price"> {{date('j F Y', strtotime($list->date))}}</strong>
              </div>
              <div class="col-xs-12 col-sm-2">
                @if($list->pay == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled> Sudah Dibayar </button></strong>
                @elseif($list->deliver == 'P')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled=""> Proses Pengiriman </button></strong>
                @elseif($list->deliver == 'Y')
                <strong class="price"><button class="btn btn-sm btn-success" style="margin-bottom: 20px;" disabled=""> Sudah Dikirim </button></strong>
                @elseif($list->cancelled == 'Y')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled=""> Pesanan Dibatalkan </button></strong>
                @elseif($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
                <strong class="price"><button class="btn btn-sm btn-warning" style="margin-bottom: 20px;" disabled> Pesanan Dibuat </button></strong>
                @endif
              </div>
              <div class="col-xs-12 col-sm-1">
                <strong class="price">
                  <!-- <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</button> -->
                  <a href="{{ route('detailhistory',$list->id_transaction) }}" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Detail</a>
                </strong>

              </div>
              @if($list->pay == 'N' && $list->deliver == 'N' && $list->cancelled == 'N')
              <div class="col-xs-12 col-sm-2">
                <strong class="price"><button type="submit" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Cancel Order</button></strong>
              </div>
              @else
              <div class="col-xs-12 col-sm-2">
                <strong class="price"><button type="submit" class="btn btn-sm btn-danger" disabled=""> <i class="fa fa-trash"></i> Cancel Order</button></strong>
              </div>
              @endif
            </div>
            @endforeach
            
          </div>
        </div><!-- Mt Product Table of the Page end -->
        <!-- Mt Detail Section of the Page -->
        
        <!-- Mt Detail Section of the Page end -->
      </main><!-- Main of the Page end here -->
@endsection