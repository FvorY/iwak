@extends('main')
@section('content')

{{-- @include('product.tambah') --}}
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          {{-- <li class="breadcrumb-item">Setup Master Tagihan</li> --}}
          <li class="breadcrumb-item active" aria-current="page">Product</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Form Product</h4>

                    @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                      Success, Data berhasil disimpan
                    </div>
                    @endif

                    @if (session('gagal'))
                    <div class="alert alert-danger" role="alert">
                      Gagal, Data gagal disimpan
                    </div>
                    @endif

                    <form id="formproduct">

                    <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                      <div class="row">

                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <label>Name</label>
                        </div>

                        <div class="col-md-10 col-sm-6 col-xs-12">
                          <div class="form-group">
                              <input type="text" class="form-control form-control-sm" name="name" id="name">
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <label>Description</label>
                        </div>

                        <div class="col-md-10 col-sm-6 col-xs-12">
                          <div class="form-group">
                              <div class="form-group">
                                <textarea name="description" id="description" class="form-control form-control-sm" rows="8" cols="80"></textarea>
                              </div>
                          </div>
                        </div>

                      </div>
                   </div>


                   <div class="col-md-5 col-sm-12 col-xs-12" style="height: 1%;">
                     <div class="row">
                     <div class="col-md-2 col-sm-6 col-xs-12">
                       <label>Category</label>
                     </div>
                     <div class="col-md-8 col-sm-6 col-xs-12">
                       <div class="form-group">
                         <select class="form-control select2" name="category[]" id="category" multiple="multiple">
                           <option value="">-- Select Tool --</option>
                           @foreach ($category as $key => $value)
                             <option value="{{$value->id}}">{{$value->title}}</option>
                           @endforeach
                         </select>
                       </div>
                     </div>

                    </div>

                    </div>
                  </div>
                </form>


                    <div id="formuploadimage">
                      <h4 class="card-title">Upload Image</h4>
                      <form action="{{url('/penjual/produk/simpanproductcontent')}}" class="dropzone">

                      </form>
                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-primary" type="button" id="btnsubmit">Process</button>
                      <a href="{{url('/penjual/produk/productcontent')}}" class="btn btn-warning">Close</a>
                    </div>

                  </div>
                </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>

baseUrlChange += '/penjual/produk'

Dropzone.autoDiscover = false;

var myDropzone = new Dropzone(".dropzone", {
   autoProcessQueue: false,
   uploadMultiple: true,
   url: baseUrlChange + "/simpanproductcontent",
   acceptedFiles:'image/*',
   params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}", 'name' : $('#name').val(), 'description' : $('#description').val(), 'category' : $('#category').val() }; },
   init: function() {
            this.on("success", function(file, response) {
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Disimpan!',
                });
                setTimeout(function () {
                  window.location.href = "{{url('/productcontent')}}";
                }, 1000);
              }else if(response.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal disimpan!',
                });
              }else if (response.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Diubah!',
                });
                setTimeout(function () {
                  window.location.href = "{{url('/productcontent')}}";
                }, 1000);
              }else if (response.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal Diubah!',
                });
              }
            })
        }
});

$('#btnsubmit').click(function(){

    if (myDropzone.getQueuedFiles().length > 0) {
        myDropzone.processQueue();
    } else {
      $.ajax({
        type: 'post',
        data: {'_token' : "{{csrf_token()}}", 'name' : $('#name').val(), 'description' : $('#description').val(), 'category' : $('#category').val(), 'id' : $('#id').val()},
        dataType : 'json',
        url: baseUrlChange + '/simpanproductcontent',
        success: function(response) {
          if (response.status == 1) {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Disimpan!',
            });
            setTimeout(function () {
              window.location.href = "{{url('/productcontent')}}";
            }, 1000);
          }else if(response.status == 2){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Data Gagal disimpan!',
            });
          }else if (response.status == 3){
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Diubah!',
            });
            setTimeout(function () {
              window.location.href = "{{url('/productcontent')}}";
            }, 1000);
          }else if (response.status == 4){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Data Gagal Diubah!',
            });
        }
      }
      });
    }

});

</script>
@endsection
