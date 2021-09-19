@extends('main')

@section('extra_style')
<style type="text/css">

  .float-left{
    float:left;
  }
  .float-right{
    float:right;
  }
  [class^="col-"]{
    line-height: 2;
  }
  .mr-3-custom{
    margin-right: 1rem;
  }

  [type="radio"]{
    margin-right: .25rem;
  }
  @media (max-width: 992px){
    .mr-3-custom{
      margin-right: 0;
    }
  }
  @media(max-width: 576px){
    .preview_td{
      text-align: center;
    }
  }
</style>
@endsection

@section('content')

@include('master.barang.tambah')


<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Data Barang</li>
  			</ol>
  		</nav>
  	</div>

  	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                  <div class="card-body">
  	                <h4 class="card-title">Master Data Barang</h4>
                    @if (App\mMember::akses('MASTER DATA BARANG', 'tambah'))
  		                <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
  		                  	<button type="button" class="btn btn-info" id="tombol_modal_tambah" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
  		                </div>
                    @endif
                      <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                          <div class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Notice!</strong> <br>
                              1.  Untuk Koma Menggunakan titik ( . )<br>
                              2.  Jangan Lupa Memilih Currency nya
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12" >
                          <label>Cari Barang</label>
                        </div>

                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="input-group">
                            <input type="text" class="form-control cari_barang" style="text-transform:uppercase" placeholder="Berdasarkan Nama" name="cari_barang" style="margin-bottom: 20px">
                            <span class="input-group-append">
                              <button class="btn btn-primary pull-right cari"><i class="fa fa-search"> Cari</i></button>
                            </span>
                          </div>
                        </div>

                      </div>


                      <div class="table-responsive">
                        <table id="t55" class="table table-hover table-bordered" cellspacing="0">
                          <thead class="bg-gradient-info">
                              <tr>
                                <th class="wd-15p" width="3%">No</th>
                                <th class="wd-15p" width="5%">Item Code</th>
                                <th class="wd-15p">Item Name</th>
                                <th width="15%">Sell Price</th>
                                <th width="15%">Lower Price</th>
                                <th class="wd-15p" width="3%">Unit</th>
                                <th width="25%">Category Item</th>
                                <th>Image</th>
                                <th width="5%">Action</th>
                              </tr>
                            </thead>
                            <tbody id="showdata">

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

<script src="{{ asset('modul_keuangan/js/vendors/inputmask/inputmask.jquery.js') }}"></script>

<script>

  // $('.rp').mask("#,##0.00", {reverse: true});

$(document).ready(function(){

    $('.rp').inputmask("currency", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        allowMinus: true,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: true,
        oncleared: function () {  }
    })

    $('#t55').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            searching: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url:'{{ route("datatable_barang") }}',
                data:{nota: function() { return $('.cari_barang').val() }},
                error:function(){
                  // location.reload();
                }
            },
            columnDefs: [
                  {
                     targets: 0 ,
                     className: 'center '
                  },
                  {
                     targets: 1 ,
                     className: 'center i_id'
                  },
                  {
                     targets: 2,
                     className: 'i_nama'
                  },
                  {
                     targets: 3,
                     className: 'i_price'
                  },
                  {
                     targets: 4,
                     className: 'i_price'
                  },
                  {
                     targets: 5,
                     className: 'center'
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
                  }
                ],
            "columns": [
            {data: 'DT_Row_Index',      name: 'DT_Row_Index'},
            { "data": "i_code" },
            { "data": "i_name" },
            { "data": "sell"},
            { "data": "lower"},
            { "data": "u_unit" },
            { "data": "i_jenis" },
            { "data": "gambar"},
            { "data": "aksi" },

            ]
      });
  });


function change_image()
{
  if($('#cbcheck:checkbox:checked').length > 0)
  {
    $('.122mm').removeClass('d-none');
  } else {
    $('.122mm').addClass('d-none');

  }
}

