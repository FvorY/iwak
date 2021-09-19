@extends('main')
@section('content')

@include('finance/bookkeeping/list_transaksi_bank')
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Finance</li>
					<li class="breadcrumb-item">Bookkeeping</li>
					<li class="breadcrumb-item active" aria-current="page">Transaksi Bank</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Transaksi Bank</h4>
		          	<div class="row">
					          		
						<div class="col-md-12 col-sm-12 col-xs-12 alamraya-btn-add-row" align="right">
							<a class="btn btn-info" href="{{url('finance/bookkeeping/bookkeeping')}}"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
						</div>

						<div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Jenis Transaksi</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <select class="form-control form-control-sm" id="">
			                  <option disabled selected>--Pilih--</option>
			                  <option value="out">Bank Keluar</option>
			                  <option value="inn">Bank Masuk</option>
			                </select>
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
							<span class="input-group-append">
								<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" title="Lihat Daftar Data Transaksi" data-toggle="modal" data-target="#lihatbank">
	                              <i class="fa fa-search"></i>
	                            </button>
	                        </span>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Akun Lawan</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <select class="form-control form-control-sm" id="">
			                  <option disabled selected>--Pilih--</option>
			                  <option value="out">1.00.01 - Kas Besar</option>
			                  <option value="inn">1.00.02 - Kas Kecil</option>
			                </select>
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
			            </div>
			            <div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Tanggal Transaksi</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12 ">
			              <div class="form-group">
			                <div id="datepicker-popup" class="input-group date datepicker alamraya-no-padding">
			                    <input type="text" class="form-control" placeholder="dd-mm-yyyy">
			                    <div class="input-group-addon alamraya-input-group-addon">
			                      <span class="mdi mdi-calendar"></span>
			                    </div>
			                </div>
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
							<span class="input-group-append">
								<button type="button" class="btn btn-warning btn-sm icon-btn ml-2" title="Bulan Yang Dipilih Untuk Tanggal Ini Juga Digunakan Sebagai Parameter Pencarian">
	                              <i class="fa fa-exclamation-circle"></i>
	                            </button>
	                        </span>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Nama Transaksi</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <input type="text" name="" placeholder="Nama Transaksi" class="form-control form-control-sm">
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
			            </div>
			            <div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Keterangan</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <textarea placeholder="Keterangan Transaksi" rows="2" class="form-control form-control-sm"></textarea>
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
			            </div>
			            <div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Akun Bank</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <select class="form-control form-control-sm" id="">
			                  <option disabled selected>--Pilih--</option>
			                  <option value="acc1">Akun 1</option>
			                  <option value="acc2">Akun 2</option>
			                </select>
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
			            </div>
			            <div class="col-md-3 col-sm-12 col-xs-12">
			              <label>Nominal Transaksi</label>
			            </div>
			            <div class="col-md-6 col-sm-12 col-xs-12">
			              <div class="form-group">
			                <input type="text" class="form-control currency" value="40.000,00" data-thousands="." data-decimal="," data-prefix="RP. "> 
			              </div>
			            </div>
			            <div class=" col-md-3 col-sm-12 alamraya-no-padding">
			            </div>

			            <div class="col-md-12 col-sm-12 col-xs-12 alamraya-btn-add-row" align="right">
							<button class="btn btn-primary" ><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan Data</button>
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

@endsection