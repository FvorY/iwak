@extends('main')
@section('content')

<!-- partial -->
<form id="form-save">
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Order</li>
          <li class="breadcrumb-item active" aria-current="page">Cek Stock</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
             <div class="table-responsive" style="margin-bottom: 15px;">
               <table class="table table-bordered table-hover" cellspacing="0" id="datatable">
                 <thead class="bg-gradient-info">
                   <tr>
                     <th>Item Code</th>
                     <th>Item Name</th>
                     <th>QTY</th>
                     <th>Description</th>
                   </tr>
                 </thead>
                 <tbody>
                    @foreach ($data as $e)
                      <tr>
                        <td>{{ $e->qd_item }}</td>
                        <td>{{ $e->i_name }}</td>
                        <td>{{ $e->qd_qty }}</td>
                        @if ($e->qd_description == "null")
                          <td></td>
                        @else
                          <td>{{ $e->qd_description }}</td>
                        @endif
                      </tr>
                    @endforeach
                 </tbody>
               </table>
             </div>



            <div align="right" style="margin-top: 15px;">
              <div id="change_function">
                <a href="{{ url('/order/cekbarang/cekbarang') }}" class="btn btn-secondary btn-sm">Back</a>
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
<script type="text/javascript">
  var table = $('#datatable').DataTable({});

</script>
@endsection