$('.cari').click(function(){
  var keyword = $('.cari_barang').val();
  var html = '';
  $.ajax({
    type: 'get',
    data: {keyword:keyword},
    dataType: 'json',
    url: baseUrl + '/master/barang/caribarang',
    success : function(result){
      for (var i = 0; i < result.length; i++) {
        var harga = result[i].i_price * result[i].cu_value;

        if(result[i].i_image!=''){
                          var url = "{{route('barang_thumbnail')}}"+'/'+result[i].i_image+'?'+{{time()}};
          var gambar = '<img src="'+url+'" border="0" width="60" class="img-rounded" align="center" />';
        }else{
          var gambar = '<i class="fa fa-minus-square"></i>';
        }
        html += '<tr>'+
                '<td>'+(i + 1)+'</td>'+
                '<td>'+result[i].i_code+'</td>'+
                '<td>'+result[i].i_name+'</td>'+
                '<td>'+
                '<div class="float-left">'+result[i].cu_symbol+'</div>'+
                '<div class="float-right">'+result[i].i_price+'</div></td>'+
                '<td><div class="float-left">Rp. </div>'+
                '<div class="float-right">'+accounting.formatMoney(harga, "", 2, ".", ",")+'</div></td>'+
                '<td>'+result[i].u_unit+'</td>'+
                '<td>'+result[i].i_jenis+'</td>'+
                '<td>'+gambar+'</td>'+
                '<td>'+
                '<div class="btn-group">'+
                         '<button type="button" onclick="edit(this)" class="btn btn-info btn-lg" title="edit">'+
                         '<label class="fa fa-pencil-alt"></label></button>'+
                         '<button type="button" onclick="hapus(this)" class="btn btn-danger btn-lg" title="hapus">'+
                         '<label class="fa fa-trash"></label></button>'+
                        '</div>'+
                '</td>'+
                '</tr>';
      }

      $('#showdata').html(html);
    }
  });
})

$('#tombol_modal_tambah').click(function(){

    $('.122mm').removeClass('d-none');
    $('input[name="item_name"]').val('');
    $('#chooseFile').val('');
    $('#noFile').text('Choose Image...');
    $(".file-upload").removeClass('active');
    $('.preview_td').html('<img id="output" >');
    $('select[name="type_barang"]').val('').trigger('change');
    $('input[name="unit"]').val('');
    $('input[name="price"]').val('');
    $('input[name="weight"]').val('');
    $('input[name="min_stock"]').val('0');
    $('textarea[name="description"]').val('');
    $('input[name="item_codex"]').val('');
    $('input[name="lower_price"]').val('');
    $('input[name="sell_price"]').val('');
    $('input[name="currency"]').val('IDR');

    $('input[name="item_name"]').removeClass('border-danger');
    $('#chooseFile');
    $('select[name="type_barang"]').removeClass('border-danger');
    $('input[name="unit"]').removeClass('border-danger');
    $('input[name="price"]').removeClass('border-danger');
    $('input[name="weight"]').removeClass('border-danger');
    $('input[name="min_stock"]').removeClass('border-danger');
    $('textarea[name="description"]');

    $('#ganti_tombol').html('<button class="btn btn-primary" type="button" onclick="simpan()">Save Data</button>');

    $("#check_change_image").html('');

  });

$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>2048576) //do something if file size more than 1 mb (1048576)
  {
      return false;
  }
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});

var loadFile = function(event) {
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
  {
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'File Is To Big!',
      });
      return false;
  }
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('output');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};

