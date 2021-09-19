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
					<li class="breadcrumb-item active" aria-current="page">Penerimaan Barang</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Penerimaan Barang</h4>
		          	<div class="row">
									@if (App\mMember::akses('PENERIMAAN BARANG', 'tambah'))
		          		<div class="col-md-12 col-sm-12 col-xs-12" align="right">
		          			<button class="btn btn-info btn-sm" type="button" data-target="#cari_po" id="button_add" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Data</button>
		          		</div>
									@endif

						<div class="table-responsive" style="margin-top: 15px;">
							<table class="table table-hover" id="datatable" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>Code</th>
							      <th>P.O.#</th>
							      <th>Vendor</th>
							      <th>Status</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							  <tbody>
						{{-- 	    <tr>
							    	<td>1</td>
							    	<td>P001</td>
							    	<td>Bravo</td>
							    	<td><span class="badge badge-success badge-pill">Complete</span></td>
							    	<td>
							    		<div class="btn-group">
								    		<button class="btn btn-primary" data-toggle="modal" data-target="#detail"><i class="fa fa-check"></i></button>
								    		<button class="btn btn-info"><i class="fa fa-print"></i></button>
								    	</div>
							    	</td>
							    </tr> --}}

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
                url:'{{ route('datatable_penerimaan_barang') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id center'
                  },
                  {
                     targets: 1 ,
                     className: 'center'
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
            { "data": "pb_code" },
            { "data": "pb_ref" },
            { "data": "s_company" },
            { "data": "status" },
            { "data": "aksi" },
            ]
      });

	function cari_purchaseorder(this_val) {
		$.ajax({
         type: "get",
         url: '{{ route('cari_penerimaan_barang') }}',
         data: {this_val},
         success: function(data){

         },
         complete:function(){
         	window.location.href= this.url;
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
	function edit(parm){
	    var par   = $(parm).parents('tr');
	    var id    = $(par).find('.d_id').text();
	    // window.location.href = (baseUrl +'/master/bundle/edit_bundle/'+id);
	    $.ajax({
         type: "get",
         url: baseUrl+'/inventory/penerimaan_barang/edit_penerimaan_barang',
         data: {id},
         success: function(data){

         },
         complete:function(){
         	window.location.href= this.url;
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
	function hapus(parm){
	    var par   = $(parm).parents('tr');
	    var id    = $(par).find('.d_id').text();

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
	                '<button style="background-color:red;">Delete</button>',
	                function (instance, toast) {

		               $.ajax({
					     type: "get",
					     url: baseUrl+'/inventory/penerimaan_barang/hapus_penerimaan_barang',
					     data: {id},
					     success: function(data){

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
