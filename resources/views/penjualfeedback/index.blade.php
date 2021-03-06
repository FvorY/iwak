@extends('main')
@section('content')

@include('penjualfeedback.detail')

<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/penjual/home')}}">Home</a></li>
          <li class="breadcrumb-item">Seller</li>
          <li class="breadcrumb-item active" aria-current="page">Feedback / Review</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Feedback / Review</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      {{-- @if(Auth::user()->akses('MASTER DATA STATUS','tambah')) --}}
                    	{{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button> --}}
                      {{-- @endif --}}
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Nota</th>
                                <th>Image Feedback / Review</th>
                                <th>User Name</th>
                                <th>Star / Rating</th>
                                <th>Comment</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody>

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

baseUrlChange += '/penjual/listfeed'

var table = $('#table-data').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        searching: true,
        paging: true,
        dom: 'Bfrtip',
        title: '',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: baseUrlChange + "/table",
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id'
              },
              {
                 targets: 1,
                 className: 'center'
              },
              {
                 targets: 2,
                 className: 'center'
              },
              {
                 targets: 3,
                 className: 'center'
              },
              {
                 targets: 4,
                 className: 'center'
              },
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 6,
                 className: 'center'
              },
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'nota', name: 'nota'},
          {data: 'image', name: 'image'},
          {data: 'username', name: 'username'},
          {data: 'star', name: 'star'},
          {data: 'feedback', name: 'feedback'},
          {data: 'aksi', name: 'aksi'},
        ]
  });

  function detail(id) {
    var html = "";
    $.ajax({
      url: "{{url('/')}}" + '/feed/detail',
      data:{id_transaction: id},
      dataType:'json',
      success:function(response){

        var subtotal = 0
        for (var i = 0; i < response.data.length; i++) {

          let detail = response.data[i];

          html += "<tr>"+
                  "<td> "+(i+1)+" </td>"+
                  "<td> <img src='{{url('/')}}/"+detail.imageproduk+"' style='width: 40px; height: 40px;'> </td>"+
                  "<td> "+detail.name+" </td>"+
                  "<td> <img src='{{url('/')}}/"+detail.image+"' style='width: 40px; height: 40px;'> </td>"+
                  "<td> "+detail.feedback+" </td>"+
                  "<td> "+detail.star+" </td>"+
                  "<tr>";
        }

        $('#bodydetail').html(html);
        $('#detailfeed').modal('show');

      }
    })
  }

</script>
@endsection
