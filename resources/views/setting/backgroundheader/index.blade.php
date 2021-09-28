@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          <li class="breadcrumb-item">Setting</li>
          <li class="breadcrumb-item active" aria-current="page">Background Header</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Manage Background Header</h4>

                    @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                      Success, Background Header Berhasil Disimpan
                    </div>
                    @endif

                    @if (session('gagal'))
                    <div class="alert alert-danger" role="alert">
                      Gagal, Background Header Gagal Disimpan
                    </div>
                    @endif

                    <hr>
                    <form method="POST" class="form-horizontal" action="{{ url('admin/setting/backgroundheader/save') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="row">

                             <div class="col-md-12 col-sm-12 col-xs-12" style="height: 1%;">

                              <div class="row">

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <label>Image</label>
                                </div>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">
                                  </div>
                                </div>

                                <center>
                                  <div class="col-md-8 col-sm-6 col-xs-12 image-holder" id="image-holder" style="margin-left:10%; ">

                                  @if(isset($data))

                                    <img src="{{url('/')}}/{{$data->image}}" class="thumb-image img-responsive" height="100px" alt="image">

                                  @endif

                                </div>
                              </center>
                              </div>

                             </div>

                      </div>

                    <hr>
                    <div class="text-right w-100">
                      <button class="btn btn-primary save" type="submit">Simpan</button>
                      <a href="" class="btn btn-secondary">Kembali</a>
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
