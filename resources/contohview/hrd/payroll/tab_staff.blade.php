<div class="tab-pane fade " id="pstaff" role="tabpanel" aria-labelledby="tab-6-2">
	<div class="col-lg-12 grid-margin stretch-card alamraya-no-padding">
      	<div class="card">
	        <div class="card-body">
	          <h4 class="card-title">Staff</h4>
						@if(Session::has('sukses'))
								<div class="alert alert-fill-primary" role="alert">
									<i class="mdi mdi-alert-circle"></i>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
																aria-hidden="true">&times;</span></button>
										<strong>{{ Session::get('sukses') }}</strong>
								</div>
						@elseif(Session::has('gagal'))
							<div class="alert alert-fill-danger" role="alert">
								<i class="mdi mdi-alert-circle"></i>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
															aria-hidden="true">&times;</span></button>
									<strong>{{ Session::get('gagal') }}</strong>
							</div>
						@endif
						<a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/staff/staff.xlsx')}}');"><button class="btn btn-success">Download Contoh Excel</button></a>
						<br>
						<br>
						<form action="{{url('/hrd/payroll/staff')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row mb-3">
								<div class="col-md-12 ">
									<label class="col-lg-12 col-form-label alamraya-no-padding">Upload File Absensi (Maks. 5mb)</label>
									<input type="file" class="dropify" name="staff" data-height="100" data-max-file-size="5000kb"/>
								</div>
								</div>
								<div class="row mt-3 mb-3">
								<div class="col-lg-12 text-right">
									<button class="btn btn-info" type="submit">Proses Data</button>
								</div>
							</div>
							</form>

							<div class="col-lg-3 col-md-3 col-sm-12 alamraya-no-padding alamraya-opt-btn">
								<span class="btn-group mt-1">
																 <button type="button" class="btn btn-info btn-sm icon-btn" onclick="refresh()">
																	<i class="fa fa-refresh"></i>
																</button>
														</span>
							</div>
	          	<div class="row">

					<div class="table-responsive">
						<table class="table table-hover data-table" cellspacing="0" id="stafftable">
						  <thead class="bg-gradient-info">
						    <tr>
									<th>PIN</th>
									<th>NIP</th>
									<th>Nama</th>
									<th>Jabatan</th>
									<th>Kantor</th>
									<th>Status</th>
									<th>No Rekening</th>
									<th>Gaji Pokok</th>
									<th>Uang Makan</th>
									<th>Uang Transport</th>
									<th>Uang Operasional</th>
									<th>Tunjangan Istri</th>
									<th>Tunjangan AnAK</th>
									<th>Komisi Sales</th>
									<th>THR</th>
									<th>Intensif Peforma</th>
									<th>Bonus KPI</th>
									<th>Bonus Peforma Perusahaan</th>
									<th>Bonus Loyalitas</th>
									<th>BPJS Kes</th>
									<th>BPJS TK</th>
									<th>Terlambat</th>
									<th>Potongan Disiplin Kerja</th>
									<th>Kasbon</th>
									<th>Total Gaji Netto</th>
						    </tr>
						  </thead>
						  <tbody class="center">
								@foreach ($staff as $key => $value)
									<tr>
										<td class="staffpin">{{$value->ps_pin}}</td>
										<td class="staffnip">{{$value->ps_nip}}</td>
										<td>{{$value->ps_nama}}</td>
										<td>{{$value->ps_jabatan}}</td>
										<td>{{$value->ps_kantor}}</td>
										<td>{{$value->ps_status}}</td>
										<td>{{$value->ps_norekening}}</td>
										<td>{{number_format($value->ps_gajipokok,0,',','.')}}</td>
										<td>{{number_format($value->ps_uangmakan,0,',','.')}}</td>
										<td>{{number_format($value->ps_uangtransport,0,',','.')}}</td>
										<td>{{number_format($value->ps_uangoperasional,0,',','.')}}</td>
										<td>{{number_format($value->ps_tunjanganistri,0,',','.')}}</td>
										<td>{{number_format($value->ps_tunjangananak,0,',','.')}}</td>
										<td>{{number_format($value->ps_komisisales,0,',','.')}}</td>
										<td>{{number_format($value->ps_thr,0,',','.')}}</td>
										<td>{{number_format($value->ps_insentifpeforma,0,',','.')}}</td>
										<td>{{number_format($value->ps_bonuskpi,0,',','.')}}</td>
										<td>{{number_format($value->ps_bonuspeformaperusahaan,0,',','.')}}</td>
										<td>{{number_format($value->ps_bonusloyalitas,0,',','.')}}</td>
										<td>{{number_format($value->ps_bpjskes,0,',','.')}}</td>
										<td>{{number_format($value->ps_bpjstk,0,',','.')}}</td>
										<td>{{number_format($value->ps_terlambat,0,',','.')}}</td>
										<td>{{number_format($value->ps_potongandisiplinkerja,0,',','.')}}</td>
										<td>{{number_format($value->ps_kasbon,0,',','.')}}</td>
										<td>{{number_format($value->ps_total_gaji_netto,0,',','.')}}</td>
									</tr>
								@endforeach
						  </tbody>
						</table>
					</div>

					<div class="col-lg-12 text-right mt-3">
						<a class="btn btn-primary" onclick="cetakstaff()"><i class="fa fa-print"></i> Print</a>
					</div>

	        	</div>
	      	</div>
    	</div>
	</div>
</div>
