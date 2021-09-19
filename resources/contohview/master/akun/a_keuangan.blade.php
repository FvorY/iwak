@extends('main')
@section('content')

@include('master/akun/tambah_akun_keuangan')
@include('master/akun/edit_akun_keuangan')
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12"> 
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active" aria-current="page">Data Akun Keuangan</li>
        </ol>
      </nav>
    </div>

    <div class="col-lg-12 alamraya-row-nav">
      <ul class="nav nav-tabs tab-solid tab-solid-primary alamraya-navtab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab-6-1" data-toggle="tab" href="#absakeuangan" role="tab" aria-controls="absakeuangan" aria-selected="true"><i class="mdi mdi-file-document"></i>Master Data Akun Keuangan</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" id="tab-6-1" data-toggle="tab" href="#hh" role="tab" aria-controls="hh" aria-selected="true"><i class="mdi mdi-file-document"></i>Master Data Akun Keuangan</a>
        </li>
      </ul>

      <div class="tab-content tab-content-solid col-lg-12 ">

        <div class="tab-pane fade show active" id="absakeuangan" role="tabpanel" aria-labelledby="absakeuangan">
          <div class="col-lg-12 grid-margin stretch-card alamraya-no-padding">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Master Data Akun Keuangan General</h4>
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-info alamraya-btn-add pull-right add" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                </div>

                <div class="row">

                  <div class="table-responsive">
                    <table class="table table-hover data-table" cellspacing="0">
                      <thead class="bg-gradient-info">
                        <tr>
                        <th>Nomor Akun</th>
                        <th>Nama Akun</th>
                        <th>Kelompok Akun</th>
                        <th>Debet/Kredit</th>
                        <th>Neraca</th>
                        <th>Laba Rugi</th>
                        <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="center">
                        @foreach ($general as $element)
                        <tr>
                          <td class="iddd">{{ $element->id_akun }}</td>
                          <td>{{ $element->nama_akun }}</td>
                          <td>{{ $element->kelompok_akun }}</td>
                          <td>
                          @if ($element->posisi_akun == 'D')
                            DEBET
                          @else 
                            KREDIT
                          @endif 
                          </td>
                          <td>{{ $element->group_neraca }}</td>
                          <td>{{ $element->group_laba_rugi }}</td>
                          <td>
                            <center>
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-lg alamraya-btn-aksi" title="edit" onclick="edit(this)">
                                  <label class="fa fa-pencil-alt"></label>
                                </button>
                                <button type="button" class="btn btn-danger btn-lg alamraya-btn-aksi" title="hapus" onclick="hapus(this)">
                                  <label class="fa fa-trash"></label>
                                </button>
                              </div>
                            </center>
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




         <div class="tab-pane fade show" id="hh" role="tabpanel" aria-labelledby="hh">
          <div class="col-lg-12 grid-margin stretch-card alamraya-no-padding">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Master Data Akun Keuangan</h4>
              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-info alamraya-btn-add pull-right" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                </div>

                <div class="row">

                  <div class="table-responsive">
                    <table class="table table-hover data-table" cellspacing="0">
                      <thead class="bg-gradient-info">
                        <tr>
                        <th>Nomor Akun</th>
                        <th>Nama Akun</th>
                        <th>Kelompok Akun</th>
                        <th>Debet/Kredit</th>
                        <th>Neraca</th>
                        <th>Laba Rugi</th>
                        <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="center">
                       @foreach ($detail as $element)
                        <tr>
                          <td class="iddd">{{ $element->id_akun }}</td>
                          <td>{{ $element->nama_akun }}</td>
                          <td>{{ $element->kelompok_akun }}</td>
                          <td>
                          @if ($element->posisi_akun == 'D')
                            DEBET
                          @else 
                            KREDIT
                          @endif 
                          </td>
                          <td>{{ $element->group_neraca }}</td>
                          <td>{{ $element->group_laba_rugi }}</td>
                          <td>
                            <center>
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-lg alamraya-btn-aksi" title="edit" onclick="edit(this)">
                                  <label class="fa fa-pencil-alt"></label>
                                </button>
                                <button type="button" class="btn btn-danger btn-lg alamraya-btn-aksi" title="hapus" onclick="hapus(this)">
                                  <label class="fa fa-trash"></label>
                                </button>
                              </div>
                            </center>
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


      </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script type="text/javascript">
  
  function hapus(a) {
        var parent = $(a).parents('tr');
        var id = $(parent).find('.iddd').text();
        var cfrm = confirm('Apakah Anda Yakin, Data yang Dihapus Tidak Bisa Dikembalikan ?');

        if(cfrm){
          $.ajax({
               type: "get",
               url: '{{ route('delete_a_keuangan') }}',
               data: {id},
               success: function(data){
                  if(data.status == 1) {
                    location.reload();
                  }else if(data.status == 2){
                    alert('Akun Yang Dipilih Tidak Bisa Dihapus Karena Digunakan Sebagai Data Jurnal...')
                  }else if(data.status == 2){
                    alert('Ups. Data Akun Yang Dipilih Tidak Bisa Kami Temukan...')
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
      }

       function edit(a) {
        var parent = $(a).parents('tr');
        var id = $(parent).find('.iddd').text();

        window.location.href= baseUrl+'/master/akun/edit_a_keuangan'+'?'+'id='+id;
      
      }

   function save() {
           iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000, 
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Save Data!',
            message: 'Apakah Anda Yakin ?!',
            position: 'center',
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
            [
                '<button style="background-color:#17a991;color:white;">Save</button>',
                function (instance, toast) {

                  $.ajaxSetup({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "get",
                        url:'{{ route('save_a_keuangan') }}',
                        data: $('#save_data').serialize(),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                      success:function(data){
                        if (data.status == 'sukses') {
                            iziToast.success({
                                icon: 'fa fa-save',
                                position:'topRight',
                                title: 'Success!',
                                message: 'Data Berhasil Disimpan!',
                            });
                            location.href = '{{ route('a_keuangan') }}'
                        }else if (data.status == 'exist_id') {
                            iziToast.error({
                                icon: 'fa fa-times',
                                position:'topRight',
                                title: 'Error!',
                                message:'Kode Sudah Terpakai ='+data.content,
                            });
                        }
                      },error:function(){
                        iziToast.warning({
                            icon: 'fa fa-info',
                            position:'topRight',
                            title: 'Error!',
                            message: data.message,
                        });
                      }
                    });
                    instance.hide({
                        transitionOut: 'fadeOutUp'
                    }, toast);
                }
            ],
            [
                '<button style="background-color:#d83939;color:white;">Cancel</button>',
                function (instance, toast) {
                  instance.hide({
                    transitionOut: 'fadeOutUp'
                  }, toast);
                }
              ]
            ]
        });
        }


      var dataGeneral = [
            {value: "1", text: "Aset Lancar"},
            {value: "2", text: "Aset Tidak Lancar"},
            {value: "3", text: "Kewajiban Jangka Pendek"},
            {value: "4", text: "Ekuitas"},
            {value: "5", text: "Pendapatan"},
            {value: "6", text: "Beban Usaha"},
            {value: "7", text: "Pendapatan Lain-Lain"},
            {value: "8", text: "Beban Lain-Lain"}
          ]
      var datakelompok =  {!! $datakelompok !!};
      // console.log(datakelompok);
      // console.log(dataGeneral);

  $('.add').click(function(){
      $('.sembunyikan').css('visibility','hidden');
      $('#kelompok_akun').val('');
      $('#nomor_akun').val('');
      $('#nama_akun').val('');
      $('#nama_kelompok').prop('selectedIndex',0).trigger('change');
      $('#posisi_akun').prop('selectedIndex',0).trigger('change');
      $('#type_akun').prop('selectedIndex',0).trigger('change');
      $('#group_neraca').prop('selectedIndex',0).trigger('change');
      $('#group_laba_rugi').prop('selectedIndex',0).trigger('change');
  })

  

  $('#type_akun').change(function(){

      if ($(this).val() == 'DETAIL') {
          $('.sembunyikan').css('visibility','visible');
          //change value option   
          var html ='';
          $.each(datakelompok, function(i, n){
            html = html +'<option value="'+n.value+'" >'+n.value+' - '+n.text+'</option>';
          });
          $("#nama_kelompok").html(html);
          //change kode akun          
          $('#kelompok_akun').val($('#nama_kelompok').val());
          $('#nama_kelompok').change(function(){
              $('#kelompok_akun').val($(this).val());
          })
      }else{
          //change kode akun
          $('#nama_kelompok').change(function(){
              $('#kelompok_akun').val($(this).val());
          })
          //change value option            
          var html ='';
          $.each(dataGeneral, function(i, n){
            html = html +'<option value="'+n.value+'">'+n.value+' - '+n.text+'</option>';
          });
          $("#nama_kelompok").html(html);
          $('.sembunyikan').css('visibility','hidden');
          $('#kelompok_akun').val($('#nama_kelompok').val());
      }

  })

  





</script>

@endsection