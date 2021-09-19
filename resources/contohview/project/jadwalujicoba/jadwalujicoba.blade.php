
@extends('main')

@section('extra_style')

<style type="text/css">

</style>
@endsection

@section('content')


<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Project Manajemen Pompa | SHS</li>
					<li class="breadcrumb-item active" aria-current="page">Schedule Uji Coba dan Dokumentasi</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	            <div class="card">
	                <div class="card-body">
						<h4 class="card-title">Schedule Uji Coba dan Dokumentasi</h4>
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
						@if (App\mMember::akses('SCHEDULE UJI COBA DAN DOKUMENTASI', 'tambah'))
						<div class="text-right mb-3">
							<a href="{{url('project/jadwalujicoba/tambah_jadwal')}}" class="btn btn-info" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</a>
						</div>
						@endif

					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-gradient-info">
								<tr>
									<th width="1%">No.</th>
									<th>Date Created</th>
									<th>Title</th>
									<th width="15%">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $key => $value)
									<tr>
										<td>{{$key + 1}}</td>
										<td>{{Carbon\Carbon::parse($value->s_insert)->format('d-F-Y G:i:s')}}</td>
										<td>{{$value->s_title}}</td>
										<td align="center">
											<div class="btn-group btn-group-sm">
												<a class="btn btn-primary" target="_blank" href="{{route('pdf_jadwal')}}?id={{encrypt($value->s_id)}}" title="Print Report"><i class="fa fa-print"></i></a>
												<!-- <button class="btn btn-success" type="button" title="Print Installation" onclick="print({{$value->s_id}})"><i class="fa fa-print"></i></button> -->
												<a class="btn btn-success" target="_blank" href="{{route('pdf_install')}}?id={{encrypt($value->s_id)}}" title="Print Installation"><i class="fa fa-print"></i></a>
												<button class="btn btn-danger" type="button" title="Delete" onclick="hapus({{$value->s_id}})"><i class="fa fa-trash"></i></button>
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


<script>


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
								url: baseUrl + '/project/jadwalujicoba/hapus_jadwal',
								data: {id},
								success: function(data){
									if (data.status == 'berhasil') {
										window.location.href = baseUrl + '/project/jadwalujicoba/jadwalujicoba';
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

</script>

@endsection
