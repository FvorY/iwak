@extends('main')
@section('content')

@include('uangmasuk.tambah')
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="/home">Home</a></li>
          {{-- <li class="breadcrumb-item">Billing Master Setup</li> --}}
          <li class="breadcrumb-item active" aria-current="page">Mutation</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Mutation</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      {{-- @if(Auth::user()->akses('MASTER DATA STATUS','tambah')) --}}
                    	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      {{-- @endif --}}
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover data-table" id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Nominal</th>
                                <th>Note</th>
                                <th>Type</th>
                                <th>Date</th>
                              </tr>
                            </thead>

                            <tbody align="center">
                              @for ($i=0; $i < count($result); $i++)
                                <tr>
                                  <td>{{($i + 1)}}</td>
                                  <td>{{$result[$i]["nominal"]}}</td>
                                  <td>{{$result[$i]["note"]}}</td>
                                  <td>UANG {{$result[$i]["type"]}}</td>
                                  <td>{{$result[$i]["date"]}}</td>
                                </tr>

                              @endfor

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

</script>
@endsection
