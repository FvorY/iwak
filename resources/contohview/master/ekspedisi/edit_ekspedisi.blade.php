@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item"><a href="#">Master Data Ekspedisi</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah Master Data Ekspedisi</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Tambah Master Data Ekspedisi</h4>
            <form id="formdata">
            <div class="row">
              <div class="col-md-3 col-sm-4 col-12">
                <label>Expedition Name</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12 ">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" name="name" value="{{$data->e_name}}">
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-12">
                <label>Expedition Address</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12 ">
                <div class="form-group">
                  <textarea class="form-control" name="address">{{$data->e_address}}</textarea>
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-12">
                <label>Expedition Phone Number</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12 ">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" name="telp" value="{{$data->e_telp}}">
                </div>
              </div>
            </div>
          </form>
            <div class="w-100 text-right">
              <button class="btn btn-primary" onclick="update({{$id}})" type="button">Simpan</button>
              <a href="{{route('ekspedisi')}}" class="btn btn-secondary">Kembali</a>
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
function update(id){
  $.ajax({
    type: 'get',
    data: $('#formdata').serialize()+'&id='+id,
    dataType: 'json',
    url : "{{route('update_ekspedisi')}}",
    success : function(response){
      if (response.status == 'berhasil') {
        iziToast.success({
            icon: 'fa fa-trash',
            message: 'Berhasil Diupdate!',
        });
        setTimeout(function () {
          window.location.href = "{{route('ekspedisi')}}";
        }, 100);
      } else {
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Periksa kembali data anda!',
        });
      }
    }
  });
}
</script>
@endsection
