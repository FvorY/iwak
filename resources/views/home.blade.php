@extends('main')

@section('content')
<!-- partial -->
<div class="content-wrapper">
    <div class="col-lg-12">
           <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-info text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Jumlah User</h4>
                  <h2 class="font-weight-normal mb-5" id="jumlahuser"> {{number_format($alluser)}}</h2>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Jumlah Toko</h4>
                  <h2 class="font-weight-normal mb-5" id="jumlahtoko"> {{number_format($alltoko)}}</h2>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
              <div class="card bg-gradient-success text-white">
                <div class="card-body">
                  <h4 class="font-weight-normal mb-3">Jumlah User Online</h4>
                  <h2 class="font-weight-normal mb-5" id="jumlahuseronline"> {{number_format($useronline)}} </h2>
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
