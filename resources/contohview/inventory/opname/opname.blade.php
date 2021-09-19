@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Inventory</li>
					<li class="breadcrumb-item active" aria-current="page">Stock Opname</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Stock Opname</h4>
		          	<div class="row">

						@if (App\mMember::akses('STOCK OPNAME', 'tambah'))
						<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
							<button class="btn btn-info" onclick="create()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
						</div>
						@endif
						<div class="table-responsive">
							<table class="table table-hover data-table" id="table_opname" cellspacing="0">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>Code</th>
							      <th>Date</th>
										<th>Status</th>
							      <th>Action</th>
							    </tr>
							  </thead>
								<tbody>
									@foreach ($data as $key => $value)
										<tr>
											<td>{{$key + 1}}</td>
											<td>{{$value->so_code}}</td>
											<td>{{Carbon\Carbon::parse($value->so_bulan)->format('d-m-Y')}}</td>
											@if ($value->so_status == 'Y')
												<td> <label class="badge badge-primary">Approved</label> </td>
											@else
												<td> <label class="badge badge-warning">Need Approved</label> </td>
											@endif
											<td align="center">
												<button class="btn btn-print btn-info" data-cetak="{{$value->so_id}}" type="button" title="Print"><i class="fa fa-print"></i></button>
												<button type="button" class="btn btn-primary" name="button" onclick="detail({{$value->so_id}}, '{{$value->so_status}}')" title="Detail"> <i class="fa fa-folder"></i> </button>
											</td>
										</tr>
									@endforeach
								</tbody>
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

<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel-2">Detail</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-hover data-table" cellspacing="0">
                          	<thead>
                          		<th>Item</th>
															<th>System</th>
															<th>Real</th>
															<th>Status</th>
                          	</thead>
														<tbody id="showdetail">
														</tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
													<button type="button" class="btn btn-primary" style="display:none" onclick="approve()" id="approve" name="button">Approve</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script type="text/javascript">
	$('#table_opname tbody').on('click', '.btn-print', function(){
		var id = $(this).data('cetak');

		window.open('{{route('print_opname')}}?id='+id, '_blank');
	});

	function create(){
		window.location = ('{{ route('create_stockopname') }}')
	}

	function detail(id, status){
		var html = '';
		var auth = "{{Auth::user()->m_jabatan}}";
		$.ajax({
			type: 'get',
			data: {id:id},
			dataType: 'json',
			url : baseUrl + '/inventory/opname/detail',
			success : function(result){
				for (var i = 0; i < result.length; i++) {
					html += '<tr>'+
									'<td>'+result[i].i_name+'</td>'+
									'<td>'+result[i].sodt_system+'</td>'+
									'<td>'+result[i].sodt_real+'</td>'+
									'<td>'+result[i].sodt_status_item+'</td>'+
									'</tr>';
				}
				$('#showdetail').html(html);

				if (auth == "MANAGER") {
					if (status == 'N') {
						$('#approve').attr('onclick', 'approve('+id+')');
						$('#approve').css('display', '');
					} else {
						$('#approve').css('display', 'none');
					}
				}

				$('#modaldetail').modal('show');
			}
		});
	}

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
	                '<button style="background-color:red;">Approve</button>',
	                function (instance, toast) {

	                  $.ajax({
	                      url: baseUrl +'/inventory/opname/approve',
	                      type:'get',
	                      data: {id},
	                      dataType:'json',
	                      success:function(data){
													if (data.status == 'berhasil') {
														iziToast.success({
														 icon: 'fa fa-check',
														 message: 'Data Berhasil diapprove!',
													 });
													 window.location.reload();
													} else {
														iziToast.warning({
														 icon: 'fa fa-times',
														 message: 'Data gagal diapprove!',
													 });
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
