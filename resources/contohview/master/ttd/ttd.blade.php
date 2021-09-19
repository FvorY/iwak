@extends('main')
@section('content')

@include('master.ttd.tambah_ttd')
@include('master.ttd.edit_ttd')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Master</li>
					<li class="breadcrumb-item active" aria-current="page">Master Data TTD</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Master Data TTD</h4>
										@if(Session::has('sukses'))
                        <div class="alert alert-fill-primary" role="alert">
													<i class="mdi mdi-alert-circle"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong>{{ Session::get('sukses') }}</strong>
                        </div>
                    @elseif(Session::has('gagal'))
											<div class="alert alert-fill-danger" role="alert">
												<i class="mdi mdi-alert-circle"></i>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
																			aria-hidden="true">&times;</span></button>
													<strong>{{ Session::get('gagal') }}</strong>
											</div>
                    @endif
										@if (App\mMember::akses('MASTER DATA TTD', 'tambah'))
	                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
	                  	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah_ttd"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
	                  </div>
										@endif
	                  <div class="table-responsive">
		                  <table class="table data-table table-hover" cellspacing="0">
		                  	<thead class="bg-gradient-info">
		                  		<tr>
		                  			<th>No</th>
		                  			<th>Name</th>
		                  			<th>Signature Image</th>
		                  			<th>Action</th>
		                  		</tr>
		                  	</thead>
		                  	<tbody>
													@foreach ($data as $key => $value)
														<tr>
															<td>{{$key + 1}}</td>
															<td class="s_name">{{$value->s_name}}</td>
															<td align="center">
																<img src="{{url('/') . '/' . $value->s_image}}" border="0" width="60" class="img-rounded" align="center">
															</td>
															<td align="center">
																<div class="btn-group">
																	<button type="button" onclick="edit(this, {{$value->s_id}})" class="btn btn-info btn-lg" title="edit"><label class="fa fa-pencil-alt"></label></button>
																	<button type="button" onclick="hapus({{$value->s_id}})" class="btn btn-danger btn-lg" title="hapus"><label class="fa fa-trash"></label></button>
																</div>
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
	function submit(){
		$('#tambahttd').submit();
	}
	function update(){
		$('#editttd').submit();
	}

	function hapus(id) {

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
							 '<button style="background-color:#44d7c9;">Process</button>',
							 function (instance, toast) {
							 //ajax
								$.ajax({
									type: "get",
									url: baseUrl + '/master/ttd/hapus',
									data: {id},
									success: function(data){
										if (data.status == 'berhasil') {
											window.location.href = baseUrl + '/master/ttd/ttd';
										}
									},
									error: function(){
									 iziToast.warning({
										 icon: 'fa fa-times',
										 message: 'Terjadi Kesalahan!',
									 });
									},
									async: false
								});
							 //end of ajax


							 }

						 ],
						 [
							 '<button style="background-color:red;">Cancel</button>',
							 function (instance, toast) {
								 instance.hide({
									 transitionOut: 'fadeOutUp'
								 }, toast);
							 }
						 ]
					 ]
				 });
	 }

	 function edit(parm, s_id){
		 var par   = $(parm).parents('tr');
     var id    = $(par).find('.s_name').text();

		 $('#s_name').val(id);
		 $('#s_id').val(s_id);
		 $('#edit_ttd').modal('show');
	 }
</script>
@endsection
