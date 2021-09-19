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
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Master</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Budget Perdin</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_bank table-hover" id="asd" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>QO</th>
                                <th>SO</th>
                                <th>WO</th>
                                <th>Status PD</th>
                                <th>Status SO</th>
                                <th>Status WO</th>
                                <th>Status Pengiriman</th>
                              </tr>
                            </thead>

                            <tbody>
                              @foreach ($data as $key => $value)
                                <tr>
                                  <td>{{$key + 1}}</td>
                                  <td>{{$value->q_nota}}</td>
                                  <td>{{$value->so_nota}}</td>
                                  <td>{{$value->wo_nota}}</td>
                                  @if ($value->q_remain == 0)
                                    <td><span class="badge badge-pill badge badge-success">Paid Off</span></td>
                                  @elseif ($value->q_remain != 0)
                                    <td><span class="badge badge-pill badge badge-warning">Not Yet</span></td>
                                  @else
                                    <td></td>
                                  @endif
                                  @if ($value->so_status == 'Released')
                                      <td><span class="badge badge-pill badge-primary">Released</span></td>
                                  @elseif ($value->so_status == 'Printed')
                                      <td><span class="badge badge-pill badge-success">Printed</span></td>
                                  @else
                                    <td></td>
                                  @endif
                                  @if ($value->wo_status == 'Released')
                                      <td><span class="badge badge-pill badge-primary">Released</span></td>
                                  @elseif ($value->so_status == 'Printed')
                                      <td><span class="badge badge-pill badge-success">Printed</span></td>
                                  @else
                                    <td></td>
                                  @endif
                                  @if ($value->so_status_delivery == 'P')
              										<td><span class="badge badge-pill badge-warning">Belum Process</span></td>
              										@elseif ($value->so_status_delivery == 'PD')
              										<td><span class="badge badge-pill badge-primary">Process Delivery</span></td>
              										@elseif ($value->so_status_delivery == 'D')
              										<td><span class="badge badge-pill badge-success">Delivered</span></td>
                                  @else
                                  <td></td>
              										@endif
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
$('#asd').DataTable();
</script>
@endsection
