<div class="tab-pane fade show active" id="pmanagerial" role="tabpanel" aria-labelledby="tab-6-1">
	<div class="col-lg-12 grid-margin stretch-card alamraya-no-padding">
      	<div class="card">
	        <div class="card-body">
	          <h4 class="card-title">Managerial</h4>
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
						<a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/managerial/managerial.xlsx')}}');"><button class="btn btn-success">Download Contoh Excel</button></a>
						<br>
						<br>
						<form action="{{url('/hrd/payroll/managerial')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row mb-3">
								<div class="col-md-12 ">
									<label class="col-lg-12 col-form-label alamraya-no-padding">Upload File Absensi (Maks. 5mb)</label>
									<input type="file" class="dropify" name="managerial" data-height="100" data-max-file-size="5000kb"/>
								</div>
								</div>
								<div class="row mt-3 mb-3">
								<div class="col-lg-12 text-right">
									<button class="btn btn-info" id="managerialsubmit" type="submit">Proses Data</button>
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
							<br>
	          	<div class="row">

					<div class="table-responsive">
						<table class="table table-striped table-hover data-table" cellspacing="0" id="managerialtable">
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
								@foreach ($data as $key => $value)
									<tr>
										<td class="managerialpin">{{$value->pm_pin}}</td>
										<td class="managerialnip">{{$value->pm_nip}}</td>
										<td>{{$value->pm_nama}}</td>
										<td>{{$value->pm_jabatan}}</td>
										<td>{{$value->pm_kantor}}</td>
										<td>{{$value->pm_status}}</td>
										<td>{{$value->pm_norekening}}</td>
										<td>{{number_format($value->pm_gajipokok,0,',','.')}}</td>
										<td>{{number_format($value->pm_uangmakan,0,',','.')}}</td>
										<td>{{number_format($value->pm_uangtransport,0,',','.')}}</td>
										<td>{{number_format($value->pm_uangoperasional,0,',','.')}}</td>
										<td>{{number_format($value->pm_tunjanganistri,0,',','.')}}</td>
										<td>{{number_format($value->pm_tunjangananak,0,',','.')}}</td>
										<td>{{number_format($value->pm_komisisales,0,',','.')}}</td>
										<td>{{number_format($value->pm_thr,0,',','.')}}</td>
										<td>{{number_format($value->pm_insentifpeforma,0,',','.')}}</td>
										<td>{{number_format($value->pm_bonuskpi,0,',','.')}}</td>
										<td>{{number_format($value->pm_bonuspeformaperusahaan,0,',','.')}}</td>
										<td>{{number_format($value->pm_bonusloyalitas,0,',','.')}}</td>
										<td>{{number_format($value->pm_bpjskes,0,',','.')}}</td>
										<td>{{number_format($value->pm_bpjstk,0,',','.')}}</td>
										<td>{{number_format($value->pm_terlambat,0,',','.')}}</td>
										<td>{{number_format($value->pm_potongandisiplinkerja,0,',','.')}}</td>
										<td>{{number_format($value->pm_kasbon,0,',','.')}}</td>
										<td>{{number_format($value->pm_total_gaji_netto,0,',','.')}}</td>
									</tr>
								@endforeach
						  </tbody>
						</table>
					</div>

					<div class="col-lg-12 text-right mt-3">
						<a class="btn btn-primary" onclick="cetakmanagerial()"><i class="fa fa-print"></i> Print</a>
					</div>

	        	</div>
	      	</div>
    	</div>
	</div>
</div>
