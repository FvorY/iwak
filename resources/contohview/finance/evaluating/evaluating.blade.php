@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">

	<?php 

        // Cek Apakah Support Cabang;

            $cabang = '';

            if(modulSetting()['support_cabang'])
                $cabang = '&cab='.modulSetting()['onLogin'];

    ?>

	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Finance</li>
					<li class="breadcrumb-item active" aria-current="page">Evaluating</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Pilih Analisa</h4>
		          <br>
		          	<div class="row">
		          		
						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.npo', '_token='.csrf_token().'&type=bulan&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Net Profit/OCF</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.hutang_piutang', '_token='.csrf_token().'&type=bulan&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Hutang Piutang</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.pertumbuhan_aset', '_token='.csrf_token().'&type=bulan&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Pertumbuhan Aset</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.aset_ekuitas', '_token='.csrf_token().'&type=bulan&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Aset Terhadap Ekuitas</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.common_size', '_token='.csrf_token().'&type=neraca&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Common Size</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.cashflow', '_token='.csrf_token().'&type=bulan&d1='.date('Y')).'&jenis=rekap'.$cabang }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Cashflow</label>
								</div>
							</a>
						</div>

						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('analisa.keuangan.rasio', '_token='.csrf_token().'&type=bulan&d1='.date('Y').$cabang) }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-clipboard icon-lg text-primary"></i>
								<div class="center">
									<label>Analisa Rasio</label>
								</div>
							</a>
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