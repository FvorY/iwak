@extends('main')
@section('content')

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
          <li class="breadcrumb-item active" aria-current="page">Category Product</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Category Product</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      {{-- @if(Auth::user()->akses('MASTER DATA STATUS','tambah')) --}}
                    	<button type="button" class="btn btn-info" onclick="docreate()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      {{-- @endif --}}
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover data-table" id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th width="20%">Action</th>
                              </tr>
                            </thead>

                            <tbody>
                              @foreach ($data as $key => $value)
                                <tr>
                                  <td>{{$key + 1}}</td>
                                  <td>{{$value->category_name}}</th>
                                  <td>
                                    <span type="button" class="btn btn-primary btn-sm" onclick="doedit({{$value->id_category}})" name="button"> <em class="fa fa-edit"></em> </span>
                                    <span type="button" class="btn btn-danger btn-sm" onclick="dodelete({{$value->id_category}})" name="button"> <em class="fa fa-trash"></em> </span>
                                  </td>

                                </tr>
                              @endforeach
                            </tbody>


                        </table>
                    </div>
                  </div>
                </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Form Category</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <table class="table table_modal">
                  <tr>
                    <td>Category Name</td>
                    <td>
                      <input type="text" name="category" class="form-control" value="" id="category" placeholder="Category Name">
                    </td>
                  </tr>
                  </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="buttonsave" name="button" onclick="dosave()"> Process </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
          </div>
</div>
<!-- Modal end -->
@endsection
@section('extra_script')
<script>

baseUrlChange += '/admin/category'

function dosave() {
      $.ajax({
        type: 'get',
        data: {category: $("#category").val()},
        dataType: 'json',
        url: baseUrlChange + "/simpan",
        success : function(response) {
          if (response.status == "sukses") {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Disimpan!',
            });
              setTimeout(function(){
                    window.location.reload();
            }, 1000);
          } else {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Gagal Disimpan!',
            });
          }
        }
      });
    }

    function doedit(id) {
      $.ajax({
        type: 'get',
        data: {id: id},
        dataType: 'json',
        url: baseUrlChange + "/edit",
        success : function(response) {
          $("#category").val(response.category_name);
          $("#exampleModal").modal('show');
          $('#titlemodal').text("Update Category");
          $('#buttonsave').text("Update");
          $('#buttonsave').attr('onclick', 'doupdate('+id+')');
        }
      });
    }

    function docreate(){
      $("#exampleModal").modal('show');
      $('#titlemodal').text("Insert New Category");
      $('#buttonsave').text("Save");
      $('#buttonsave').attr('onclick', 'dosave()');
      $("#category").val("");
    }

    function doupdate(id){
      $.ajax({
        type: 'get',
        data: {id: id, category: $('#category').val()},
        dataType: 'json',
        url: baseUrlChange + "/update",
        success : function(response) {
          if (response.status == "sukses") {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Diupdate!',
            });
            setTimeout(function(){
                  window.location.reload();
          }, 1000);
          } else {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Gagal Diupdate!',
            });
          }
        }
      });
    }

    function dodelete(id) {
      iziToast.question({
        close: false,
    		overlay: true,
    		displayMode: 'once',
    		title: 'Hapus data',
    		message: 'Apakah anda yakin ?',
    		position: 'center',
    		buttons: [
    			['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url: baseUrlChange + "/hapus",
              data:{id},
              dataType:'json',
              success:function(response){
                if (response.status == "sukses") {
                  iziToast.success({
                      icon: 'fa fa-save',
                      message: 'Data Berhasil Dihapus!',
                  });
                    setTimeout(function(){
                          window.location.reload();
                  }, 1000);
                } else {
                  iziToast.success({
                      icon: 'fa fa-save',
                      message: 'Data Berhasil Dihapus!',
                  });
                }
              }
            });
    			}, true],
    			['<button>Tidak</button>', function (instance, toast) {
    				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
    			}],
    		]
    	});
    }

</script>
@endsection
