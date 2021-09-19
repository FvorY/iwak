@extends('main')
@section('content')

{{-- @include('hrd/payroll/tambah_payroll_manajemen')
@include('hrd/payroll/edit_payroll_manajemen')
@include('hrd/payroll/tambah_payroll_tunjangan')
@include('hrd/payroll/edit_payroll_tunjangan') --}}
<!-- partial -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<nav aria-label="breadcrumb" role="navigation">
				<ol class="breadcrumb bg-info">
					<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
					<li class="breadcrumb-item">HRD</li>
					<li class="breadcrumb-item active" aria-current="page">Payroll</li>
				</ol>
			</nav>
		</div>

		<div class="col-lg-12 ">
			<ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" role="tablist">
		        <li class="nav-item">
		          <a class="nav-link active" id="tab-6-1" data-toggle="tab" href="#pmanagerial" role="tab" aria-controls="pmanagerial" aria-selected="true"><i class="mdi mdi-folder-account"></i>Managerial</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link " id="tab-6-2" data-toggle="tab" href="#pstaff" role="tab" aria-controls="pstaff" aria-selected="true"><i class="mdi mdi-coin"></i>Staff</a>
		        </li>
		    </ul>

			<div class="tab-content tab-content-solid col-lg-12">

				@include('hrd.payroll.tab_managerial')

				@include('hrd.payroll.tab_staff')


			</div>
		</div>
	</div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
	function refresh(){
		window.location.href = baseUrl + '/hrd/payroll/payroll';
	}

	function cetakmanagerial(){
		var pin = [];
		var selectedVal;
		$(".managerialpin").each(function(i, sel){
				selectedVal = $(sel).text();
				pin.push(selectedVal);
		});

		var nip = [];
		var selectedVal;
		$(".managerialnip").each(function(i, sel){
				selectedVal = $(sel).text();
				nip.push(selectedVal);
		});

		for (var i = 0; i < pin.length; i++) {
			if (pin[i] == '') {
				pin[i] = null;
			} else {
				pin[i] = parseInt(pin[i]);
			}
		}

		for (var i = 0; i < nip.length; i++) {
			if (nip[i] == '') {
				nip[i] = null;
			} else {
				nip[i] = parseInt(nip[i]);
			}
		}

		var url = '';
		for (var i = 0; i < nip.length; i++) {
				url += 'nip%5B%5D='+nip[i]+'&';
		}



		for (var i = 0; i < pin.length; i++) {
				url += 'pin%5B%5D='+pin[i]+'&';
		}

		window.open('{{route('print_payroll')}}?'+url , '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes')

	}

	function cetakstaff(){
		var pin = [];
		var selectedVal;
		$(".staffpin").each(function(i, sel){
				selectedVal = $(sel).text();
				pin.push(selectedVal);
		});

		var nip = [];
		var selectedVal;
		$(".staffnip").each(function(i, sel){
				selectedVal = $(sel).text();
				nip.push(selectedVal);
		});

		for (var i = 0; i < pin.length; i++) {
			if (pin[i] == '') {
				pin[i] = null;
			} else {
				pin[i] = parseInt(pin[i]);
			}
		}

		for (var i = 0; i < nip.length; i++) {
			if (nip[i] == '') {
				nip[i] = null;
			} else {
				nip[i] = parseInt(nip[i]);
			}
		}

		var url = '';
		for (var i = 0; i < nip.length; i++) {
				url += 'nip%5B%5D='+nip[i]+'&';
		}

		url += '&';

		for (var i = 0; i < pin.length; i++) {
				url += 'pin%5B%5D='+pin[i]+'&';
		}

		window.open('{{route('print_payrolls')}}?'+url , '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes')

	}
</script>
@endsection
