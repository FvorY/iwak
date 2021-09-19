@extends('main')
@section('content')


<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
          <li class="breadcrumb-item">After Order</li>
          <li class="breadcrumb-item"><a href="{{route('perdin')}}">LPJ Perdin</a></li>
          <li class="breadcrumb-item active" aria-current="page">Detail LPJ Perdin</li>
        </ol>
      </nav>
    </div>

  	<div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Detail LPJ Perdin</h4>

          <form id="data">
            <input type="hidden" name="idperdin" value="{{$perdin->p_id}}">
            <div class="row">

              <div class="col-md-3 col-sm-4 col-12">
                <label>Perdin Code</label>
              </div>
              <div class="col-md-9 col-sm-8 col-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" readonly="" value="{{$perdin->p_code}}" name="perdincode">
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-12">
                <label>Perdin Date</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" readonly="" value="{{$perdin->p_pengajuan}}" name="perdindate">
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-12">
                <label>Customer</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" readonly="" value="{{$perdin->c_code}} - {{$perdin->c_name}}" name="customer">
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-12">
                <label>Project</label>
              </div>

              <div class="col-md-9 col-sm-8 col-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" readonly="" name="project" value="{{$perdin->p_proyek}}">
                </div>
              </div>

            </div>

            <hr>
            <input type="hidden" name="lp_code" value="{{$lpj[0]->lp_code}}">
            <input type="hidden" name="lp_perdin" value="{{$lpj[0]->lp_perdin}}">

            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="table_perdin">
                <thead class="bg-gradient-info">
                  <tr>
                    <th rowspan="2" valign="middle">Tanggal</th>
                    <th rowspan="2" valign="middle">Keterangan</th>
                    <th rowspan="2" valign="middle">Estimasi Budget</th>
                    <th colspan="2">Real Budget</th>
                    <th rowspan="2" valign="middle">Total Price</th>
                    <th rowspan="2" valign="middle">Sisa Perdin</th>
                  </tr>
                  <tr>
                    <th width="1%">Pax/Days/Unit</th>
                    <th width="15%">Price</th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($lpj as $key => $value)
                    <tr>
                    <td><input type="hidden" name="lp_id[]" value="{{$value->lp_id}}"><input readonly="" class="form-control form-control-sm datepicker" value="{{Carbon\Carbon::parse($value->lp_tanggal)->format('d-m-Y')}}" type="text" name="tanggal[]"></td>
                    <td><input class="form-control form-control-sm" readonly="" type="text" value="{{$value->lp_keterangan}}" name="keterangan[]"></td>
                    <td><input class="form-control form-control-sm" readonly="" type="number" value="{{$value->lp_unit}}" min="0" name="unit[]"></td>
                    <td><input class="form-control form-control-sm mask text-right format_money" type="text" value="{{number_format($value->lp_price,0,',','.')}}" name="price[]"></td>
                    <td><input class="form-control form-control-sm mask text-right format_money" readonly="" type="text" value="{{number_format($value->lp_estimasi_budget,0,',','.')}}" name="estimasibudget[]"></td>
                    <td><input class="form-control form-control-sm mask text-right format_money" readonly="" type="text" value="{{number_format($value->lp_total_price,0,',','.')}}" name="totalprice[]"></td>
                    <td><input class="form-control form-control-sm mask text-right format_money" readonly="" type="text" value="{{number_format($value->lp_sisa_perdin,0,',','.')}}" name="sisaperdin[]"></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </form>
        </div>
        <div class="card-footer text-right">
          <a href="{{route('perdin')}}" class="btn btn-secondary">Back</a>
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

    $('.datepicker').datepicker({
        format:'dd-mm-yyyy'
      });

    var table = $('#table_perdin').DataTable({
      "columnDefs": [
        {
          "targets": 7
          ,
           "align": "center"
        }
      ]
    });
    var counter_strike__battlefield = 0;

    $('#button-tambahmantan').click(function(){
      table.row.add([
        '<input type="hidden" name="lp_id[]" value=""><input class="form-control form-control-sm datepicker" value="{{date('d-m-Y')}}" type="text" name="tanggal[]">',
        '<input class="form-control form-control-sm" type="text" name="keterangan[]">',
        '<input class="form-control form-control-sm" type="number" min="0" name="unit[]">',
        '<input class="form-control form-control-sm mask text-right format_money" type="text" name="price[]">',
        '<input class="form-control form-control-sm mask text-right format_money" type="text" name="realbudget[]">',
        '<input class="form-control form-control-sm mask text-right format_money" type="text" name="totalprice[]">',
        '<input class="form-control form-control-sm mask text-right format_money" type="text" name="sisaperdin[]">',
        '<center><button class="btn btn-danger btn-sm btn-hapusmantan" type="button"><i class="fa fa-trash-o"></i></button></center>'
        ]).draw(false);

      counter_strike__battlefield++;
      $('.mask').maskMoney({thousands:'.', decimal:',', precision:0});

     $('.datepicker').datepicker({
        format:'dd-mm-yyyy'
      });

    });

    $('#table_perdin tbody').on('click', '.btn-hapusmantan', function(){
      table.row($(this).parents('tr')).remove().draw();
    });

  });

   $('#btn-submit').on('click', function(){
     $.ajax({
       type: 'get',
       data: $('#data').serialize(),
       dataType: 'JSON',
       url: baseUrl + '/project/perdin/update_lpj',
       success : function (response){
         if (response.status == 'berhasil') {
 					iziToast.success({
 							icon: 'fa fa-check',
 							message: 'Berhasil disimpan!',
 					});

 					window.location.href = baseUrl + '/project/perdin/perdin';
 				}else{
 					iziToast.warning({
 							icon: 'fa fa-info',
 							message: 'Gagal disimpan!',
 					});
 				}
       }
     })
   });

</script>
@endsection
