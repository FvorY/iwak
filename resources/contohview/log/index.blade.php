@extends('main')
@section('content')


<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item">User Log Activity</li>
      </nav>
        </ol>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User Log Activity Details</h4>
                    <div class="table-responsive">
        				        <table id="table_data" class="table table-striped table-hover data-table" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Action</th>
                                <th>Menu</th>
                                <th>Parameter</th>
                                <th>Time</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($data as $key => $value)
                                <tr>
                                  <td>{{$key + 1}}</td>
                                  <td>{{$value->l_user}}</td>
                                  <td>{{$value->l_action}}</td>
                                  <td>{{$value->l_log}}</td>
                                  <td>{{$value->l_parameter}}</td>
                                  <td>{{Carbon\Carbon::parse($value->l_insert)->format('d-m-Y G:i:s')}}</td>
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
