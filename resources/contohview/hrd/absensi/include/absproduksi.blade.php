<div class="col-lg-12 grid-margin stretch-card alamraya-no-padding">
  	<div class="card">
        <div class="card-body">
          <h4 class="card-title">Absensi Produksi</h4>
          	<div class="row alamraya-dwld-row">
          		<button type="button" class="btn btn-warning btn-rounded btn-fw alamraya-dwld-btn" onclick="javascipt:window.open('{{ url('') }}/public/assets/berkas/absensi-produksi/contoh-master-produksi.xlsx');"><i class="fa fa-download"></i>&nbsp;&nbsp;Download Contoh Master</button>&nbsp;&nbsp;
          		<button type="button" class="btn btn-warning btn-rounded btn-fw"  onclick="javascipt:window.open('{{ url('') }}/public/assets/berkas/absensi-produksi/id-produksi.xlsx');"><i class="fa fa-download"></i>&nbsp;&nbsp;Download ID Produksi</button>
          	</div><br>
          	<div class="row ">
          		<form method="POST" enctype="multipart/form-data" action="{{ url('/hrd/absensi/import-data-produksi') }}" style="width: 100%">
          			{{csrf_field()}}
	          		<div class="col-md-12 ">
		          		<label class="col-lg-12 col-form-label alamraya-no-padding">Upload File Absensi (Maks. 5mb)</label>
		          		<input type="file" name="file-produksi" class="dropify" data-height="100" data-max-file-size="5000kb"/>
		          	</div>

		          	<div class="col-md-12" style="margin-top: 2mm">
		          		<button class="btn btn-primary" type="submit">Upload</button>
		          	</div>
          		</form>
            </div><br>
            <div class="row form-group">
            	<div class="col-lg-8 col-md-12 col-sm-12">
                	<label class="col-lg-12 col-form-label alamraya-no-padding">Tanggal</label>

                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12 alamraya-no-padding">
								<div id="datepicker-popup" class="input-group date datepicker">
			                        <input type="text" class="form-control" placeholder="dd-mm-yyyy" id='absproduksi_tgl_awal'>
			                        <div class="input-group-addon">
			                          <span class="mdi mdi-calendar"></span>
			                        </div>
			                    </div>
							</div>
							<span class="alamraya-span-addon">
								-
							</span>
							<div class="col-lg-4 col-md-4 col-sm-12 alamraya-no-padding">
								<div id="datepicker-popup" class="input-group date datepicker">
			                        <input type="text" class="form-control" placeholder="dd-mm-yyyy" id='absproduksi_tgl_akhir'>
			                        <div class="input-group-addon">
			                          <span class="mdi mdi-calendar"></span>
			                        </div>
			                    </div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 alamraya-no-padding alamraya-opt-btn">
								<span class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" id="absproduksi_search">
		                              <i class="fa fa-search"></i>
		                            </button>
		                             <button type="button" class="btn btn-info btn-sm icon-btn ml-2"  id='absproduksi_refresh'>
		                              <i class="fa fa-refresh"></i>
		                            </button>
		                        </span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 col-sm-12 ">
                	<label class="col-lg-12 col-form-label alamraya-label-padding">Divisi</label>

                	<div class="col-lg-12 col-md-12 col-sm-12 alamraya-no-padding">
						<div class="form-group">
							<select class="form-control form-control-sm" id="absproduksi_id_divisi">
							<option value="">Semua Divisi</option>
							@foreach ($divisi as $item)
							    <option value="{{ $item->c_id }}">{{ $item->c_divisi }}</option>
							@endforeach
							</select>
						</div>
					</div>
				</div>
            </div>
          	<div class="row ">
				<!-- <div class="col-md-12 col-sm-12 col-xs-12 alamraya-btn-add-row" align="right"> -->
					<!-- <button class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button> -->
				<!-- </div> -->
				<div class="table-responsive">
					<table class="table table-hover" cellspacing="0" id="tbl_absproduksi" style="width:100%">
					  <thead class="bg-gradient-info">
					    <tr>
							<th>Tanggal</th>
							<th>Kode Nama Pegawai</th>
							<th>Jam Kerja</th>
							<th>Jam Masuk</th>
							<th>Jam Pulang</th>
							<th>Scan Masuk</th>
							<th>Scan Pulang</th>
							<th>Terlambat</th>
							<th>Total Kerja</th>
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

