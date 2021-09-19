@extends('main')
@section('content')

@include('quotation.n_penawaran.tambah_nilaipenawaran')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12"> 
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active" aria-current="page">Master Data Customer</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Data Customer</h4>
                     <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info button_add" data-toggle="modal" id="button_add" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    <div class="table-responsive">
        				        <table class="table table-hover " id="table-np" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                               <th>Item Kode</th>
                               <th>Marketing</th>
        			                 <th>Item Name</th>
        			                 <th>Lower Limit Price</th>
                               <th>Item Price</th>
        			                 <th width="1%">Action</th>
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
    
    $('#table-np').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_Npenawaran') }}',
            },
             columnDefs: [
                  {
                     targets: 0 ,
                     className: 'center d_id'
                  }, 
                  {
                     targets: 3 ,
                     className: 'right'
                  }, 
                  {
                     targets: 4 ,
                     className: 'right'
                  }, 
                ],
            "columns": [
            { "data": "np_kode" },
            { "data": "marketing" },
            { "data": "item" },
            { "data": "np_lowerlimit"},
            { "data": "np_price"},
            { "data": "aksi" },
            ]
      });

  

  $(document).ready(function(){
	  $('.button_add').click(function(){
            var table = $('#object_906').DataTable();
            table.clear().draw();
	    	    $('.hilangin').show();
            $('#d_marketname').val('').trigger('change');
            $('#d_itemname').val('').trigger('change');
            $('#d_price').val('');
            $('#kode_old').val('');
            $('#d_lowerprice').val('');
	  })	
  	$('#d_lowerprice').attr('disabled',true);

        var m_table        = $("#object_906").DataTable();
        var n_lowerprice   = $("#d_lowerprice");
        var n_item         = $("#d_itemname");
        var n_price        = $("#d_price");
        var x = 1;

        var a = n_lowerprice.val();
        var b = n_price.val();
        a = a.replace(/[^0-9\-]+/g,"");
        b = b.replace(/[^0-9\-]+/g,"");

        n_price.keypress(function(e) {
	      if(e.which == 13 || e.keyCode == 13){
	        if (a < b) {
	           iziToast.warning({
	             icon: 'fa fa-times',
	             message: 'Lower Price lebih rendah dari Price!',
	           });
	          return false;
	        }
	        m_table.row.add( [

	            '<input type="text" id="item_kode[]"  name="item_kode[]" class="form-control input-sm min-width" value="'+ n_item.val()+'">',
	            '<input type="text" id="item_name[]"  name="item_name[]" class="form-control input-sm min-width" value="'+ n_item.find(':selected').data('name')+'">',
	            '<input type="text" id="item_price[]"  name="item_price[]" class="form-control input-sm min-width right" readonly value="'+ n_lowerprice.val() +'">',
	            '<input type="text" id="item_lowerprice[]" name="item_lowerprice[]" class="form-control input-sm min-width right" value="'+ n_price.val() +'">',           
              '<input type="hidden"  name="item_flag[]" class="form-control input-sm min-width right" value="'+ n_item.find(':selected').data('flag') +'">',
	            '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
	        ] ).draw( false );
	  
	        x++;
	        n_item.focus();
	        n_item.val('').trigger('change');
	        n_price.val('');
	        n_lowerprice.val('');
	      }
	    });
	 
	    

	    $('#object_906 tbody').on( 'click', '.delete', function () {
	    m_table
	        .row( $(this).parents('tr') )
	        .remove()
	        .draw();
	    });

	    $('#d_itemname').change(function(){
	        var ini = $('#d_itemname').find(':selected').val();

	        if(ini != '') {
	          $('#d_price').attr('disabled',false);
	        }else{
	          $('#d_price').attr('disabled',true);          
	        }
	        var i_price = $(this).find(':selected').data('harga');
	        $('#d_lowerprice').val(accounting.formatMoney(i_price,"",0,'.',','));
	    })
 
  })

  $('#save_data').click(function(){

    $.ajax({
         type: "get",
         url: baseUrl + '/quotation/n_penawaran/simpan_n_penawaran',
         data: $('#form-save').serialize(),
         success: function(data){
            $('#tambah').modal('hide');
            var table = $('#table-np').DataTable();
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

  function edit(parm){
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();
    $('#tambah').modal('show');
    $.ajax({
       type: "get",
         url: baseUrl + '/quotation/dataeditNpenawaran/dataedit_Npenawaran',
         data: {id},
         success: function(data){
          console.log(data);
            $('.hilangin').hide();
            $('#d_marketname').val(data[0].np_marketing).trigger('change');
            $('#d_itemname').val(data[0].np_kodeitem).trigger('change');
            $('#d_price').val(data[0].np_lowerlimit);
            $('#kode_old').val(data[0].np_kode);
            $('#d_lowerprice').val(data[0].np_price);

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
                     url: baseUrl + '/quotation/hapusNpenawaran/hapus_Npenawaran',
                     data: {id},
                     success: function(data){
                      console.log(data);
                      var table = $('#table-np').DataTable();
              		  table.ajax.reload();
                      iziToast.success({
                        icon: 'fas fa-check-circle',
                        message: 'Data Telah Terhapus!',
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

  	function update() {
      $.ajax({
           type: "get",
           url: baseUrl + '/quotation/updateNpenawaran/update_Npenawaran',
           data: $('#form-save').serialize(),
           success: function(data){
              $('#tambah').modal('hide');
              var table = $('#table-np').DataTable();
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

  </script>

@endsection