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
          <li class="breadcrumb-item active" aria-current="page">LPJ Perdin</li>
        </ol>
      </nav>
    </div>

  	<div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">LPJ Perdin</h4>


          <div class="table-responsive">
			        <table class="table table-hover table-striped table-bordered" id="table_perdin" cellspacing="0">
                  <thead class="bg-gradient-info">
                    <tr>
                      <th width="1%">No</th>
                      <th>Estimation Date</th>
                      <th>Estimation Code</th>
                      <th>Estimation Budget</th>
                      <th>Perdin</th>
                      <th>Status</th>
                      <th>Action</th>
                      <th width="1%">Printout</th>
                      <th width="1%">Approval</th>
                    </tr>
                  </thead>

                  <tbody>                  
                    @foreach ($data as $key => $value)
                      <tr>
                        <td align="center">{{$key + 1}}</td>
                        <td>{{Carbon\Carbon::parse($value->p_tanggung_jawab)->format('d-m-Y')}}</td>
                        <td>{{$value->p_code}}</td>
                        <td align="right">{{number_format($value->p_total,2,',','.')}}</td>
                        <td align="center">{{$value->lp_code}}</td>
                        @if ($value->lp_status == null)
                          <td align="center"><span class="badge badge-pill badge-secondary text-dark">Waiting</span></td>
                        @else
                          <td align="center"><span class="badge badge-pill badge-secondary text-dark">{{$value->lp_status}}</span></td>
                        @endif
                        <td align="center" valign="middle">
                          <div class="btn-group btn-group-sm">
                            @if ($value->lp_status == 'released')
                              <a class="btn btn-warning btn-sm" href="{{url('/project/perdin/edit_lpj')}}?id={{encrypt($value->p_id)}}" title="Edit"><i class="fa fa-edit"></i></a>
                              <a class="btn btn-info btn-sm" href="{{url('/project/perdin/detail_lpj')}}?id={{encrypt($value->p_id)}}" title="Detail"><i class="fa fa-list"></i></a>
                            @elseif ($value->lp_status == null)
                              <a class="btn btn-primary btn-sm" href="{{route('proses_perdin')}}?id={{encrypt($value->p_id)}}">Process</a>
                              <a class="btn btn-info btn-sm" href="{{url('/project/perdin/detail_lpj')}}?id={{encrypt($value->p_id)}}" title="Detail"><i class="fa fa-list"></i></a>
                            @elseif ($value->lp_status == 'approved')
                                <a class="btn btn-info btn-sm" href="{{url('/project/perdin/detail_lpj')}}?id={{encrypt($value->p_id)}}" title="Detail"><i class="fa fa-list"></i></a>
                            @endif
                          </div>
                        </td>
                        <td align="center">
                          @if ($value->lp_status == 'approved')
                            <a class="btn btn-info" href="{{route('print_perdin')}}?id={{encrypt($value->p_id)}}" target="_blank" title="Print"><i class="fa fa-print"></i></a>
                          @endif
                        </td>
                        <td align="center">
                        @if (Auth::user()->m_jabatan == 'FINANCE')
                          @if ($value->lp_status == 'released')
                          <button class="btn btn-success btn-sm" type="button" title="Approve"><i class="fa fa-check-square" onclick="approve({{$value->lp_perdin}})"></i></button>
                          @endif
                        @endif
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
@endsection
@section('extra_script')
<script type="text/javascript">

  $(document).ready(function(){

    var table = $('#table_perdin').DataTable();
No});

  function approve(id) {
      iziToast.show({
              overlay: true,
              close: false,
              timeout: 20000,
              color: 'dark',
              icon: 'fas fa-question-circle',
              title: 'Important!',
              message: 'Apakah Anda Yakin ?!',
              position: 'center',
              progressBarColor: 'rgb(0, 255, 184)',
              buttons: [
                [
                  '<button style="background-color:red;">Yes</button>',
                  function (instance, toast) {

                    $.ajax({
                      type: 'get',
                      data: {id},
                      dataType: 'json',
                      url: baseUrl + '/project/perdin/approve_lpj',
                        success:function(data){
                          if (data.status == 'berhasil') {
                            iziToast.success({
                              icon: 'fa fa-check',
                              message: 'Data Berhasil diapprove!',
                            });
                            window.location.reload();
                          }
                        },
                        error:function(){
                          iziToast.warning({
                            icon: 'fa fa-times',
                            message: 'Terjadi Kesalahan!',
                          });
                        }
                    });

                  }
                ],
                [
                  '<button style="background-color:#44d7c9;">Cancel</button>',
                  function (instance, toast) {
                    instance.hide({
                      transitionOut: 'fadeOutUp'
                    }, toast);
                  }
                ]
              ]
            });

    }

</script>
@endsection
