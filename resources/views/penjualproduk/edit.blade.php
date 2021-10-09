@extends('main')
@section('content')

{{-- @include('product.tambah') --}}
<style type="text/css">
.dropzone .dz-preview .dz-image img {
  width: 100%;
  height: 100%;
}
</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/penjual/home')}}">Home</a></li>
          <li class="breadcrumb-item">Penjual</li>
          <li class="breadcrumb-item active" aria-current="page">Product</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Form Product</h4>
                    <div class="alert alert-warning" role="alert">
                      Mohon isi semua data yang bertanda <span style="color:red;">*</span>
                    </div>

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

                    <input type="hidden" name="id" id="id" value="{{$id}}" >

                    <div class="row">
                      <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="row">

                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Name <span style="color:red;">*</span></label>
                          </div>

                          <div class="col-md-10 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Nama Produk" name="name" id="name">
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Price <span style="color:red;">*</span></label>
                          </div>

                          <div class="col-md-10 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm rp" placeholder="Price" name="price" id="price">
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Stock <span style="color:red;">*</span></label>
                          </div>

                          <div class="col-md-10 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-sm" placeholder="Stock" name="stock" id="stock">
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Diskon (%)</label>
                          </div>

                          <div class="col-md-10 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-sm" placeholder="Diskon" name="diskon" id="diskon">
                            </div>
                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Aktifkan Diskon ? </label>
                          </div>

                          <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left: 40px">
                            <div class="form-group">
                              <input class="form-check-input isdiskon" type="radio" name="isdiskon" value="Y">Ya
                            </div>
                          </div>
                          <div class="col-md-7 col-sm-6 col-xs-12" style="padding-left: 40px">
                            <div class="form-group">
                              <input class="form-check-input isdiskon" type="radio" name="isdiskon" value="N" checked>Tidak
                            </div>
                          </div>

                          <br>

                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <label>Description</label>
                          </div>

                          <div class="col-md-10 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="form-group">
                                  <textarea name="description" id="description" class="form-control form-control-sm" placeholder="Description" rows="8" cols="80"></textarea>
                                </div>
                            </div>
                          </div>

                        </div>
                     </div>


                   <div class="col-md-5 col-sm-12 col-xs-12" style="height: 1%;">
                     <div class="row">
                     <div class="col-md-3 col-sm-6 col-xs-12">
                       <label>Category <span style="color:red;">*</span></label>
                     </div>
                     <div class="col-md-8 col-sm-6 col-xs-12">
                       <div class="form-group">
                         <select class="form-control select2" name="category" id="category">
                           <option value="">-- Select Category --</option>
                           @foreach ($category as $key => $value)
                             <option value="{{$value->id_category}}">{{$value->category_name}}</option>
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
                      <div class="alert alert-warning" role="alert">
                        Jika Remove File Diklik Maka Foto / Image Akan Otomatis Hilang
                      </div>
                      <form action="{{url('/penjual/produk/simpanproductcontent')}}" class="dropzone">

                      </form>
                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-primary" type="button" id="btnsubmit">Process</button>
                      <a href="{{url('/penjual/produk')}}" class="btn btn-warning">Close</a>
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
   addRemoveLinks: true,
   thumbnailWidth: 1140,//the "size of image" width at px
   thumbnailHeight: 380,
   timeout: 180000,
   url: baseUrlChange + "/simpanproductcontent",
   acceptedFiles:'image/*',
   params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}", 'name' : $('#name').val(), 'description' : $('#description').val(), 'category' : $('#category').val(), 'price' : $('#price').val(), 'stock' : $('#stock').val(), 'diskon' : $('#diskon').val(), 'isdiskon' : $('.isdiskon').val(), 'id' : $('#id').val(), }; },
   init: function() {

            this.on("removedfile", function(file, response) {
              $.ajax({
                type: 'get',
                data: {id_image:file.id_image, id_produk:file.id_produk},
                dataType: 'json',
                url: baseUrlChange + '/removeimageproductcontent',
                success: function(response) {

                }
              });
            })

            this.on("success", function(file, response) {
              if (response.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Disimpan!',
                });
                setTimeout(function () {
                  window.location.href = baseUrlChange;
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
                  window.location.href = baseUrlChange;
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

$.ajax({
  type: 'get',
  data: {id: $('#id').val()},
  dataType: 'json',
  url: baseUrlChange + '/doeditproductcontent',
  success : function(response) {
    console.log(response);
    $('#name').val(response.product.name);
    $('#description').val(response.product.description);
    $('#price').val("Rp. " + accounting.formatMoney(response.product.price,"",0,'.',','));
    $('#stock').val(response.product.stock);
    $('#diskon').val(response.product.diskon);
    $('input[name="isdiskon"]').filter("[value='"+response.product.isdiskon+"']").click();
    // $('input:radio[name=isdiskon]').val([response.product.isdiskon]);

    var selectedValues = new Array();

    // for (var i = 0; i < response.category.length; i++) {
    //   selectedValues[i] = response.category[i].productcategory;
    // }
    //
    // console.log(selectedValues);

    $("#category").val(response.product.id_category).change();

    var imagevalues = new Array();

    for (var i = 0; i < response.image.length; i++) {
      imagevalues[i] = { name: response.image[i].image, size: 0, id_image: response.image[i].id_image, id_produk: response.image[i].id_produk};
    }

    for (i = 0; i < imagevalues.length; i++) {
        myDropzone.emit("addedfile", imagevalues[i]);
        myDropzone.emit("thumbnail", imagevalues[i], "{{url('/')}}"+"/"+imagevalues[i].name);
        myDropzone.emit("complete", imagevalues[i]);

        myDropzone.files.push(imagevalues[i]);
    }

  }
});



$('#btnsubmit').click(function(){

    if (myDropzone.getQueuedFiles().length > 0) {
        myDropzone.processQueue();
    } else {
        $.ajax({
          type: 'post',
          data: {'_token' : "{{csrf_token()}}", 'name' : $('#name').val(), 'description' : $('#description').val(), 'category' : $('#category').val(), 'id' : $('#id').val(), 'price' : $('#price').val(), 'stock' : $('#stock').val(), 'diskon' : $('#diskon').val(), 'isdiskon' : $('.isdiskon').val()},
          dataType : 'json',
          url: baseUrlChange + '/simpanproductcontent',
          success: function(response) {
            if (response.status == 1) {
              iziToast.success({
                  icon: 'fa fa-save',
                  message: 'Data Berhasil Disimpan!',
              });
              setTimeout(function () {
                window.location.href = baseUrlChange;
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
                window.location.href = baseUrlChange;
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
