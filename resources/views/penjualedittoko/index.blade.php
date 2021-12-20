@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/penjual/home')}}">Home</a></li>
          <li class="breadcrumb-item">Seller</li>
          <li class="breadcrumb-item active" aria-current="page">Store</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Store</h4>
                    <div class="alert alert-warning" role="alert">
                    Please fill in all the data marked with <span style="color:red;">*</span>
                    </div>

                    @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                      Success, Info Saved Successfully
                    </div>
                    @endif

                    @if (session('gagal'))
                    <div class="alert alert-danger" role="alert">
                    Failed, Check Your Data Again, Failed to Save Info
                    </div>
                    @endif

                    <hr>
                    <form method="POST" class="form-horizontal" action="{{ url('penjual/toko/save') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="row">

                             <div class="col-md-12 col-sm-12 col-xs-12" style="height: 1%;">

                              <div class="row">

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Store Name <span style="color:red;">*</span></label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" class="form-control form-control-sm inputtext namatoko" placeholder="Input Store Name" name="namatoko" value="@isset($data){{$data->namatoko}}@endisset">
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Your Store Rating</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    @isset($data)
                                      @for ($i=0; $i < (Int)$data->star; $i++)
                                        <span class="fa fa-star checked"></span>
                                      @endfor
                                      @for ($i=0; $i < (5 - (Int)$data->star); $i++)
                                        <span class="fa fa-star"></span>
                                      @endfor
                                    @endisset
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Account Number</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm inputtext nomor_rekening" placeholder="Input Account Number" name="nomor_rekening" value="@isset($data){{$data->nomor_rekening}}@endisset">
                                      <br>
                                    <div class="alert alert-warning" role="alert">
                                    Please fill in the account number for successful payment
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Bank Name</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control form-control-sm inputtext bank" placeholder="Input Bank Name" name="bank" value="@isset($data){{$data->bank}}@endisset">
                                      <br>
                                    <div class="alert alert-warning" role="alert">
                                    Please fill in the account number for successful payment
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">
                                  <label>Activate Store ? </label>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left: 40px">
                                  <div class="form-group">
                                    <input class="form-check-input isdiskon" type="radio" name="istoko" value="Y" @isset($data) @if($data->istoko == "Y") ? checked :  @endif @endisset >Ya
                                  </div>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-left: 40px">
                                  <div class="form-group">
                                    <input class="form-check-input isdiskon" type="radio" name="istoko" value="N" @isset($data) @if($data->istoko == "N") ? checked :  @endif @endisset >Tidak
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Image</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">
                                    <br>
                                    <div class="col-md-6 col-sm-6 col-xs-12 image-holder" id="image-holder" style="margin-left:10%; ">

                                    @if(isset($data))

                                      <img src="{{url('/')}}/{{$data->profile_toko}}" class="thumb-image img-responsive" height="100px" alt="image">

                                    @endif

                                  </div>
                                  </div>
                                </div>

                                {{-- <center>
                                  <div class="col-md-6 col-sm-6 col-xs-12 image-holder" id="image-holder" style="margin-left:10%; ">

                                  @if(isset($data))

                                    <img src="{{url('/')}}/{{$data->profile_toko}}" class="thumb-image img-responsive" height="100px" alt="image">

                                  @endif

                                </div>
                                </center> --}}

                              </div>

                             </div>

                      </div>

                    <hr>
                    <div class="text-right w-100">
                      <button class="btn btn-primary save" type="submit">Save</button>
                      <a href="" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                </div>
                </form>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>
$(".uploadGambar").on('change', function () {
        $('.save').attr('disabled', false);
        // waitingDialog.show();
      if (typeof (FileReader) != "undefined") {
          var image_holder = $(".image-holder");
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/demo/images/loading.gif') }}" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "src": e.target.result,
                      "height": "100px",
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
</script>
@endsection
