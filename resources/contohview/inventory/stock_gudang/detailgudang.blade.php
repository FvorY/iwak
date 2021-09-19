@extends('main')
@section('content')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- partial -->
<form id="form-save">
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Inventory</li>
          <li class="breadcrumb-item active" aria-current="page">Stock Mutation</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <input type="hidden" name="id" value="{{$id}}">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Menampilkan <b style="color:red;">Stock Mutasi</b> Dengan Nama item <b style="color:red;">"{{ $header_nama->i_name }}  /  {{ $header_nama->i_code }}"</b></h4>
            <div class="col-md-2">
              <label for="daterange">Filter Date : </label>
            </div>
            <div class="col-md-6">
              <input type="text" name="daterange" class="form-control" id="daterange" value="" />
            </div>
             <div class="table-responsive" style="margin-bottom: 15px;">
               <table class="table table-bordered table-hover" cellspacing="0" id="datatable">
                 <thead class="bg-gradient-info">
                   <tr>
                     <th>Item Code</th>
                     <th>Item Name</th>
                     <th>Refenrence</th>
                     <th>Item Hpp</th>
                     <th>Qty Approved</th>
                     <th>Qty Use</th>
                     <th>Qty Remains</th>
                     <th>Description</th>
                     <th>Date</th>
                   </tr>
                 </thead>
                 <tbody id="showdata">
                    @foreach ($data as $e)
                      <tr>
                        <td>{{ $e->sm_item }}</td>
                        <td>{{ $e->i_name }}</td>
                        <td>{{ $e->sm_ref }}</td>
                        <td align="right">{{ number_format($e->sm_hpp,0,'.','.') }}</td>
                        <td align="right">{{ number_format($e->sm_qty,0,'.','.') }}</td>
                        <td align="right">{{ number_format($e->sm_use,0,'.','.') }}</td>
                        <td align="right">{{ number_format($e->sm_sisa,0,'.','.') }}</td>
                        <td>{{ $e->sm_description }}</td>
                        <td>{{ Carbon\Carbon::parse($e->sm_insert)->format('d-m-Y') }}</td>
                      </tr>
                    @endforeach
                 </tbody>
               </table>
             </div>



            <div align="right" style="margin-top: 15px;">
              <div id="change_function">
                <a href="{{ route('stockgudang') }}" class="btn btn-secondary btn-sm">Back</a>
              </div>
            </div>
            </div>
        </div>
    </div>
  </div>
</div>
</form>
<!-- content-wrapper ends -->

@endsection
@section('extra_script')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
  // var table = $('#datatable').DataTable({});
  var table = $('#datatable').DataTable({
       dom: 'Bfrtip',
       title: '',
       buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print'
       ]
   });
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      startDate = start.format('YYYY-MM-DD');
      endDate = end.format('YYYY-MM-DD');
      id = $('input[name=id]').val();
      table.clear();
      $.ajax({
        type: 'get',
        data: {startDate, endDate, id},
        dataType: 'json',
        url: baseUrl + '/inventory/stockgudang/filterdate',
        success : function(response){
          if (response.length == 0) {
              var html = '<td valign="top" colspan="9" class="dataTables_empty">No data available in table</td>';
              $('#showdata').html(html);
          } else {
            for (var i = 0; i < response.length; i++) {
              table.row.add([
                      response[i].i_code,
                      response[i].i_name,
                      response[i].sm_ref,
                      get_currency(response[i].sm_hpp),
                      get_currency(response[i].sm_qty),
                      get_currency(response[i].sm_use),
                      get_currency(response[i].sm_sisa),
                      response[i].sm_description,
                      moment(response[i].sm_insert).format('dd-mm-YYYY')
              ]).draw( false );
            }
          }
          // if (response.length == 0) {
          //   var html = '<td valign="top" colspan="9" class="dataTables_empty">No data available in table</td>';
          // } else {
          //   for (var i = 0; i < response.length; i++) {
          //     if (response[i].sm_description == null) {
          //       response[i].sm_description = "";
          //     }
          //
          //     if (response[i].sm_ref == null) {
          //       response[i].sm_ref = "";
          //     }
          //     html += '<tr>'+
          //             '<td>'+response[i].i_code+'</td>'+
          //             '<td>'+response[i].i_name+'</td>'+
          //             '<td>'+response[i].sm_ref+'</td>'+
          //             '<td align="right">'+get_currency(response[i].sm_hpp)+'</td>'+
          //             '<td align="right">'+get_currency(response[i].sm_qty)+'</td>'+
          //             '<td align="right">'+get_currency(response[i].sm_use)+'</td>'+
          //             '<td align="right">'+get_currency(response[i].sm_sisa)+'</td>'+
          //             '<td>'+response[i].sm_description+'</td>'+
          //             '<td>'+moment(response[i].sm_insert).format('dd-mm-YYYY')+'</td>';
          //             '</tr>';
          //   }
          // }
          // $('#showdata').html(html);
        }
      });
    });
  });

</script>
@endsection
