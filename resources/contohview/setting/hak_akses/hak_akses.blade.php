@extends('main')
@section('content')

<link rel="stylesheet" href="{{asset('assets/node_modules/checkbox/css/style.css')}}">

<!-- partial -->
<div class="content-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active" aria-current="page">Setting Hak Akses</li>
        </ol>
      </nav>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="col-md-12 col-xs-12 col-xs-12">
            <table class="table">
             <tr>
              <td width="50">Level</td>
               <td>
                  <select name="level" class="level form-control" >
                    <option value="0">Pilih - Level</option>
                    @foreach($hak_akses as $i)
                    <option value="{{ $i->ha_level }}">{{ $i->ha_level }}</option>
                    @endforeach
                  </select>
               </td>
             </tr>
            </table>
            <div class="content_hak_akses">

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
<script>
@if (App\mMember::akses('SETTING HAK AKSES', 'tambah'))
  $('.level').change(function(){
    var level = $(this).val();

    $.ajax({
      type: 'get',
      url: baseUrl + '/setting/hak_akses/table_data',
      data: {level},
      success:function(data){        
        $('.content_hak_akses').html(data);
      }
    });

  })
@endif



</script>
@endsection
