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
  				<li class="breadcrumb-item active" aria-current="page">Stock Barang</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
        	<div class="card">
  	        <div class="card-body">
  	          <h4 class="card-title">Stock Barang</h4>
  	          	<div class="row">
                  @if (App\mMember::akses('INPUT STOCK BARANG', 'tambah'))
  	          		<div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <button type="button" class="btn btn-info" id="tombol_modal_tambah" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
  	          			{{-- <button class="btn btn-info btn-sm" type="button" data-target="#cari_po" id="button_add" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add Data</button> --}}
  	          		</div>
                  @endif
                  <input type="hidden" name="id">
        					<div class="table-responsive" style="margin-top: 15px;">
        						<table class="table table-hover" id="datatable" cellspacing="0">
        						  <thead class="bg-gradient-info">
        						    <tr>
        						      <th>Item </th>
        						      <th>Name</th>
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

@include('inventory.stockbarang.tambah');
@include('inventory.stockbarang.edit');
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script type="text/javascript">

  $('.select2').select2();

  function autoitem(){
    waitingDialog.show()
    var item = $('#itemtambah').val();
    $.ajax({
      type: 'get',
      data: {item:item},
      dataType: 'json',
      url: '{{ route('autoitem') }}',
      success : function(result){
        if (result.status == 'kosong') {
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        } else {
          $('.unit').val(result[0].u_unit);
          $('.price').val(result[0].i_price);
          $('.labelprice').text('Price ('+result[0].i_price_currency+')');
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        }
      }
    });
  }

  function autoitemedit(){
    waitingDialog.show()
    var item = $('#itemedit').val();
    $.ajax({
      type: 'get',
      data: {item:item},
      dataType: 'json',
      url: '{{ route('autoitem') }}',
      success : function(result){
        if (result.status == 'kosong') {
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        } else {
          $('#unitedit').val(result[0].u_unit);
          $('#priceedit').val(result[0].i_price);
          $('#labelpriceedit').text('Price ('+result[0].i_currency_id+')');
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        }

      }
    });
  }

	var table = $('#datatable').DataTable({
            processing: true,          // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_stockbarang') }}',
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

  function simpan(){
    waitingDialog.show()
    $.ajax({
      type: 'get',
      dataType: 'json',
      data: $('#simpan_barang').serialize(),
      url: baseUrl + '/inventory/stockbarang/simpan',
      success : function(result){
        if (result.status == 'berhasil') {
          iziToast.success({
            icon: 'fa fa-check',
            message: 'Berhasil Disimpan!',
          });
          table.ajax.reload()
          $('#tambah').modal('hide');
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        } else if (result.status == 'kesalahan') {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
          $('#tambah').modal('hide');
          setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
        } else if (result.status == 'gagal') {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Gagal Disimpan!',
          });
          $('#tambah').modal('hide');

        }
      }
    });
  }

  function hapus(id){
    iziToast.show({
    timeout: false,
    theme: 'dark',
    icon: 'fa fa-question',
    title: 'Hapus?',
    message: 'Anda yakin ingin menhapus data?,<br>Data yang sudah dihapus tidak bisa dikembalikan!',
    position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
    progressBarColor: '#57c7d4',
    buttons: [
        ['<button>Ya</button>', function (instance, toast) {
          waitingDialog.show()
          $.ajax({
            type: 'get',
            data: {id:id},
            dataType: 'json',
            url: baseUrl + '/inventory/stockbarang/hapus',
            success : function(result){
              if (result.status == 'berhasil') {
                iziToast.success({
                  icon: 'fa fa-check',
                  message: 'Berhasil Dihapus!',
                });
                table.ajax.reload()
                setTimeout(function () {
                              waitingDialog.hide();
                          }, 500);
              } else if (result.status == 'gagal') {
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Gagal Dihapus!',
                });
                setTimeout(function () {
                              waitingDialog.hide();
                          }, 500);
              }
            }
          });
        }, true], // true to focus
        ['<button>Tidak</button>', function (instance, toast) {
            instance.hide();
        }]
    ],
});
}

function edit(id){
  $('input[name=id]').val(id);

  $('#edit').modal('show');

  $.ajax({
    type: 'get',
    data: {id:id},
    dataType: 'json',
    url: baseUrl + '/inventory/stockbarang/edit',
    success : function(result){
      $('#itemedit').val(result[0].i_code).change();
      $('#priceedit').val(result[0].sg_harga);
      $('#qtyedit').val(result[0].sg_qty);
    }
  });
}

function update(){
  var id = $('input[name=id]').val();
  waitingDialog.show()
  $.ajax({
    type: 'get',
    dataType: 'json',
    data: $('#update_barang').serialize()+'&id='+id,
    url: baseUrl + '/inventory/stockbarang/update',
    success : function(result){
      if (result.status == 'berhasil') {
        iziToast.success({
          icon: 'fa fa-check',
          message: 'Berhasil Disimpan!',
        });
        table.ajax.reload()
        $('#edit').modal('hide');
        setTimeout(function () {
                      waitingDialog.hide();
                  }, 500);
      } else if (result.status == 'kesalahan') {
        iziToast.warning({
          icon: 'fa fa-times',
          message: 'Terjadi Kesalahan!',
        });
        ('#edit').modal('hide');
        setTimeout(function () {
                      waitingDialog.hide();
                  }, 500);
      } else if (result.status == 'gagal') {
        iziToast.warning({
          icon: 'fa fa-times',
          message: 'Gagal Disimpan!',
        });
        ('#edit').modal('hide');
        setTimeout(function () {
                      waitingDialog.hide();
                  }, 500);
      }
    }
  });
}



</script>


@endsection
