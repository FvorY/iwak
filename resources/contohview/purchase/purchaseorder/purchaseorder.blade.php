@extends('main')
@section('content')

@include('purchase.purchaseorder.tambah')

@include('purchase.purchaseorder.detail_purchaseorder')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Purchase</li>
          <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
        </ol>
      </nav>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Purchase Order</h4>

                    <div class="row">
                      @if (App\mMember::akses('PURCHASE ORDER', 'tambah'))
                      <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cari" id="cari"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      </div>
                      @endif
                    </div>

                    <div class="row">
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="alert alert-primary alert-dismissible" title="Approved">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Notice!</strong> <br>
                            <label class="badge badge-pill badge-primary">{{$printed}}</label>
                            Printed
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="alert alert-warning alert-dismissible" title="Need Approved">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Notice!</strong> <br>
                            <label class="badge badge-pill badge-warning">{{$process}}</label>
                            Process
                        </div>
                      </div>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-hover" id="datatable" cellspacing="0">
                        <thead class="bg-gradient-info">
                          <tr>
                            <th>P.O.#</th>
                            <th>Vendor</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                         {{--  <tr>
                            <td>1</td>
                            <td>PO-001</td>
                            <td>Zulu</td>
                            <td>
                              <button data-toggle="modal" data-target="#detail_item" class="btn btn-outline-primary btn-sm">Detail</button>
                            </td>
                            <td>Rp. 600.000,00</td>
                            <td><span class="badge badge-warning badge-pill">In Process</span></td>
                            <td>
                              <div class="btn-group">
                                <a href="{{url('purchase/purchaseorder/print_purchaseorder')}}" class="btn btn-info btn-sm" target="_blank" title="Print"><i class="fa fa-print"></i></a>
                                <a href="{{url('purchase/purchaseorder/edit_purchaseorder')}}" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-pencil-alt"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
                              </div>
                            </td>
                          </tr> --}}
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

  $('#datatable').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url:'{{ route('datatable_purchaseorder') }}',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'd_id center'
                  },
                  {
                     targets: 2 ,
                     className: 'center'
                  },
                  {
                     targets: 3 ,
                     className: 'right'
                  },
                  {
                     targets: 4 ,
                     className: 'center'
                  },
                  {
                     targets: 5 ,
                     className: 'center'
                  },
                ],
            "columns": [
            { "data": "po_code" },
            { "data": "s_company" },
            { "data": "detail" },
            { "data": "po_total_net" ,render: $.fn.dataTable.render.number( '.', '.', 0, '' )},
            { "data": "status" },
            { "data": "aksi" },
            ]
      });

      $('#tablecari').dataTable();


  $('#cari_vendor').change(function(){
      var this_val = $(this).val();

        $.ajax({
           type: "get",
           url: '{{ route('cari_ro_purchaseorder') }}',
           data: $('#form_cari').serialize(),
           success: function(data){
           var array_ro='';
            if (data.length == 0) {
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Data Not Found!',
                });

                  array_ro = '<option>- Pilih -</option>';
                  $('#cari_ro').html(array_ro);
            }else{
                  $.each(data, function(i, item) {
                        array_ro += '<option>'+data[i].ro_code+'</option>';
                  })
                  $('#cari_ro').html(array_ro);
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

  function detail(parm) {
    var par   = $(parm).parents('tr');
    var id    = $(par).find('.d_id').text();
    $('#detail_item').modal('show');
    $.ajax({
       type: "get",
         url: '{{ route('detail_purchaseorder') }}',
         data: {id},
         success: function(data){
          var array_nama='';
          $.each(data, function(i, item) {
              array_nama += '<tr>';
                array_nama += '<td>'+data[i].i_code+' - '+data[i].i_name+'</td>';
                array_nama += '<td align="right">'+data[i].podt_qty_approved+'</td>';
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

  $('#create_po').click(function(){

      var favorite = [];
        $(".check:checked").each(function(){
            favorite.push($(this).val());
        });

        $.ajax({
          type: 'get',
          data: {favorite:favorite},
          dataType: 'json',
          url: baseUrl + '/purchase/purchaseorder/validation',
          success : function(result){
            if (result.status == 'tidak') {
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Vendor tidak boleh beda!',
              });
            } else {
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
                           url: '{{ route('cari_po_purchaseorder') }}',
                           data: $('#form_cari').serialize(),
                           success: function(data){
                              window.location.href = this.url;
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
          }
        });
  });


   function hapus(a) {
    var par   = $(a).parents('tr');
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
                '<button style="background-color:#44d7c9;">Process</button>',
                function (instance, toast) {


                //ajax
                 $.ajax({
                   type: "get",
                   url: '{{ route('hapus_purchaseorder') }}',
                   data: {id},
                   success: function(data){
                      var table = $('#dataTable').DataTable();
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

   function print(parm) {
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
                '<button style="background-color:#44d7c9;">Process</button>',
                function (instance, toast) {
                //ajax
                window.open('{{ route('print_purchaseorder') }}?id='+id);

                window.location.reload();
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

   function valid(total, num){
     if (total != num) {
       return false;
     } else if (total == num) {
       return true;
     }
   }

   function edit(parm){
     var par   = $(parm).parents('tr');
     var id    = $(par).find('.d_id').text();

     window.location.href = baseUrl + '/purchase/purchaseorder/edit_purchaseorder?id='+id;
   }


  // cari_vendor
</script>
@endsection
