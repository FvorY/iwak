@extends('main')
@section('content')

@include('master/type/tambah_type')
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Data Tipe Barang</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">
  	          <h4 class="card-title">Master Data Tipe Barang</h4>
  	          	<div class="row">

  					<div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
  						<button class="btn btn-info" id="tombol_modal_tambah" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
  					</div>
  					<div class="table-responsive">
  						<table class="table table-hover table-bordered" cellspacing="0" id="t80um">
  						  <thead class="bg-gradient-info">
  						    <tr>
  						      <th width="20">No</th>
  						      <th>Type Code</th>
  						      <th>Type Item</th>
  						      <th width="100">Action</th>
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


    $('#t80um').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_type") }}',
            },
            columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center it_id'
                  },
                  {
                     targets: 1,
                     className: 'it_code'
                  },
                  {
                     targets: 2,
                     className: 'it_name'
                  },
                  {
                     targets: 3,
                     className: 'center'
                  }
                ],
            "columns": [
            { "data": "it_id" },
            { "data": "it_code"},
            { "data": "it_name" },
            { "data": "aksi" },

            ]
      });

  });

	$('#tombol_modal_tambah').click(function(){

    var t_name = $('input[name="t_name"]').val('');
    var t_code = $('input[name="t_code"]').val('');
    var item_codex = $('input[name="it_codex"]').val('');

    $('input[name="t_name"]').removeClass('border-danger');
    $('input[name="t_code"]').removeClass('border-danger');

    $('#ganti_tombol').html('<button class="btn btn-primary" type="button" onclick="simpan()">Save Data</button>');

  });

	function simpan()
	{
    var type  = $('input[name="t_name"]');
    var t_code = $('input[name="t_code"]');

    if(type.val()=='' || t_code.val()=='')
    {
      if(type.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Type name cannot be empty!',
            });
        type.addClass('border-danger');
      } else {
        type.removeClass('border-danger');
      }
      if(t_code.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Type code cannot be empty!',
            });
        t_code.addClass('border-danger');
      } else {
        t_code.removeClass('border-danger');
      }
      return false;
    }
		var form = $('#simpan_tipe').serialize();
		$.ajax({
	         type: "get",
	         url: baseUrl + '/master/type/typeproses',
	         data: form,
	         success: function(data){
	            $('#tambah').modal('hide');
	            var table = $('#t80um').DataTable();
	            table.ajax.reload();

	            iziToast.success({
	              icon: 'fa fa-check-circle',
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
	}

  function update()
  {
    var type  = $('input[name="t_name"]');
    var t_code = $('input[name="t_code"]');

    if(type.val()=='' || t_code.val()=='')
    {
      if(type.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Type name cannot be empty!',
            });
        type.addClass('border-danger');
      } else {
        type.removeClass('border-danger');
      }
      if(t_code.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Type code cannot be empty!',
            });
        t_code.addClass('border-danger');
      } else {
        t_code.removeClass('border-danger');
      }
      return false;
    }
    var form = $('#simpan_tipe').serialize();
    $.ajax({
           type: "get",
           url: baseUrl + '/master/type/type_update',
           data: form,
           success: function(data){
              $('#tambah').modal('hide');
              var table = $('#t80um').DataTable();
              table.ajax.reload();

              iziToast.success({
                icon: 'fa fa-check-circle',
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
  }

	function edit(m1a2)
{

    $('input[name="t_name"]').removeClass('border-danger');
    $('input[name="t_code"]').removeClass('border-danger');

    var par   = $(m1a2).parents('tr');
    var id    = $(par).find('.it_id').text();
    $.ajax({
       type: "get",
         url: baseUrl + '/master/type/type_edit',
         data: {id},
         success: function(data){
          $('#tambah').modal('show');
          	var t_codex	   = $("input[name='it_codex']").val(data[0].it_id);
            var it_id      = $("input[name='t_code']").val(data[0].it_code);
            var it_code    = $("input[name='t_name']").val(data[0].it_name);

            $('#ganti_tombol').html('<button class="btn btn-primary" type="button" onclick="update()">Update Data</button>')
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
  function hapus(a) {
    var par   = $(a).parents('tr');
    var id    = $(par).find('.it_id').text();
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
				        url: baseUrl +'/master/type/type_hapus',
				        type:'get',
				        data: {id},
				        dataType:'json',
				        success:function(data){
				          var table = $('#t80um').DataTable();
				          table.ajax.reload();
				          console.log(data);
				          iziToast.success({
				            icon: 'fa fa-check',
				            message: 'Data Berhasil Dihapus!',
				          });

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
