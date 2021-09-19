@extends('main')

@section('content')
<!-- partial -->
<div class="content-wrapper">
    <div class="col-lg-12">
           <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-info text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Saldo anda</h4>
                  {{-- <h2 class="font-weight-normal mb-5" id="online"> {{FormatRupiah($saldo)}}</h2> --}}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Keluaran anda bulan ini</h4>
                  {{-- <h2 class="font-weight-normal mb-5" id="offline"> {{FormatRupiah($uangkeluar)}}</h2> --}}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-success text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Tagihan anda bulan ini (Belom dibayar)</h4>
                  {{-- <h2 class="font-weight-normal mb-5" id="offline"> {{FormatRupiah($tagihan)}}</h2> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('extra_script')
<script type="text/javascript">

</script>
@endsection
