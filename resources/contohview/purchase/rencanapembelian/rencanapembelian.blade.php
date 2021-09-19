@extends('main')
@section('content')

@include('purchase.rencanapembelian.tambah')
@include('purchase.rencanapembelian.detail')
@include('purchase.rencanapembelian.edit')

<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Purchase</li>
          <li class="breadcrumb-item active" aria-current="page">Request Order</li>
        </ol>
      </nav>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

                    <div class="card-title">
                      <ul class="nav nav-tabs tab-solid  tab-solid-primary" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="tab-6-1" data-toggle="tab" href="#daftar" role="tab" aria-controls="daftar" aria-selected="true"><i class="fa fa-list"></i>List Request Order</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tab-6-2" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false"><i class="mdi mdi-history"></i>History Request Order</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a class="nav-link" id="tab-6-3" data-toggle="tab" href="#tab-ke-3" role="tab" aria-controls="tab-ke-3" aria-selected="false"><i class="mdi mdi-message-text-outline"></i>Contact</a>
                        </li> -->
                      </ul>
                    </div>

                      @if (App\mMember::akses('REQUEST ORDER', 'tambah'))
                        <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                          <button type="button" class="btn btn-info tambah" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                        </div>
                      @endif

                        <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="alert alert-primary alert-dismissible" title="Approved">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Notice!</strong> <br>
                                <label class="badge badge-pill badge-primary">{{$approved}}</label>
                                Approved
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="alert alert-warning alert-dismissible" title="Need Approved">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Notice!</strong> <br>
                                <label class="badge badge-pill badge-warning">{{$need}}</label>
                                Need Approved
                            </div>
                          </div>
                        </div>

                    <div class="tab-content tab-content-solid">
                      <div class="tab-pane fade show active" id="daftar" role="tabpanel" aria-labelledby="tab-6-1">

                        <div class="table-responsive">
                          <table class="table table-hover table-bordered" id="table_datatable_rencana" cellspacing="0">
                            <thead class="bg-gradient-info">
                                <tr>
                                  <th class="wd-15p">Kode</th>
                                  <th class="wd-15p">Tanggal</th>
                                  <th class="wd-20p">Vendor</th>
                                  <th class="wd-15p">Amount Requested</th>
                                  <th class="wd-10p">Amount Approved</th>
                                  <th class="wd-15p">Status</th>
                                  <th class="wd-10p">Detail</th>
                                  <th class="wd-15p">Action</th>
                                </tr>
                              </thead>
                              <tbody>


                              </tbody>

                            </table>
                        </div>

                      </div> <!-- end div daftar -->

                      <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="tab-6-2">
                        <div class="table-responsive">
                          <table class="table table-hover table-bordered " id="table_datatable_histori" style="width: 100%;" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th class="wd-15p">Id</th>
                                <th class="wd-15p">Kode</th>
                                <th class="wd-15p">Item</th>
                                <th class="wd-15p">Amount Requested</th>
                                <th class="wd-10p">Amount Approved</th>
                                <th class="wd-10p">Status</th>
                              </tr>
                            </thead>

                            <tbody>
                            </tbody>

                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="tab-ke-3" role="tabpanel" aria-labelledby="tab-6-3">
                        <!-- content -->
                      </div>


                    </div> <!-- end div tab-content -->

                  </div><!-- end div card -->
                </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
  <script type="text/javascript">
    var totaledit;
    $(document).ready(function(){
       $('#table_datatable_rencana').DataTable({
              processing: true,
              // responsive:true,
              serverSide: true,
              dom: 'Bfrtip',
              title: '',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              aasorting: [],
              ajax: {
                  url:'{{ route('datatable_rencanapembelian') }}',
              },
               columnDefs: [

                    {
                       targets: 0 ,
                       className: 'd_id center'
                    },
                    {
                       targets: 2 ,
                       className: 'right'
                    },
                    {
                       targets: 5 ,
                       className: 'center'
                    },

                  ],
              "columns": [
              { "data": "ro_code" },
              { "data": "ro_insert" },
              { "data": "s_company" },
              { "data": "ro_qty" },
              { "data": "ro_qty_approved" },
              { "data": "status" },
              { "data": "detail" },
              { "data": "aksi" },
              ]
        });

       $('#table_datatable_histori').DataTable({
              processing: true,
              // responsive:true,
              serverSide: true,
              dom: 'Bfrtip',
              title: '',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              aasorting: [],
              ajax: {
                  url:'{{ route('datatable_historypembelian') }}',
              },
               columnDefs: [

                    {
                       targets: 0 ,
                       className: 'left'
                    },
                    {
                       targets: 1 ,
                       className: 'right format_money'
                    },
                    {
                       targets: 3 ,
                       className: 'right format_money'
                    },
                    {
                       targets: 4 ,
                       className: 'right format_money'
                    },
                    {
                       targets: 5 ,
                       className: 'center'
                    },

                  ],
              "columns": [
              { "data": "rodt_code" },
              { "data": "rodt_id" },
              { "data": "i_name" },
              { "data": "rodt_qty" },
              { "data": "rodt_qty_approved" },
              { "data": "status" },
              ]
        });


      var table           = $("#t72a").DataTable();
      var rp_qty         = $("#rp_qty");
      var rp_item          = $("#rp_item");
      var rp_kodeitem       = $("#rp_kodeitem");

      var x = 1;

      $('#rp_qty').attr('disabled',true);
      $('#rp_kodeitem').change(function(){
        var this_val = $(this).find(':selected').data('price');
            if($(this).val() != '') {
              $('#rp_qty').attr('disabled',false);
            }else{
              $('#rp_qty').attr('disabled',true);
            }
        var price = $('#rp_item').val(accounting.formatMoney(this_val,"",0,'.',','));
      });


      rp_qty.keypress(function(e) {
        if(e.which == 13 || e.keyCode == 13){
          var qty = rp_qty.val();
          var harga_1 = rp_item.val();
          var currency = rp_kodeitem.find(':selected').data('currency');

          qty = qty.replace(/[^0-9\-]+/g,"");
          harga_1 = harga_1.replace(/[^0-9\-]+/g,"");


          var itemname = [];
          var selectedVal;
          $(".itemkode").each(function(i, sel){
              selectedVal = $(sel).val();
              itemname.push(selectedVal);
          });

          var tmp = "no";
          for (var i = 0; i < itemname.length; i++) {
            if (itemname[i] == rp_kodeitem.val()) {
              tmp = "yes";
            }
          }

          if (tmp == "yes") {
            iziToast.warning({
              icon: 'fa fa-times',
              message: 'Sudah ada item yang sama!',
            });
          } else {
            var total = parseInt(harga_1)*parseInt(qty);
            table.row.add( [
                '<input type="text" id="item_kode[]" name="ro_item_seq[]" class="form-control input-sm min-width readonly itemkode" readonly value="'+ rp_kodeitem.val() +'">',
                '<input type="text" id="item_name[]" class="form-control input-sm min-width readonly" value="'+ rp_kodeitem.find(':selected').data('name') +'">',
                '<input type="text" id="item_harga[]" onkeyup="item_satuan(this)" name="ro_unit_price_seq[]" class="form-control input-sm min-width right readonly item_satuan rp" value="'+currency+'. '+ accounting.formatMoney(rp_kodeitem.find(':selected').data('price'),"",0,'.',',') +'" data-curr="'+currency+'">',
                '<input type="text" id="item_harga[]"   name="ro_price_seq[]"  readonly  class="form-control input-sm min-width right readonly total_price " value="'+currency+'. '+ accounting.formatMoney(total,"",0,'.',',') +'">',
                '<input type="number" id="jumlah[]"   name="ro_qty_seq[]"    class="form-control input-sm min-width right readonly total_qty " value="'+ accounting.formatMoney(rp_qty.val(),"",0,'.',',') +'">',
                '<input type="text" id="unit_price[]"   name=""    class="form-control input-sm min-width right readonly" readonly  value="'+ rp_kodeitem.find(':selected').data('qty') +'">',
                '<center><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></center>'
            ] ).draw( false );

            x++;
          }

          $('.rp').maskMoney({prefix:currency+'. ', thousands:'.', decimal:',', precision:0});

          var total_price = 0;
          $('.total_price').each(function(){
            var total = $(this).val();
            total = total.replace(/[^0-9\-]+/g,"");
            total_price += parseInt(total);
          });
          $("input[name='ro_total_header']").val(currency+'. ' + accounting.formatMoney(total_price,"",0,'.',','));

          var total_qty = 0;
          $('.total_qty').each(function(){
            var total = $(this).val();
            total = total.replace(/[^0-9\-]+/g,"");
            total_qty += parseInt(total);
          });
          $("input[name='ro_qty_header']").val(accounting.formatMoney(total_qty,"",0,'.',','));

          rp_item.focus();
          rp_item.val('');
          rp_kodeitem.val('').trigger('change');
          rp_qty.val('');
        }
      });

      $('#t72a').on( 'click', function () {

      });

      $('#t72a tbody').on( 'click', '.delete', function () {
          table
              .row($(this).parents('tr'))
              .remove()
              .draw();

          var parents = $(this).parents('tr');
          var total_price_seq = $(parents).find('.total_price').val();
          var total_qty_seq = $(parents).find('.total_qty').val();
          var total_price_header = $("input[name='ro_total_header']").val();
          var total_qty_header = $("input[name='ro_qty_header']").val();

          total_price_header = total_price_header.replace(/[^0-9\-]+/g,"");
          total_qty_header = total_qty_header.replace(/[^0-9\-]+/g,"");
          total_price_seq = total_price_seq.replace(/[^0-9\-]+/g,"");
          total_qty_seq = total_qty_seq.replace(/[^0-9\-]+/g,"");

          var kurang_total = parseInt(total_price_header)-parseInt(total_price_seq);
          var kurang_qty = parseInt(total_qty_header)-parseInt(total_qty_seq);
          $("input[name='ro_total_header']").val(accounting.formatMoney(kurang_total,"",0,'.',','));
          $("input[name='ro_qty_header']").val(accounting.formatMoney(kurang_qty,"",0,'.',','));

      });

    $('#change_function').on("click", "#save_data",function(){
      $.ajax({
           type: "get",
           url: '{{ route('simpan_rencanapembelian') }}',
           data: $('#form-save').serialize(),
           success: function(data){
              var table_history = $('#table_datatable_histori').DataTable();
              var table_rencana = $('#table_datatable_rencana').DataTable();
              table_history.ajax.reload();
              table_rencana.ajax.reload();
              iziToast.success({
                icon: 'fas fa-check-circle',
                message: 'Data Telah Tersimpan!',
              });
              $('#tambah').modal('hide');
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

    $('.tambah').click(function(){
        $.ajax({
           type: "get",
           url: '{{ route('kode_rencanapembelian') }}',
           success: function(data){
              $('#ro_code').val(data);
           }
         });

    })




    });
  function detail(parm) {
      var par   = $(parm).parents('tr');
      var id    = $(par).find('.d_id').text();
      $('#detail_modal').modal('show');
      $.ajax({
         type: "get",
           url: '{{ route('detail_rencanapembelian') }}',
           data: {id:id},
           success: function(data){
            var array_nama='';
            $.each(data, function(i, item) {
                array_nama += '<tr>';
                  array_nama += '<td><input type="hidden" class="form-control right" value="'+data[i].rodt_id+'" name="kode_detail[]">'+data[i].rodt_barang+' - '+data[i].i_name+'</td>';
                  array_nama += '<td align="right"><input type="hidden" class="form-control right" value="'+data[i].rodt_code+'" name="kode[]">'+accounting.formatMoney(data[i].rodt_price,"",0,'.',',')+'</td>';
                  array_nama += '<td align="right" class="qty">'+data[i].rodt_qty+'</td>';
                  if (data[i].rodt_qty_approved != 0) {
                      array_nama += '<td align="right"><input type="text"  name="approved[]" onkeyup="qty(this)" readonly value="'+data[i].rodt_qty_approved+'" class="form-control right qty_approved_value hanya_angka"></td>';
                  }else{
                      array_nama += '<td align="right"><input type="text"  name="approved[]"  onkeyup="qty(this)" value="'+data[i].rodt_qty+'" class="form-control right qty_approved_value hanya_angka"></td>';
                  }

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
    function qty(a){
        //HITUNG QTY PADA TABLE
        var parents_qty = $(a).parents('tr');
        var qty_value = $(parents_qty).find('.qty').text();
        var qty_approved_value = $(parents_qty).find('.qty_approved_value').val();
        //regex
        //PERINGATAN MELEBIHI BATAS QTY
        if (parseInt(qty_approved_value) > parseInt(qty_value)) {
          iziToast.warning({
              icon: 'fa fa-times',
              message: 'Qty Melebihi Batas MAX!',
          });

          $(parents_qty).find('.qty_approved_value').val(0);

        }
      }

  function hapus(parm){
      var par   = $(parm).parents('tr');
      var id    = $(par).find('.d_id').text();

      iziToast.show({
              overlay: true,
              close: false,
              timeout: 20000,
              color: 'dark',
              icon: 'fa-exclamation-circle',
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
                       url: '{{ route('hapus_rencanapembelian') }}',
                       data: {id},
                       success: function(data){
                        $('#tambah').modal('hide');
                        var table = $('#table-bundle').DataTable();
                        table.ajax.reload();

                        iziToast.success({
                          icon: 'fas fa-check-circle',
                          message: 'Data Telah Terhapus!',
                        });
                       location.reload();
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


    $('#change_detail').on("click", "#approve_data",function(){
      iziToast.show({
              overlay: true,
              close: false,
              timeout: 20000,
              color: 'dark',
              icon: 'fas fa-exclamation-circle',
              title: 'Important!',
              message: 'Apakah Anda Yakin ?!',
              position: 'center',
              progressBarColor: 'rgb(0, 255, 184)',
              buttons: [
                [
                  '<button style="background-color:red;">Save</button>',
                  function (instance, toast) {


                    $.ajax({
                     type: "get",
                     url: '{{ route('approve_rencanapembelian') }}',
                     data: $('#form-detail').serialize(),
                     success: function(data){
                        $('#detail').modal('hide');
                        var table_history = $('#table_datatable_histori').DataTable();
                        var table_rencana = $('#table_datatable_rencana').DataTable();
                        table_history.ajax.reload();
                        table_rencana.ajax.reload();

                        iziToast.success({
                          icon: 'fas fa-check-circle',
                          message: 'Data Telah Tersimpan!',
                        });

                        setTimeout(function(){ location.reload(); }, 1000);
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




    })

    $('#ro_vendor_header').change(function(){
      var this_val = $(this).val();
        $.ajax({
           type: "get",
           url: '{{ route('kode_rencanapembelian') }}',
           data: {vendor:this_val},
           success: function(data){
              $('#ro_code').val(data);
           }
         });
    })


     function item_satuan(a){
        //HITUNG QTY PADA TABLE
        // alert('okee');
        var parents = $(a).parents('tr');
        var satuan_harga = $(parents).find('.item_satuan').val();
        var total_qty = $(parents).find('.total_qty').val();

        var curr = $(parents).find('.item_satuan').data('curr');
        //regex
        satuan_harga = satuan_harga.replace(/[^0-9\-]+/g,"");
        total_qty = total_qty.replace(/[^0-9\-]+/g,"");


        //PERINGATAN MELEBIHI BATAS QTY

        var hitung = parseInt(satuan_harga)*parseInt(total_qty);
        $(parents).find('.total_price').val(curr+'. ' + accounting.formatMoney(hitung,"",0,'.',','));


        var total_price = 0;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });
        $("input[name='ro_total_header']").val(curr+'. ' + accounting.formatMoney(total_price,"",0,'.',','));


        //HITUNG SUBTOTAL DAN TOTAL NET PADA TABLE
        var total_price = 0;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });

        $("#po_subtotal").val(accounting.formatMoney(total_price,"",0,'.',','));

        //PENGURANGAN TAX
        var tax =  $('#po_tax').val();
        tax = tax.replace(/[^0-9\-]+/g,"");
        hitung_tax = parseInt(total_price)+parseInt(tax);
        $('#total_net').val(accounting.formatMoney(hitung_tax,"",0,'.',','));

      }

      $('#tambah').on('hidden.bs.modal', function (e) {
          $(this)
         .find("input,textarea,select")
         .val('')
         .end()
         .find("input[type=checkbox], input[type=radio]")
         .prop("checked", "")
         .end();


         window.location.reload();
  });

    function close(){
      $(this)
     .find("input,textarea,select")
     .val('')
     .end()
     .find("input[type=checkbox], input[type=radio]")
     .prop("checked", "")
     .end();


     window.location.reload();
    }

    function edit(parm){
      var par   = $(parm).parents('tr');
      var id    = $(par).find('.d_id').text();

      $.ajax({
        type: 'get',
        data: {id},
        dataType: 'json',
        url: baseUrl + '/purchase/rencanapembelian/edit_rencanapembelian',
        success : function(response){
          tables.clear();
          $('#ro_codes').val(response.dataheader[0].ro_code);
          $('#ro_dates').val(response.dataheader[0].ro_insert);

          $('#ro_vendor_headers').val(response.dataheader[0].ro_vendor).trigger('change');
          $('#ro_total_headers').val('Rp. '+accounting.formatMoney(response.dataheader[0].ro_price,"",0,'.',','));
          totaledit = response.dataheader[0].ro_price;
          for(var i=0; i < response.dataseq.length; i++){
            if(response.dataseq[i].sg_qty == null){
              var qtygudang = 0;
            } else {
              var qtygudang = response.dataseq[i].sg_qty;
            }
            tables.row.add( [
              '<input type="text" id="item_kode[]"   name="ro_item_seq[]"    class="form-control input-sm min-width readonly itemkode" readonly value="'+ response.dataseq[i].rodt_barang +'">',
              '<input type="text" id="item_name[]"      class="form-control input-sm min-width readonly" value="'+ response.dataseq[i].i_name +'">',
              '<input type="text" id="item_harga[]" onkeyup="item_satuan(this)" name="ro_unit_price_seq[]"    class="form-control input-sm min-width right readonly item_satuan"  value="'+response.dataseq[i].cu_symbol+'. '+ accounting.formatMoney(response.dataseq[i].rodt_unit_price,"",0,'.',',') +'" data-curr="'+response.dataseq[i].cu_symbol+'">',
              '<input type="text" id="item_harga[]"   name="ro_price_seq[]"  readonly  class="form-control input-sm min-width right readonly total_price " value="'+response.dataseq[i].cu_symbol+'. '+ accounting.formatMoney(response.dataseq[i].rodt_price,"",0,'.',',') +'">',
              '<input type="number" id="jumlah[]"   name="ro_qty_seq[]"    class="form-control input-sm min-width right readonly total_qty " value="'+ accounting.formatMoney(response.dataseq[i].rodt_qty,"",0,'.',',') +'">',
              '<input type="text" id="unit_price[]"   name=""    class="form-control input-sm min-width right readonly" readonly  value="'+ qtygudang +'">',
              '<center><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></center>'
          ] ).draw( false );
          }
          var total_qty = 0;
          $('.total_qty').each(function(){
            var total = $(this).val();
            total = total.replace(/[^0-9\-]+/g,"");
            total_qty += parseInt(total);
          });
          $("input[name='ro_qty_header']").val(total_qty);
        }
      });
    }

    var tables           = $("#t72as").DataTable();
    var rp_qtys         = $("#rp_qtys");
    var rp_items          = $("#rp_items");
    var rp_kodeitems       = $("#rp_kodeitems");

    var x = 1;

    $('#rp_qtys').attr('disabled',true);
    $('#rp_kodeitems').change(function(){
      var this_val = $(this).find(':selected').data('price');
          if($(this).val() != '') {
            $('#rp_qtys').attr('disabled',false);
          }else{
            $('#rp_qtys').attr('disabled',true);
          }
      var price = $('#rp_items').val(accounting.formatMoney(this_val,"",0,'.',','));
    });


    rp_qtys.keypress(function(e) {
      alert('alpha');
      if(e.which == 13 || e.keyCode == 13){
        var qty = rp_qtys.val();
        var harga_1 = rp_items.val();
        var currency = rp_items.find(':selected').data('currency');

        qty = qty.replace(/[^0-9\-]+/g,"");
        harga_1 = harga_1.replace(/[^0-9\-]+/g,"");

        var itemname = [];
        var selectedVal;
        $(".itemkode").each(function(i, sel){
            selectedVal = $(sel).val();
            itemname.push(selectedVal);
        });

        var tmp = "no";
        for (var i = 0; i < itemname.length; i++) {
          if (itemname[i] == rp_kodeitems.val()) {
            tmp = "yes";
          }
        }

        if (tmp == "yes") {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Sudah ada item yang sama!',
          });
        } else {
          var total = parseInt(harga_1)*parseInt(qty);
          tables.row.add( [
              '<input type="text" id="item_kode[]"   name="ro_item_seq[]"    class="form-control input-sm min-width readonly itemkode" readonly value="'+ rp_kodeitems.val() +'">',
              '<input type="text" id="item_name[]"      class="form-control input-sm min-width readonly" value="'+ rp_kodeitems.find(':selected').data('name') +'">',
              '<input type="text" id="item_harga[]" onkeyup="item_satuan(this)" name="ro_unit_price_seq[]"    class="form-control input-sm min-width right readonly item_satuan rp"  value="'+response.dataseq[i].cu_symbol+'. '+ accounting.formatMoney(rp_kodeitems.find(':selected').data('price'),"",0,'.',',') +'" data-curr="'+response.dataseq[i].cu_symbol+'">',
              '<input type="text" id="item_harga[]"   name="ro_price_seq[]"  readonly  class="form-control input-sm min-width right readonly total_price " value="'+response.dataseq[i].cu_symbol+'. '+ accounting.formatMoney(total,"",0,'.',',') +'">',
              '<input type="number" id="jumlah[]"   name="ro_qty_seq[]"    class="form-control input-sm min-width right readonly total_qty " value="'+ accounting.formatMoney(rp_qtys.val(),"",0,'.',',') +'">',
              '<input type="text" id="unit_price[]"   name=""    class="form-control input-sm min-width right readonly" readonly  value="'+ rp_kodeitems.find(':selected').data('qty') +'">',
              '<center><button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></center>'
          ] ).draw( false );

          x++;
        }


        $('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

        var total_price = totaledit;
        $('.total_price').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_price += parseInt(total);
        });
        $("input[name='ro_total_header']").val('Rp. ' + accounting.formatMoney(total_price,"",0,'.',','));

        var total_qty = 0;
        $('.total_qty').each(function(){
          var total = $(this).val();
          total = total.replace(/[^0-9\-]+/g,"");
          total_qty += parseInt(total);
        });
        $("input[name='ro_qty_header']").val(total_qty);

        rp_items.focus();
        rp_items.val('');
        rp_kodeitems.val('').trigger('change');
        rp_qtys.val('');
      }
    } );

    $('#t72a').on( 'click', function () {
    });

    $('#t72as tbody').on( 'click', '.delete', function () {
        tables
            .row($(this).parents('tr'))
            .remove()
            .draw();

        var parents = $(this).parents('tr');
        var total_price_seq = $(parents).find('.total_price').val();
        var total_qty_seq = $(parents).find('.total_qty').val();
        var total_price_header = $("input[name='ro_total_header']").val();
        var total_qty_header = $("input[name='ro_qty_header']").val();

        total_price_header = total_price_header.replace(/[^0-9\-]+/g,"");
        total_qty_header = total_qty_header.replace(/[^0-9\-]+/g,"");
        total_price_seq = total_price_seq.replace(/[^0-9\-]+/g,"");
        total_qty_seq = total_qty_seq.replace(/[^0-9\-]+/g,"");

        var kurang_total = parseInt(total_price_header)-parseInt(total_price_seq);
        var kurang_qty = parseInt(total_qty_header)-parseInt(total_qty_seq);
        $("input[name='ro_total_header']").val(accounting.formatMoney(kurang_total,"",0,'.',','));
        $("input[name='ro_qty_header']").val(accounting.formatMoney(kurang_qty,"",0,'.',','));

    });

  function simpan(){
    $.ajax({
         type: "get",
         url: '{{ route('simpan_rencanapembelian') }}',
         data: $('#form-save').serialize(),
         success: function(data){
            var table_history = $('#table_datatable_histori').DataTable();
            var table_rencana = $('#table_datatable_rencana').DataTable();
            table_history.ajax.reload();
            table_rencana.ajax.reload();
            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
            });
            $('#tambah').modal('hide');
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

  function update(){
    $.ajax({
         type: "get",
         url: '{{ route('update_rencanapembelian') }}',
         data: $('#form-edit').serialize(),
         success: function(data){
            var table_history = $('#table_datatable_histori').DataTable();
            var table_rencana = $('#table_datatable_rencana').DataTable();
            table_history.ajax.reload();
            table_rencana.ajax.reload();
            iziToast.success({
              icon: 'fas fa-check-circle',
              message: 'Data Telah Tersimpan!',
            });
            $('#edit').modal('hide');
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

  $("#tambah").on("hidden.bs.modal", function(){
      close();
  });

  $("#edit").on("hidden.bs.modal", function(){
      close();
  });


  </script>
@endsection
