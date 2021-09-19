@extends('main')
@section('content')

@include('setting.jabatan.tambah')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Setting</li>
          <li class="breadcrumb-item active" aria-current="page">Setting Level Account</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Setting Level Account</h4>
                    @if (App\mMember::akses('SETTING LEVEL ACCOUNT', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info btn_modal" data-toggle="modal" data-target="#tambah-jabatan"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
        				        <table id="table_data" class="table table-striped table-hover" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th style="width: 10%">No</th>
                                <th style="width: 40%">Nama Level</th>
                                <th style="width: 40%">Keterangan</th>
                                <th style="width: 10%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($data as $key => $value)
                                <tr>
                                  <td class="d_id">{{$value->j_id}}</td>
                                  <td class="d_nama">{{$value->j_nama}}</td>
                                  <td class="d_keterangan">{{$value->j_keterangan}}</td>
                                  <td>
                                    @if ($value->j_nama == 'MANAGER' || $value->j_nama == 'FINANCE')
                                      <span class="badge badge-danger">Disabled</span>
                                    @else
                                      <div class="btn-group">'.
                                        @if (App\mMember::akses('SETTING LEVEL ACCOUNT', 'ubah'))
                                             <button type="button" onclick="edit(this)" class="btn btn-info btn-xs" title="edit">
                                             <label class="fa fa-pencil"></label></button>
                                        @endif
                                        @if (App\mMember::akses('SETTING LEVEL ACCOUNT', 'hapus'))
                                             <button type="button" onclick="hapus(this)" class="btn btn-danger btn-xs" title="hapus">
                                             <label class="fa fa-trash"></label></button>
                                        @endif
                                      </div>
                                    @endif
                                    </td>
                                </tr>
                              @endforeach
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

  });

  $('.btn_modal').click(function(){
    $('.nama').focus();
  })

  $('.simpan').click(function(){
    $.ajax({
        url:baseUrl +'/setting/simpan_jabatan',
        type:'get',
        data:$('.tabel_modal :input').serialize(),
        dataType:'json',
        success:function(data){
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
            $('#tambah-jabatan').modal('hide');
            window.location.reload();
            $('.tabel_modal input').val('');
        },
        error:function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
    });
  });

  function edit(a) {

    var par   = $(a).parents('tr');
    var id    = $(par).find('.d_id').text();
    var nama  = $(par).find('.d_nama').text();
    var ket   = $(par).find('.d_keterangan').text();

    $('.id').val(id);
    $('.nama').val(nama);
    $('.keterangan').val(ket);
    $('#tambah-jabatan').modal('show');


  }


  function hapus(a) {
    var par   = $(a).parents('tr');
    var id    = $(par).find('.d_id').text();
    $.ajax({
        url:baseUrl +'/setting/hapus_jabatan',
        type:'get',
        data:{id},
        dataType:'json',
        success:function(data){
          $('#tambah-jabatan').modal('hide');
          if (data.status == 1) {
            iziToast.success({
                  icon: 'fa fa-trash',
                  title: 'Berhasil',
                  color:'yellow',
                  message: 'Menghapus Data!',
            });
            window.location.reload();
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
