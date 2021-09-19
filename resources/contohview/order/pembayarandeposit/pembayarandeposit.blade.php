@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Order</li>
  				<li class="breadcrumb-item active" aria-current="page">Pembayaran Deposit</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">
  	          <h4 class="card-title">Pembayaran Deposit</h4>
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
  	          	<div class="table-responsive" style="margin-bottom: 15px;">
  		            <table id="table_quote" class="table table-hover " cellspacing="0">
  			              <thead class="bg-gradient-info">
  			                <tr>
  			                  <th>No</th>
  			                  <th>Q.O.#</th>
  			                  <th>Customer</th>
  			                  <th>Total Bill</th>
  			                  <th>DP</th>
                          <th>Remain</th>
                          <th>Status SO</th>
  			                  <th>Status WO</th>
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
<script type="text/javascript">

$(document).ready(function(){
	$('#table_quote').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
          url:'{{ route('datatable_deposit') }}',
      },
      columnDefs: [

              {
                 targets: 0 ,
                 className: 'center'
              },
              {
                 targets: 1 ,
                 className: 'q_nota'
              },
              {
                 targets: 3,
                 className: 'right'
              },
              {
                 targets: 4,
                 className: 'right'
              },
              {
                 targets: 5,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'center'
              },
              {
                 targets: 7,
                 className: 'center'
              },
              {
                 targets: 8,
                 className: 'center'
              },

            ],
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index'},
        {data: 'q_nota', name: 'q_nota'},
        {data: 'c_name', name: 'c_name'},
        {data: 'total', name: 'total'},
        {data: 'dp', name: 'dp'},
        {data: 'remain', name: 'remain'},
        {data: 'status_so', name: 'status_so'},
        {data: 'status_wo', name: 'status_wo'},
        {data: 'aksi', name: 'aksi'},

      ]

	});
})

function approve(id) {
  iziToast.show({
          overlay: true,
          close: false,
          timeout: 20000,
          color: 'dark',
          icon: 'fas fa-question-circle',
          title: 'Approve data!',
          message: 'Apakah Anda Yakin ?!',
          position: 'center',
          progressBarColor: 'rgb(0, 255, 184)',
          buttons: [
            [
              '<button style="background-color:#32CD32;">Save</button>',
              function (instance, toast) {;

            $.ajax({
            type: 'get',
            url:baseUrl + '/order/pembayarandeposit/approve_deposit',
            data: {id},
            dataType:'json',
            success:function(data){
              if (data.status == 1) {
                location.href = "{{ url('/order/pembayarandeposit/pembayarandeposit') }}";
              }else if(data.status == 8){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pembukuan Jurnal Keuangan Gagal. Harap Segera Menghubungi Developer...!',
                });
              }else{
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Sudah Ada!',
                });
              }

            },error:function(){
              iziToast.warning({
                  icon: 'fa fa-info',
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
