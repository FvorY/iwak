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
					<li class="breadcrumb-item active" aria-current="page">Proforma Invoice</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Proforma Invoice</h4>
		          	<div class="row">
						<div class="table-responsive">
							<table class="table table-hover table_quote" id="table_quote" cellspacing="">
							  <thead class="bg-gradient-info">
							    <tr>
							      <th>No</th>
							      <th>P.I.#</th>
							      <th>Q.O.#</th>
										<th>Customer</th>
							      <th>Total Bill</th>
										<th>DP</th>
										<th>Paid</th>
										<th>Remain</th>
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
          url:'{{ route('datatable_proforma_invoice') }}',
      },
      columnDefs: [
              {
                 targets: 0 ,
                 className: 'center'
              },
              {
                 targets: 1 ,
                 className: 'p_nota'
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
                 className: 'center'
              },
            ],
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index'},
        {data: 'pi', name: 'pi'},
        {data: 'q_nota', name: 'q_nota'},
				{data: 'c_name', name: 'c_name'},
				{data: 'total', name: 'total'},
        {data: 'dp', name: 'dp'},
				{data: 'po_total', name: 'po_total'},
        {data: 'remain', name: 'remain'},
        {data: 'aksi', name: 'aksi'},
      ]
	});
})

function edit(id) {
	location.href = '{{ url('order/proforma_invoice/detail_proforma_invoice') }}'+'/'+id;
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
                '<button style="background-color:red;">Delete</button>',
                function (instance, toast) {

                  $.ajax({
                      url: baseUrl +'/order/proforma_invoice/hapus_proforma_invoice',
                      type:'get',
                      data: {id},
                      dataType:'json',
                      success:function(data){
                        if (data.status == '1') {
                          var table = $('#table_quote').DataTable();
                          table.ajax.reload();
                          iziToast.success({
                            icon: 'fa fa-trash',
                            message: 'Data Berhasil Dihapus!',
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
function printing(id){

  window.open('{{route('print_proforma_invoice')}}?id='+id,'_blank');

}

function printtanda(id){

	window.open( baseUrl + '/order/proforma_invoice/printproformakasih?id='+id,'_blank');

}
</script>
@endsection
