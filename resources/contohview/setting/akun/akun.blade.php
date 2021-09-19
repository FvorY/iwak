@extends('main')
@section('content')

@include('setting.akun.tambah')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Setting</li>
          <li class="breadcrumb-item active" aria-current="page">Setting Account</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Setting Account</h4>
                    @if (App\mMember::akses('SETTING ACCOUNT', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info btn_modal" data-toggle="modal" data-target="#tambah-akun"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
        				        <table id="table_data" class="table table-striped table-hover" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Pegawai</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Photo</th>
                                <th>Last Login</th>
                                <th>Aksi</th>
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
<script>

  $(document).ready(function(){

     $('#table_data').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_akun') }}',
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
                  {
                     targets: 6 ,
                     className: 'center'
                  },
                  {
                     targets: 4 ,
                     className: 'center'
                  },


                ],
          columns: [
            {data: 'm_id', name: 'm_id'},
            {data: 'm_username', name: 'm_username'},
            {data: 'mp_name', name: 'mp_name'},
            {data: 'm_name', name: 'm_name'},
            {data: 'm_jabatan', name: 'm_jabatan'},
            {data: 'image', name: 'image'},
            {data: 'm_last_login', name: 'm_last_login'},
            {data: 'aksi', name: 'aksi'}
          ]

    });
  })

  $('.btn_modal').click(function(){
    $('.nama').focus();
    $('.tabel_modal :input:not(input[name="_token"])').val('');
    $('.tabel_modal label').prop('hidden',true);

    $('#noFile').text('Choose Image...');
    $(".file-upload").removeClass('active');
    $('.preview_td').html('<img style="width: 100px;height: 100px;border:1px solid pink" id="output" >');
  })

$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  var fsize = $('#chooseFile')[0].files[0].size;
  if(fsize>1048576) //do something if file size more than 1 mb (1048576)
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




$('.simpan').click(function(){

  var input =  $('.tabel_modal :input').length;

  var validator = [];
  var validator_name = [];
  console.log($('.tabel_modal :input'));

  for(var i = 0 ; i<input;i++){
    if ($('.tabel_modal :input').eq(i).val() == '' || $('.tabel_modal :input').eq(i).val()  == 0) {
      if (i == 6 || i == 2) {
        validator.push(1);
      }else{
        validator.push(0);
        $('.valid_'+i).prop('hidden',false);
        if (i == 1) {
          $('.valid_u').prop('hidden',true);
        }
      }
    }else{
      if (i == 1) {
        var table = $('#table_data').DataTable();
        $('.user_id').each(function(){
          validator_name.push($(this).text())
        })

        if ($('.id').val() != '') {

          var cari = validator_name.indexOf($('.old_name').val());

          if (cari != -1) {
            validator_name.splice(1,cari);
          }
        }
        console.log(validator_name);

        var nama = validator_name.indexOf($('.tabel_modal :input').eq(1).val())
        if (nama != -1) {
          validator.push(0);
          $('.valid_'+i).prop('hidden',true);
          $('.valid_u').prop('hidden',false);

        }else{
          validator.push(1);
          $('.valid_'+i).prop('hidden',true);
          $('.valid_u').prop('hidden',true);
        }
      }else{
        validator.push(1);
        $('.valid_'+i).prop('hidden',true);
      }
    }
  }
  console.log(validator);

  var index = validator.indexOf(0);
  if (index != -1) {
    iziToast.warning({
      icon: 'fa fa-times',
      message: 'Periksa Kembali Data Anda!',
    });
    return false;
  }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


      var formdata = new FormData();
       formdata.append( 'files', $('#chooseFile')[0].files[0]);
       $.ajax({
         type: "POST",
         url: baseUrl +'/setting/simpan_akun?'+$('.tabel_modal :input').serialize(),
         data: formdata,
         dataType:'json',
         processData: false,
         contentType: false,
         success: function(data){
            if (data.status == 0) {
              iziToast.warning({
                  icon: 'fa fa-times',
                  title: 'Nama',
                  message: 'Sudah Digunakan!',
              });
            }else if(data.status == 1){
              iziToast.success({
                  icon: 'fa fa-save',
                  title: 'Berhasil',
                  message: 'Menambah Data!',
              });
            }else{
              iziToast.success({
                  icon: 'fa fa-pencil-alt',
                  title: 'Berhasil',
                  message: 'Mengupdate Data!',
              });
            }
            $('#tambah-akun').modal('hide');
            var table = $('#table_data').DataTable();
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
    return false;
  });

  function edit(a) {
    $('.tabel_modal :input:not(input[name="_token"])').val('');
    $('.tabel_modal label').prop('hidden',true);
    var par   = $(a).parents('tr');
    var id    = $(par).find('.d_id').text();
    $.ajax({
        url:baseUrl +'/setting/edit_akun',
        type:'get',
        data:{id},
        dataType:'json',
        success:function(res){
          $('.id').val(id);
          $('.username').val(res.data.m_username);
          $('.nama').val(res.data.m_name);
          $('.level').val(res.data.kode_jabatan);
          $('.level').trigger('change.select2');
          $('.pegawai').val(res.data.m_pegawai_id);
          $('.pegawai').trigger('change.select2');
          $('#output').attr("src", '{{ route('thumbnail') }}'+'/'+res.data.m_image)
          $('.file-upload').addClass('active');
          $("#noFile").text(res.data.m_image);
          $('.id').val(id);
          $('.old_name').val(res.data.m_username);
          $('#tambah-akun').modal('show');
        },
        error:function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
    });




  }


  function hapus(a) {
    var par   = $(a).parents('tr');
    var id    = $(par).find('.d_id').text();
    $.ajax({
        url:baseUrl +'/setting/hapus_akun',
        type:'get',
        data:{id},
        dataType:'json',
        success:function(data){
          $('#tambah-jabatan').modal('hide');
          var table = $('#table_data').DataTable();
          table.ajax.reload();
          if (data.status == 1) {
            iziToast.success({
                  icon: 'fa fa-trash',
                  title: 'Berhasil',
                  color:'yellow',
                  message: 'Menghapus Data!',
            });
          }else{
            iziToast.warning({
                  icon: 'fa fa-times',
                  title: 'Oops,',
                  message: ' Superuser Tidak Boleh Dihapus!',
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
</script>
@endsection
