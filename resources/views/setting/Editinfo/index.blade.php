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
          <li class="breadcrumb-item active" aria-current="page">Edit Info</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Edit Info</h4>

                    @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                      Success, Info Berhasil Disimpan
                    </div>
                    @endif

                    @if (session('gagal'))
                    <div class="alert alert-danger" role="alert">
                      Gagal, Info Gagal Disimpan
                    </div>
                    @endif

                    <hr>
                    <form method="GET" class="form-horizontal" action="{{ url('admin/setting/editinfo/save') }}">
                      {{-- {{csrf_field()}} --}}
                      <div class="row">

                             <div class="col-md-12 col-sm-12 col-xs-12" style="height: 1%;">

                              <div class="row">

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Description</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                      <textarea class="form-control form-control-sm description" name="description" rows="8" cols="80" placeholder="Description">@isset($data){{$data[0]->description}}@endisset</textarea>
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Email</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                      <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" value="@isset($data){{$data[0]->email}}@endisset">
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-xs-12">
                                  <label>Address</label>
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <textarea class="form-control form-control-sm address" name="address" rows="8" cols="80" placeholder="Address" >@isset($data){{$data[0]->address}}@endisset</textarea>
                                    </div>
                                  </div>
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

</script>
@endsection
