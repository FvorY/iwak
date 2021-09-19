@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Manajemen Aset</li>
					<li class="breadcrumb-item active" aria-current="page">Irventarisasi</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	              <div class="card">
	                <div class="card-body">
	                  <h4 class="card-title">Irventarisasi</h4>
	                 	<div class="row">
          <form id="save_data">  
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
              <label>Tipe Akun</label>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="form-group">
                  <input type="text" name="type_akun" id="type_akun" class="form-control" readonly="" value="{{ $akun->type_akun }}" placeholder="Masukkan Nomor Akun">
              </div>
            </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Kelompok Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                  <input type="text" name="kelompok_akun" id="kelompok_akun" class="form-control" readonly="" value="{{ $akun->kelompok_akun }}" placeholder="Masukkan Nomor Akun">
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Nomor Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <div class="input-group">
                  <input type="text" name="id_akun" id="id_akun" class="form-control" readonly="" value="{{ $akun->id_akun }}" placeholder="Masukkan Nomor Akun">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Nama Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <input type="text" name="nama_akun" id="nama_akun" class="form-control" placeholder="Masukkan Nama Akun">
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Debet / Kredit</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select class="form-control form-control-sm" id="posisi_akun" name="posisi_akun">
                      <option value="D">DEBET</option>
                      <option value="K">KREDIT</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Group Neraca</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <select class="form-control form-control-sm select2" id="group_neraca" name="group_neraca">
                      <option selected>Tidak Memiliki group Neraca</option>
                      @foreach ($grupakun as $element)
                      @if ($element->no_group == $akun->group_neraca )
                        <option value="{{ $element->no_group }}" selected="">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                      @else
                        <option value="{{ $element->no_group }}">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Group Laba Rugi</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <select class="form-control form-control-sm select2" id="group_laba_rugi" name="group_laba_rugi">
                      <option selected>Tidak Memiliki group Neraca</option>
                      @foreach ($labarugi as $element)
                        @if ($element->no_group == $akun->group_laba_rugi )
                        <option value="{{ $element->no_group }}" selected="">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                        @else
                          <option value="{{ $element->no_group }}">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <label>Saldo Bulan ini</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <div class="form-group form-group-sm">
                    <input type="text" name="saldo" class="form-control text-right format_money" placeholder="Masukkan Group Laba Rugi">
                  </div>
                </div>
              </div>
            </div>
          </form>
          <button class="btn btn-primary" type="button">Simpan</button>

         </div> <!-- End div row -->
	                </div>
	              </div>
	    </div>
	</div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

@endsection