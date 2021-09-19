@extends('main')
@section('content')

@include('master.customer.tambah')

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
                    @if (App\mMember::akses('MASTER DATA CUSTOMER', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info" data-toggle="modal" id="button_add" data-target="#tambah-customer"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
        				        <table class="table table-hover " id="table-cust" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Customer Name</th>
                                <th>Birth Date</th>
                                <th>Customer Type</th>
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



    $('#table-cust').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url:'{{ route('datatalble_customer') }}',
            },
             columnDefs: [

                  {
                     targets: 1 ,
                     className: 'center d_id'
                  },
                ],
            "columns": [
            { "data": "c_birthday" },
            { "data": "c_code" },
            { "data": "c_name" },
            { "data": "c_type" },
            { "data": "c_information" },
            { "data": "aksi" },
            ]
      });

  $('#button_add').click(function(){
    var c_name      = $("input[name='c_name']").val('');
    var c_tlp       = $("input[name='c_phone']").val('');
    var c_email     = $("input[name='c_email']").val('');
    var c_alamat    = $("textarea#c_address").val('');
    var c_tipe      = $("select[name='c_type']").val('').trigger('change');
    var c_hometown  = $("select[name='c_hometown']").val('').trigger('change');
    var c_informasi = $("textarea#c_information").val('');
    var c_npwp      = $("input[name='c_npwp']").val('');
    var c_creditterms     = $("input[name='c_creditterms']").val('');
    var c_bankname        = $("input[name='c_bankname']").val('');
    var c_accountnumber   = $("input[name='c_accountnumber']").val('');
    var c_plafon    = $("input[name='c_plafon']").val('');
    var c_id        = $("input[name='c_id']").val('');
    var c_birthday  = $("input[name='c_birthday']").val('');
    var kode_old  = $("input[name='kode_old']").val('');
    $('#change_function').html('<button class="btn btn-primary" type="button" id="save_data" >Save Data</button>')
  })

  $('#change_function').on("click", "#save_data",function(){
    $.ajax({
         type: "get",
         url: baseUrl + '/master/simpancustomer/simpan_customer',
         data: $('#form_save').serialize(),
         success: function(data){
            $('#tambah-customer').modal('hide');
            var table = $('#table-cust').DataTable();
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
           url: baseUrl + '/master/updatecustomer/update_customer',
           data: $('#form_save').serialize(),
           success: function(data){
              $('#tambah-customer').modal('hide');
              var table = $('#table-cust').DataTable();
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
    $('#tambah-customer').modal('show');
    $.ajax({
       type: "get",
         url: baseUrl + '/master/dataeditcustomer/dataedit_customer',
         data: {id},
         success: function(data){
          // console.log(data);
            var c_name      = $("input[name='c_name']").val(data[0].c_name);
            var c_tlp       = $("input[name='c_phone']").val(data[0].c_phone);
            var c_email     = $("input[name='c_email']").val(data[0].c_email);
            var c_company_name     = $("input[name='c_company_name']").val(data[0].c_company_name);
            var c_phone_1     = $("input[name='c_phone_1']").val(data[0].c_phone_1);
            var c_alamat    = $("textarea#c_address").val(data[0].c_address);
            var c_tipe      = $("select[name='c_type']").val(data[0].c_type).trigger('change');
            var c_hometown  = $("select[name='c_hometown']").val(data[0].c_hometown).trigger('change');
            var c_informasi = $("textarea#c_information").val(data[0].c_information);
            var c_npwp      = $("input[name='c_npwp']").val(data[0].c_npwp);
            var c_creditterms     = $("input[name='c_creditterms']").val(data[0].c_creditterms);
            var c_bankname        = $("input[name='c_bankname']").val(data[0].c_bankname);
            var c_accountnumber   = $("input[name='c_accountnumber']").val(data[0].c_accountnumber);
            var c_plafon    = $("input[name='c_plafon']").val(data[0].c_plafon);
            var c_id        = $("input[name='c_id']").val(data[0].c_code);
            var c_birthday  = $("input[name='c_birthday']").val(data[0].c_birthday);
            var kode_old  = $("input[name='kode_old']").val(data[0].c_code);

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
                     url: baseUrl + '/master/hapuscustomer/hapus_customer',
                     data: {id},
                     success: function(data){
                      console.log(data);
                      var table = $('#table-cust').DataTable();
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
