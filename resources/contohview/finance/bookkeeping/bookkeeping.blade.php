@extends('main')
@section('content')

@include('finance/bookkeeping/tambah_bookkeeping')
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">	
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">Finance</li>
					<li class="breadcrumb-item active" aria-current="page">Bookkeeping</li>
				</ol>
			</nav>
		</div>
		<div class="col-lg-12 grid-margin stretch-card">
	      	<div class="card">
		        <div class="card-body">
		          <h4 class="card-title">Pilih Transaksi</h4>
		          <br>
		          	<div class="row">
		          		
						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ route('transaksi.kas.index') }}" class="center text-primary alamraya-choosing-panel">
								<i class="fa fa-money icon-lg text-primary"></i>
								<div class="center">
									<label>&nbsp;Transaksi Kas&nbsp;</label>
								</div>
							</a>
						</div>
						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ route('transaksi.bank.index') }}" class="center text-warning alamraya-choosing-panel">
								<i class="fa fa-book icon-lg text-warning"></i>
								<div class="center">
									<label>&nbsp;Transaksi Bank&nbsp;</label>
								</div>
							</a>
						</div>
						<div class="col-lg-4 grid-margin stretch-card justify-content-center">
							<a href="{{ Route('transaksi.memorial.index') }}" class="center text-danger alamraya-choosing-panel">
								<i class="fa fa-sticky-note icon-lg text-danger"></i>
								<div class="center">
									<label>&nbsp;Transaksi Memorial&nbsp;</label>
								</div>
							</a>
						</div>
						<div class="col-lg-4 grid-margin stretch-card justify-content-center" style="margin-top: 10px;">
							<a href="{{ Route('transaksi.penerimaan_piutang.index') }}" class="center text-success alamraya-choosing-panel">
								<i class="fa fa-sign-in icon-lg text-success"></i>
								<div class="center">
									<label>Penerimaan Piutang</label>
								</div>
							</a>
						</div>
						<div class="col-lg-4 grid-margin stretch-card justify-content-center" style="margin-top: 10px;">
							<a href="{{ Route('transaksi.pelunasan_hutang.index') }}" class="center text-muted alamraya-choosing-panel">
								<i class="fa fa-sign-out icon-lg text-muted"></i>
								<div class="center">
									<label>Pelunasan Hutang</label>
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