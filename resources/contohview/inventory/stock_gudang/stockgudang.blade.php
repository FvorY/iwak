@extends('main')
@section('content')

@include('inventory/penerimaan_barang/cari_po')
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Inventory</li>
  				<li class="breadcrumb-item active" aria-current="page">Stock Gudang</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">              
  	          <h4 class="card-title">Stock Gudang</h4>
  	          	<div class="row">
  	          		<div class="col-md-12 col-sm-12 col-xs-12" align="right">
  	          			{{-- <button class="btn btn-info btn-sm" type="button" data-target="#cari_po" id="button_add" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Data</button> --}}
  	          		</div>

        					<div class="table-responsive" style="margin-top: 15px;">
        						<table class="table table-hover" id="datatable" cellspacing="0">
        						  <thead class="bg-gradient-info">
        						    <tr>
        						      <th>Item </th>
        						      <th>Name</th>
                          <th>Category Item</th>
        						      <th>QTY</th>
        						      <th>Detail</th>
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
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script type="text/javascript">

	$('#datatable').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_stockgudang') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id left'
                  },
                  {
                     targets: 1 ,
                     className: 'left'
                  },
                  {
                     targets: 2 ,
                     className: 'right format_money'
                  },
                  {
                     targets: 3 ,
                     className: 'center'
                  },

                ],
            "columns": [
            { "data": "sg_iditem" },
            { "data": "i_name" },
            { "data": "i_jenis" },
            { "data": "sg_qty" },
            { "data": "detail" },
            ]
      });


	function detail(parm){
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();
     $.ajax({
         type: "get",
         url: '{{ route('detail_stockgudang') }}',
         data: {id},
         success: function(data){



         },
         complete:function(data){
         	window.open(this.url);
         },
         error: function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
         },
         async: false
       });
	}


</script>


@endsection
