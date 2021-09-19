@extends('main')

@section('extra_style')
<style type="text/css">

  .float-left{
    float:left;
  }
  .float-right{
    float:right;
  }

</style>
@endsection

@section('content')

@include('master.currency.tambah')


<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Currency</li>
  			</ol>
  		</nav>
  	</div>

  	<div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
            <h4 class="card-title">Master Currency</h4>
            @if (App\mMember::akses('MASTER CURRENCY', 'tambah'))
              <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                	<button type="button" class="btn btn-info" id="tombol_modal_tambah" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
              </div>
            @endif
            <div class="table-responsive">
              <table id="t55" class="table table-hover table-bordered" cellspacing="0">
                <thead class="bg-gradient-info">
                    <tr>
                      <th class="wd-15p" width="5%">No</th>
                      <th class="wd-15p">Code</th>
                      <th>Symbol</th>
                      <th>Currency Name</th>
                      <th class="wd-15p">Value</th>
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
<script>

$(".value").maskMoney({
      precision:0,
      thousands:'.',
      allowZero:true,
      defaultZero:true,
  });

$(document).ready(function(){
  $('#t55').DataTable({
    processing: true,
    serverSide: true,
    dom: 'Bfrtip',
    title: '',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    ajax: {
        url:'{{ route('datatable_currency') }}',
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
             targets: 5 ,
             className: 'center '
          },
          {
             targets: 4 ,
             className: 'right format_money'
          },
        ],
    "columns": [
    {data: 'DT_Row_Index', name: 'DT_Row_Index'},
    {data: 'cu_code', name: 'cu_code'},
    {data: 'cu_symbol', name: 'cu_symbol'},
    {data: 'cu_name', name: 'cu_name'},
    {data: 'total', name: 'total'},
    {data: 'aksi', name: 'aksi'},
    ]
  });
})



$('#tombol_modal_tambah').click(function(){
  $('input').val('');
  $('.currency').val('0');
  $('.currency').select2();
})

$('.currency').change(function(){
  var id = $(this).val();
  $.ajax({
    url: '{{ url('master/currency/auto_complete') }}',
    data: {id},
    type:'get',
    dataType:'json',
    success:function(data){
      try{
        $('.symbol').val(data.data.cu_symbol);
        $('.country').val(data.data.cu_name);
      }catch(err){

      }
    },
    error:function(){
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'Terjadi Kesalahan!',
      });
    }
  })
})

function edit(id) {
  $.ajax({
    url: '{{ url('master/currency/edit_detail') }}',
    data: {id},
    type:'get',
    dataType:'json',
    success:function(data){
      $('.currency').val(id);
      $('.currency').select2();
      $('.currency').change();
      $('.value').val(accounting.formatMoney(data.data.cu_value, "", 0, ".",','));
      $('#tambah').modal('show');

    },
    error:function(){
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'Terjadi Kesalahan!',
      });
    }
  })

}

$('.simpan').click(function(){
  var id = $('.currency').val();
  var value = $('.value').val();
  $.ajax({
    url: '{{ url('master/currency/save') }}',
    data: {id,value},
    type:'get',
    dataType:'json',
    success:function(data){
      if (data.status == 1) {
        iziToast.success({
          icon: 'fa fa-check',
          message: 'Data Berhasil Disimpan!',
        });
        var table = $('#t55').DataTable();
        table.ajax.reload();
      }
    },
    error:function(){
      iziToast.warning({
        icon: 'fa fa-times',
        message: 'Terjadi Kesalahan!',
      });
    }
  })
})

</script>
@endsection