function simpan(){

    var item  = $('input[name="item_name"]');
    var img   = $('#chooseFile');
    var type_barang  = $('select[name="type_barang"]');
    var unit = $('input[name="unit"]');
    var price = $('input[name="price"]');
    var weight = $('input[name="weight"]');
    var category = $('input[name="category"]');
    var min_stock = $('input[name="min_stock"]');
    var description = $('textarea[name="description"]');
    var sell_price = $('input[name="sell_price"]');
    var lower_price = $('input[name="lower_price"]');
    var price_currency = $('input[name=price_currency]');
    var sell_currency = $('input[name=sell_price_currency]');
    var lower_currency = $('input[name=lower_price_currency]');
    var akunpersediaan = $('input[name=akunpersediaan]');
    var akunpendapatan = $('input[name=akunpendapatan]');
    var akunbeban = $('input[name=akunbeban]');
    if(lower_currency.val() == '' || sell_currency.val() == '' || price_currency.val() == '' || item.val()=='' || type_barang.val()=='' || unit.val()=='' || price.val()=='' || weight.val()=='' || min_stock.val()=='' || sell_price.val()=='' || lower_price.val()=='' || img.val()=='' || category.val()=='')
    {
      if(item.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item name cannot be empty!',
            });
        item.addClass('border-danger');
      } else {
        item.removeClass('border-danger');
      }
      if(img.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Image cannot be empty!',
            });
        img.addClass('border-danger');
      } else {
        img.removeClass('border-danger');
      }
      if(type_barang.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item type cannot be empty!',
            });
        type_barang.addClass('border-danger');
      } else {
        type_barang.removeClass('border-danger');
      }
      if(unit.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Unit# cannot be empty!',
            });
        unit.addClass('border-danger');
      } else {
        unit.removeClass('border-danger');
      }
      if(price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item price cannot be empty!',
            });
        price.addClass('border-danger');
      } else {
        price.removeClass('border-danger');
      }
      if(weight.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Weight cannot be empty!',
            });
        weight.addClass('border-danger');
      } else {
        weight.removeClass('border-danger');
      }
      if(min_stock.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Min stock cannot be empty!',
            });
        min_stock.addClass('border-danger');
      } else {
        min_stock.removeClass('border-danger');
      }


      if(sell_price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Sell Price cannot be empty!',
            });
        sell_price.addClass('border-danger');
      } else {
        sell_price.removeClass('border-danger');
      }

      if(lower_price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Lower Price cannot be empty!',
            });
        lower_price.addClass('border-danger');
      } else {
        lower_price.removeClass('border-danger');
      }

    if(category.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Category cannot be empty!',
          });
      category.addClass('border-danger');
    } else {
      category.removeClass('border-danger');
    }

    if(price_currency.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Price Currency cannot be empty!',
          });
      price_currency.addClass('border-danger');
    } else {
      price_currency.removeClass('border-danger');
    }

    if(sell_currency.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Sell Price Currency cannot be empty!',
          });
      sell_currency.addClass('border-danger');
    } else {
      sell_currency.removeClass('border-danger');
    }

    if(lower_currency.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Lower Price Currency cannot be empty!',
          });
      lower_currency.addClass('border-danger');
    } else {
      lower_currency.removeClass('border-danger');
    }

    if(akunpendapatan.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Akun pendapatan cannot be empty!',
          });
      akunpendapatan.addClass('border-danger');
    } else {
      akunpendapatan.removeClass('border-danger');
    }

    if(akunpersediaan.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Akun persediaan cannot be empty!',
          });
      akunpersediaan.addClass('border-danger');
    } else {
      akunpersediaan.removeClass('border-danger');
    }

    if(akunbeban.val()==''){
      iziToast.error({
            icon: 'fa fa-exclamation-circle ',
            message: 'Akun beban cannot be empty!',
          });
      akunbeban.addClass('border-danger');
    } else {
      akunbeban.removeClass('border-danger');
    }

    return false;
  }

    var formdata = new FormData();
    formdata.append( 'files', $('#chooseFile')[0].files[0]);
    $.ajax({
         type: "post",
         url: baseUrl + '/master/barang/barangproses?'+$('#simpan_barang').serialize(),
         data: formdata,
         processData: false, //important
         contentType: false,
         cache: false,
         success: function(data){
            $('#tambah').modal('hide');
            var table = $('#t55').DataTable();
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
}


function edit(m1a2)
{
    $('input[name="item_name"]').removeClass('border-danger');
    $('select[name="type_barang"]').removeClass('border-danger');
    $('input[name="unit"]').removeClass('border-danger');
    $('input[name="price"]').removeClass('border-danger');
    $('input[name="weight"]').removeClass('border-danger');
    $('input[name="category"]').removeClass('border-danger');
    $('input[name="min_stock"]').removeClass('border-danger');
    $('input[name="sell_price"]').removeClass('border-danger');
    $('input[name="lower_price"]').removeClass('border-danger');
    $('input[name="akunpendapatan"]').removeClass('border-danger');
    $('input[name="akunpersediaan"]').removeClass('border-danger');
    $('input[name="akunbeban"]').removeClass('border-danger');

    var par   = $(m1a2).parents('tr');
    var id    = $(par).find('.i_id').text();
    $.ajax({
       type: "get",
         url: baseUrl + '/master/barang/barang_edit',
         data: {id},
         success: function(data){

            var i_id      = $("input[name='kode_barang']").val(data[0].i_id);
            var i_code    = $("input[name='item_name']").val(data[0].i_name);
            var i_unit      = $("input[name='unit']").val(data[0].i_unit).trigger('change');
            var i_weight      = $("input[name='weight']").val(data[0].i_weight);
            var i_currency      = $(".currency").val(data[0].i_currency_id);
            var i_currency      = $(".currency").trigger('change');
            var i_price      = $("input[name='price']").val(data[0].i_price);
            var i_minstock      = $("input[name='min_stock']").val(data[0].i_minstock);
            var i_description      = $("textarea[name='description']").val(data[0].i_description);
            var i_type      = $("select[name='type_barang']").val(data[0].i_type).trigger('change');
            var i_jenis      = $("select[name='category']").val(data[0].i_jenis).trigger('change');
            var i_akun_persediaan      = $("select[name='akunpersediaan']").val(data[0].i_akun_persediaan).trigger('change');
            var i_akun_pendapatan      = $("select[name='akunpendapatan']").val(data[0].i_akun_pendapatan).trigger('change');
            var i_akun_beban      = $("select[name='akunbeban']").val(data[0].i_akun_beban).trigger('change');
            var i_unit      = $("input[name='unit']").val(data[0].i_unit);
            var price_currency = $('input[name=price_currency][value='+data[0].i_price_currency.toLowerCase()+']').prop('checked', 'checked');
            var sell_price_currency = $('input[name=sell_price_currency][value='+data[0].i_sell_currency.toLowerCase()+']').prop('checked', 'checked');
            var lower_price_currency = $('input[name=lower_price_currency][value='+data[0].i_lower_currency.toLowerCase()+']').prop('checked', 'checked');
            var i_sell_price      = $("input[name='sell_price']").val(data[0].i_sell_price);
            var i_lower_price      = $("input[name='lower_price']").val(data[0].i_lower_price);

            if(data[0].i_image!='' || data[0].i_image!=null){
              $('.preview_td').html('');
              var html =  '<img style="border:1px solid pink" id="output" src="{{ route('barang_thumbnail') }}/'+data[0].i_image+'?'+Math.random()+'" >';
              $('.preview_td').html(html);
              $('.file-upload').addClass('active');
              $("#noFile").text(data[0].i_image);
            } else {
              $('#chooseFile').val('');
              $('#noFile').text('Choose Image...');
              $(".file-upload").removeClass('active');
              $('.preview_td').html('<img style="border:1px solid pink" id="output" >');
            }
            $('.122mm').addClass('d-none');

            $('#ganti_tombol').html('<button class="btn btn-primary" type="button" onclick="update()">Update Data</button>')

            $('#check_change_image').html('<label class="form-check-label">'+
                              '<input class="form-check-input" type="checkbox" name="cbcheck" id="cbcheck" value="centang" onchange="change_image()">'+
                              'Check for change image'+
                          '<i class="input-helper"></i></label>');

            $('#tambah').modal('show');
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


function update() {

  var item  = $('input[name="item_name"]');
  var img   = $('#chooseFile');
  var type_barang  = $('select[name="type_barang"]');
  var unit = $('input[name="unit"]');
  var price = $('input[name="price"]');
  var weight = $('input[name="weight"]');
  var category = $('input[name="category"]');
  var min_stock = $('input[name="min_stock"]');
  var description = $('textarea[name="description"]');
  var sell_price = $('input[name="sell_price"]');
  var lower_price = $('input[name="lower_price"]');
  var price_currency = $('input[name=price_currency]');
  var sell_currency = $('input[name=sell_price_currency]');
  var lower_currency = $('input[lower_price_currency]');
    if(lower_currency.val() == '' || sell_currency.val() == '' || price_currency.val() == '' || item.val()=='' || type_barang.val()=='' || unit.val()=='' || price.val()=='' || weight.val()=='' || min_stock.val()=='' || sell_price.val()=='' || lower_price.val()=='' || category.val()=='')
    {
      if(item.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item name cannot be empty!',
            });
        item.addClass('border-danger');
      } else {
        item.removeClass('border-danger');
      }
      if(type_barang.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item type cannot be empty!',
            });
        type_barang.addClass('border-danger');
      } else {
        type_barang.removeClass('border-danger');
      }
      if(unit.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Unit# cannot be empty!',
            });
        unit.addClass('border-danger');
      } else {
        unit.removeClass('border-danger');
      }
      if(price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Item price cannot be empty!',
            });
        price.addClass('border-danger');
      } else {
        price.removeClass('border-danger');
      }
      if(weight.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Weight cannot be empty!',
            });
        weight.addClass('border-danger');
      } else {
        weight.removeClass('border-danger');
      }

      if(min_stock.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Min stock cannot be empty!',
            });
        min_stock.addClass('border-danger');
      } else {
        min_stock.removeClass('border-danger');
      }


      if(sell_price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Sell Price cannot be empty!',
            });
        sell_price.addClass('border-danger');
      } else {
        sell_price.removeClass('border-danger');
      }

      if(lower_price.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Lower Price cannot be empty!',
            });
        lower_price.addClass('border-danger');
      } else {
        lower_price.removeClass('border-danger');
      }

      if(price_currency.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Price Currency cannot be empty!',
            });
        price_currency.addClass('border-danger');
      } else {
        price_currency.removeClass('border-danger');
      }

      if(sell_currency.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Sell Price Currency cannot be empty!',
            });
        sell_currency.addClass('border-danger');
      } else {
        sell_currency.removeClass('border-danger');
      }

      if(lower_currency.val()==''){
        iziToast.error({
              icon: 'fa fa-exclamation-circle ',
              message: 'Lower Price Currency cannot be empty!',
            });
        lower_currency.addClass('border-danger');
      } else {
        lower_currency.removeClass('border-danger');
      }

      return false;
    }

    var formdata = new FormData();
    formdata.append( 'files', $('#chooseFile')[0].files[0]);

      $.ajax({
          processData: false, //important
          contentType: false,
          cache: false,
          type: "post",
          url: baseUrl + '/master/barang/barang_update?'+$('#simpan_barang').serialize(),
          data: formdata,
          success: function(data){
            if (data.status == '1') {
              $('#tambah').modal('hide');
              var table = $('#t55').DataTable();
              table.ajax.reload();
              iziToast.success({
                icon: 'fas fa-check-circle',
                message: 'Data Telah Terupdate!',
              });
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
   }


function hapus(a) {
    var par   = $(a).parents('tr');
    var id    = $(par).find('.i_id').text();

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
                      url: baseUrl +'/master/barang/baranghapus',
                      type:'get',
                      data: {id},
                      dataType:'json',
                      success:function(data){
                        if (data.status == '1') {
                          var table = $('#t55').DataTable();
                          table.ajax.reload();
                          iziToast.success({
                            icon: 'fa fa-check',
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

</script>
@endsection
