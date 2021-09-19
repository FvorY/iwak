@extends('main')
@section('content')

@include('quotation/marketing/tambah')
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">	
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Quotation</li>
  				<li class="breadcrumb-item active" aria-current="page">Marketing Team</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">
  	          <h4 class="card-title">Marketing Team</h4>
  	          	<div class="row">
  	          		
  					<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
  						<button class="btn btn-info" data-toggle="modal" id="button_add" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
  					</div>
                    <div class="table-responsive">
        				    <table class="table table-hover" id="table-marketing" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>Marketing ID</th>
                                <th>Marketing Name</th>
                                <th>Marketing Type</th>
                                <th>Information</th>
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
	
	   $('#table-marketing').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatalble_marketing') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center d_id'
                  },
                  {
                     targets: 1 ,
                     className: ' user_id'
                  }, 
                ],
            "columns": [
            { "data": "mk_code" },
            { "data": "mk_name" },
            { "data": "mk_type" },
            { "data": "mk_information" },
            { "data": "aksi" },
            ]
      });

  $('#button_add').click(function(){
    var d_name      = $("input[name='d_name']").val('');
    var d_hometown  = $("select[name='d_hometown']").val('').trigger('change');
    var d_tlp       = $("input[name='d_tlp']").val(''); 
    var d_email     = $("input[name='d_email']").val(''); 
    var d_alamat    = $("textarea#d_alamat").val(''); 
    var d_tipe      = $("select[name='d_tipe']").val('').trigger('change'); 
    var d_informasi = $("textarea#d_informasi").val('');
    $('#change_function').html('<button class="btn btn-primary" type="button" id="save_data" >Save Data</button>')
     $.ajax({
         type: "get",
         url:'{{ route('kode_marketing') }}',
         success: function(data){
          console.log(data);
            var mp_id   = $("input[name='d_id']").val(data);
         },
         async: false
       });

  })

  $('#change_function').on("click", "#save_data",function(){
    $.ajax({
         type: "get",
         url: baseUrl + '/quotation/simpanmarketing/simpan_marketing',
         data: $('#form_save').serialize(),
         success: function(data){
            $('#tambah').modal('hide');
            var table = $('#table-marketing').DataTable();
            table.ajax.reload();

            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
            });
         },
         error: function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
         },
         async: false
       });
  })

   function update() {
      $.ajax({
           type: "get",
           url: baseUrl + '/quotation/updatemarketing/update_marketing',
           data: $('#form_save').serialize(),
           success: function(data){
              $('#tambah').modal('hide');
              var table = $('#table-marketing').DataTable();
              table.ajax.reload();

              iziToast.success({
                icon: 'fas fa-check-circle',
                message: 'Data Telah Terupdate!',
              });
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
    $('#tambah').modal('show');
    $.ajax({
       type: "get",
         url: baseUrl + '/quotation/dataeditmarketing/dataedit_marketing',
         data: {id},
         success: function(data){
          // console.log(data);
            var d_name      = $("input[name='d_name']").val(data[0].mk_name);
    		    var d_tlp       = $("input[name='d_tlp']").val(data[0].mk_phone); 
    		    var d_email     = $("input[name='d_email']").val(data[0].mk_email); 
    		    var d_alamat    = $("textarea#d_address").val(data[0].mk_address); 
    		    var d_tipe      = $("select[name='d_tipe']").val(data[0].mk_type).trigger('change'); 
    		    var d_informasi = $("textarea#d_informasi").val(data[0].mk_information);
            var d_kodeold   = $("input[name='kode_old']").val(data[0].mk_code);
    		    var d_id   = $("input[name='d_id']").val(data[0].mk_code);

            $('#change_function').html('<button class="btn btn-primary" type="button" onclick="update()">Update Data</button>')
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
                     url: baseUrl + '/quotation/hapusmarketing/hapus_marketing',
                     data: {id},
                     success: function(data){
                      console.log(data);
                      var table = $('#table-marketing').DataTable();
                      table.ajax.reload();
                      
                     
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