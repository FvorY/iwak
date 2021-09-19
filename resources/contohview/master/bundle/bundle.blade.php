@extends('main')
@section('content')

@include('master.bundle.tambah')

@include('master.bundle.detail')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Data Bundle Item</li>
  			</ol>
  		</nav>
  	</div>

  	<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                  <div class="card-body">
  	                <h4 class="card-title">Master Data Bundle Item</h4>
                    @if (App\mMember::akses('MASTER DATA BUNDLE ITEM', 'tambah'))
  		                <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
  		                  	<button type="button" class="btn btn-info" data-toggle="modal" id="button_add" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
  		                </div>
                    @endif
                    <div class="table-responsive">
                            <table class="table table-hover table-bordered " id="table-bundle" cellspacing="0">
                              <thead class="bg-gradient-info">
                                  <tr>
                                    <th class="wd-15p" width="5%">Bundle Id</th>
                                    <th class="wd-15p" width="5%">Bundle Code</th>
                                    <th class="wd-15p" width="20%">Bundle Name</th>
                                    <th class="wd-15p" >Description</th>
                                    <th>Price Bundle (USD)</th>
                                    <th>Price Bundle (Rp)</th>
                                    <th width="15%">Action</th>
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
    // $('#bund_qty').maskMoney({
    //   precision : 0,
    //   thousands:'',
    // });

    // $('.sell_price').maskMoney({
    //   precision : 0,
    //   thousands:'.',
    //   allowZero:true,
    //   defaultZero: true
    // });

    // $('.lower_price').maskMoney({
    //   precision : 0,
    //   thousands:'.',
    //   allowZero:true,
    //   defaultZero: true
    // });


    $('#button_add').click(function(){
          $("input[name='ib_name']").val('');
          $("input[name='ib_price']").val('');
          $("input[name='ib_price']").val('');
          $("input[name='keterangan']").val('');
          $(".sell_price").val('');
          $(".lower_price").val('');
            var table = $('#bundle_table').DataTable();
            table.clear().draw();
            $('#change_function').html('<button class="btn btn-primary" type="button" id="save_data" >Save Data</button>')
    })

    $('#bund_qty').attr('disabled',true);
    $('#bund_kodeitem').change(function(){
          var ini = $('#bund_kodeitem').find(':selected').val();

          if(ini != '') {
            $('#bund_qty').attr('disabled',false);
          }else{
            $('#bund_qty').attr('disabled',true);
          }
          var h_price = $(this).find(':selected').data('harga');
          var currency = $(this).find(':selected').data('currency');
          $('#bund_item').val(h_price*100/100);
          $('#currency').val(currency);
    })

    $('#table-bundle').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url:'{{ route('datatable_bundleitem') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id center'
                  },
                  {
                     targets: 1 ,
                     className: 'i_code center'
                  },
                  {
                     targets: 6 ,
                     className: 'center '
                  },
                  {
                     targets: 5,
                     className: 'right'
                  },
                  {
                     targets: 4,
                     className: 'right'
                  },
                ],
            "columns": [
            {data: 'DT_Row_Index', name: 'DT_Row_Index'},
            {data: 'i_code', name: 'i_code'},
            {data: 'i_name', name: 'i_name'},
            {data: 'i_description', name: 'i_description'},
            {data: 'dollars'},
            {data: 'convert',render: $.fn.dataTable.render.number( ',', '.', 0, '' )},
            {data: 'aksi', name: 'aksi'},
            ]
      });

      var table = $("#bundle_table").DataTable({
                    columnDefs: [
                        {
                           targets: 6,
                           className: 'center'
                        }
                      ],
                  });
      var x = 1;

    // $('#bund_qty').keyup(function(){
    //   var jumlah = $('#bund_item').val().replace(/[^0-9.\-]+/g,"")*1;
    //   var qty = $(this).val();
    //   $('.ib_price').val(accounting.formatMoney(jumlah * qty,"",0,'.',','))
    // })
    $('#bund_qty').keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        var kode = $('#bund_kodeitem').val();
        var cur = $('.m_currency').val();
        var qty = $('#bund_qty').val().replace(/[^0-9\-]+/g,"");
        // harga_1 = harga_1.replace(/[^0-9\-]+/g,"");
        $.ajax({
         type: "get",
         url: baseUrl + '/master/bundle/cari_item',
         dataType:'json',
         data:{kode},
         success: function(data){

            if (data.data.cu_value == null) {
              var currency = 1;
            } else if(data.data.cu_code != cur){
              var currency = data.data.cu_value;
            }else if(data.data.cu_code == cur){
              var currency = 1;
            }
            var price  = parseInt(qty)*parseFloat(data.data.i_price)*currency;

            table.row.add( [
               '<input type="text" id="item_kode[]" name="ib_kode_dt[]" class="form-control input-sm min-width" readonly="" value="'+data.data.i_code+'">',
                '<input type="text" id="item_name[]" name="ib_name_dt[]" class="form-control input-sm min-width" readonly="" value="'+data.data.i_name+'">',
                '<input type="text" id="jumlah[]" name="ib_qty_dt[]" class="form-control input-sm min-width right format_money" readonly="" value="'+qty+'">',
                '<input type="text" readonly id="[]" name="ib_unit_dt[]" class="form-control input-sm min-width right format_money" value="'+data.data.u_unit+'asdas">',
                '<input type="text" name="ib_price_dt[]" class="ib_price_dt form-control input-sm min-width right format_money" readonly="" value="'+data.data.i_price*currency  +'">',
                '<input type="text" name="ib_total_price[]" class="ib_total_price form-control input-sm min-width right format_money" readonly="" value="'+ price +'" data-val="'+price+'">',
                '<button type="button" class="delete btn btn-outline-danger btn-sm hapus"><i class="fa fa-trash"></i></button>',
            ]).draw( false );

            x++;
            var awal = 0;
            table.$('.ib_total_price').each(function(){
              var total = $(this).val();
              var total2 = $(this).data('val');
              awal += parseFloat(total2);

              // console.log(total2);
            });
            $(".ib_price").val(awal);
            $('#bund_kodeitem').val('').trigger('change');
            $('#bund_qty').val('');
            $('#bund_item').val('');
            $('.lower_price').val(awal);
            $('.sell_price').val(awal);
            $('.cur_div').addClass('disabled');
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
    });



  $('#bundle_table tbody').on( 'click', '.delete', function () {
    var parents = $(this).parents('tr');
    var ib_price_dt = $(parents).find('.ib_price_dt').val();
    var ib_price = $("input[name='ib_price']").val();

    table
        .row(parents)
        .remove()
        .draw();

    var awal = 0;
    table.$('.ib_total_price').each(function(){
      var total = $(this).val();
      awal += parseFloat(total);
    });

    if (awal == 0) {
      $('.cur_div').removeClass('disabled');

    }
    $("input[name='ib_price']").val(awal);
    $(".sell_price").val(awal);
    $(".lower_price").val(awal);

  });

  $('.form-control').keyup(function(){
    $(this).removeClass('border-danger');
  });


  $('#change_function').on("click", "#save_data",function(){

    var name = $('.ib_name');
    var price = $('.ib_price');
    var sell_price = $('.sell_price');
    var lower_price = $('.lower_price');
    var keterangan = $('.keterangan');
    var valid = [];

    if (name.val() == '') {
        name.addClass('border-danger');
        valid.push(0);
    } else {
        name.removeClass('border-danger');
        valid.push(1);
    }

    if (price.val() == '' || price.val() == '0') {
        price.addClass('border-danger');
        valid.push(0);
    } else {
        price.removeClass('border-danger');
        valid.push(1);
    }

    if (sell_price.val() == '' || sell_price.val() == '0') {
        sell_price.addClass('border-danger');
        valid.push(0);
    } else {
        sell_price.removeClass('border-danger');
        valid.push(1);
    }

    if (lower_price.val() == '' || lower_price.val() == '0') {
        lower_price.addClass('border-danger');
        valid.push(0);
    } else {
        lower_price.removeClass('border-danger');
        valid.push(1);
    }


    if (keterangan.val() == '') {
        keterangan.addClass('border-danger');
        valid.push(0);
    } else {
        keterangan.removeClass('border-danger');
        valid.push(1);
    }

    var index = valid.indexOf(0);
    if (index !=  -1) {
      iziToast.error({
        icon: 'fa fa-exclamation-circle ',
        message: 'Harap Lengkapi Data!',
      });
      return false;
    }
    $.ajax({
         type: "get",
         url: baseUrl + '/master/bundleitem/simpan_bundleitem',
         data: $('#form-save').serialize(),
         success: function(data){

          if (data.status == 1) {
            $('#tambah').modal('hide');
            var table = $('#table-bundle').DataTable();
            table.ajax.reload();

            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
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
  })

  });

function detail(parm) {
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();
    $('#detail').modal('show');
    $.ajax({
       type: "get",
         url: '{{ route('detail_bundleitem') }}',
         data: {id},
         success: function(data){
          var array_nama='';
          $.each(data, function(i, item) {
              array_nama += '<tr>';
                array_nama += '<td>'+data[i].ibd_barang+' - '+data[i].i_name+'</td>';
                array_nama += '<td align="right">'+accounting.formatMoney(data[i].ibd_price,"",0,'.',',')+'</td>';
              array_nama += '</tr>';
          })
          $('#detail_rep').html(array_nama);


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

function edit(id){
    window.location.href = (baseUrl +'/master/bundle/edit_bundle/'+id);
  }

  function hapus(parm){
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.i_code').text();
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
                     url: '{{ route('hapus_bundleitem') }}',
                     data: {id},
                     success: function(data){
                      $('#tambah').modal('hide');
                      var table = $('#table-bundle').DataTable();
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
           url: '{{ route('hapus_bundleitem') }}',
           data: $('#form-save').serialize(),
           success: function(data){
              $('#tambah').modal('hide');
              var table = $('#table-bundle').DataTable();
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
