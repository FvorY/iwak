@extends('main')
@section('content')

@include('uangmasuk.tambah')
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="/home">Home</a></li>
          {{-- <li class="breadcrumb-item">Billing Master Setup</li> --}}
          <li class="breadcrumb-item active" aria-current="page">Admission Fee</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <label for="">Choose Year : </label> &nbsp; <input type="text" class="btn btn-primary" id="filteryear" onchange="reloadstatistik()" name="filteryear" value="{{date('Y')}}">
                    {{-- <canvas id="tagihanchart" width="400" height="150"></canvas> --}}
                    <div id="tagihanchart">

                    </div>

                    <br>
                    <h4 for="">Note: For billing statistics, these statistics are based on a list of bills in the period that have not been paid or have been paid</h4>
                  </div>
                </div>
    </div>
  </div>
</div>

{{-- <input type="hidden" name="arraylabeltagihan[]" id="arraylabeltagihan" value="{{json_encode($tagihanlabel,TRUE)}}"> --}}
{{-- <input type="hidden" name="arrayvaluetagihan[]" id="arrayvaluetagihan" value="{{json_encode($tagihanvalue,TRUE)}}">
<input type="hidden" name="arrayvaluemasuk[]" id="arrayvaluemasuk" value="{{json_encode($masukvalue,TRUE)}}">
<input type="hidden" name="arrayvaluekeluar[]" id="arrayvaluekeluar" value="{{json_encode($keluarvalue,TRUE)}}"> --}}
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>


$(document).ready(function() {
  $.ajax({
    type: 'get',
    data: {date: $('#filteryear').val()},
    dataType: 'json',
    url: baseUrl + '/getstatistik',
    success : function(response) {
      renderChart(response.tagihanvalue, response.masukvalue, response.keluarvalue);
    }
  });
});

function reloadstatistik() {
  $.ajax({
    type: 'get',
    data: {date: $('#filteryear').val()},
    dataType: 'json',
    url: baseUrl + '/getstatistik',
    success : function(response) {
      renderChart(response.tagihanvalue, response.masukvalue, response.keluarvalue);
    }
  });
}

$("#filteryear").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
});

// tagihan = JSON.parse($('#arrayvaluetagihan').val());
// masuk = JSON.parse($('#arrayvaluemasuk').val());
// keluar = JSON.parse($('#arrayvaluekeluar').val());
// labels = JSON.parse($('#arraylabeltagihan').val());


function floatrp(value){
    return "Rp. "+(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function renderChart(tagihan, masuk, keluar) {
  Highcharts.chart('tagihanchart', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Your financial statistics'
      },
      subtitle: {
          text: 'Year '+$('#filteryear').val()
      },
      xAxis: {
          categories: [
              'Jan',
              'Feb',
              'Mar',
              'Apr',
              'May',
              'Jun',
              'Jul',
              'Aug',
              'Sep',
              'Oct',
              'Nov',
              'Dec'
          ],
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Rupiah'
          }
      },
      tooltip: {
          headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
          pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
              '<td style="padding:0"><b>{point.y}</b></td></tr>',
          footerFormat: '</table>',
          shared: true,
          useHTML: true
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      series: [{
          name: 'Admission fee',
          color: 'rgba(68, 129, 235, 0.9)',
          data: masuk

      }, {
          name: 'Money Out',
          color: 'rgba(255, 88, 88, 0.9)',
          data: keluar

      }, {
          name: 'Bill',
          color: 'rgba(80, 204, 127, 0.9)',
          data: tagihan

      }]
  });
}

// $("#renderBtn").click(
//     function () {

//     }
// );
</script>
@endsection
