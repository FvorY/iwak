@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">After Order</li>
          <li class="breadcrumb-item active" aria-current="page">Surat Jalan</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Surat Jalan</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<a href="{{route('tambah_suratjalan')}}" class="btn btn-info btn_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</a>
                    </div>
                    <div class="table-responsive">
        				        <table id="table_data" class="table table-striped table-hover" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th width="1%">No</th>
                                <th width="" title="Surat Jalan">Surat Jalan</th>
                                <th width="">SO</th>
                                <th>Customer</th>
                                <th>Customer Address</th>
                                <th width="20%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($data as $key => $value)
                                <tr>
                                  <td>{{$key + 1}}</td>
                                  <td>{{$value->s_code}}</td>
                                  <td>{{$value->s_so}}</td>
                                  <td>{{$value->c_name}}</td>
                                  <td>{{$value->c_address}}</td>
                                  <td align="center"><button class="btn btn-info btn-sm btn-print" onclick="cetak({{$value->s_id}})" type="button" title="Print"><i class="fa fa-print"></i></button></td>
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
@endsection
@section('extra_script')
<script>
$(document).ready(function(){
  var table   = $('#table_data').DataTable();
});

function cetak(id){
  window.location.href='{{route('print_suratjalan')}}?id='+id;
}
</script>
@endsection
