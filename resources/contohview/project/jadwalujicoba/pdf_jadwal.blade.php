<!DOCTYPE html>
<html>
<head>
	<title>Schedule Jadwal Uji Coba & Dokumentasi</title>
	<style type="text/css">
		html,body{
			padding: 0;
			margin: 0;
			height: 99%
		}
		*:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
			font-size: 14px;
			font-family: "calibri";
		}
		.s16{
			font-size: 16px !important;
		}
		.calibri{
			font-family: 'calibri';
		}
		.div-width{
			width: 900px;
			/*margin-top:160px;*/
			padding: 160px 0 15px 0;
			background: transparent;
			position: absolute;
		}
		.div-width-background{
			/*background-image: url("{{asset('assets/images/atonergi-bg2.png')}}");
			background-repeat: no-repeat;
			background-position: center; */
			position: relative;
			z-index: -1;

			padding: 0;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			/*opacity: 0.1; */
			width: 900px;
			height: 100%;
		}
		.underline{
			text-decoration: underline;
		}
		.italic{
			font-style: italic;
		}
		.bold{
			font-weight: bold;
		}
		.text-center{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
		.text-left{
			text-align: left;
		}
		.border-none-right{
			border-right: hidden;
		}
		.border-none-left{
			border-left:hidden;
		}
		.border-none-bottom{
			border-bottom: hidden;
		}
		.border-none-top{
			border-top: hidden;
		}
		.float-left{
			float: left;
		}
		.float-right{
			float: right;
		}
		.top{
			vertical-align: text-top;
		}
		.vertical-baseline{
			vertical-align: baseline;
		}
		.bottom{
			vertical-align: text-bottom;
		}
		.ttd{
			width: 150px;
		}
		.relative{
			position: relative;
		}
		.absolute{
			position: absolute;
		}
		.empty{
			height: 18px;
		}
		table,td{
			border:1px solid black;
		}
		table{
			border-collapse: collapse;
		}
		table.border-none ,.border-none td{
			border:none !important;
		}
		.position-top{
			vertical-align: top;
		}
		@page {
			size: portrait;
			margin:0 0 0 0;
		}
		@media print {
			html, body {
		        height: auto;
		    }
			.div-width{
				margin: auto;
				padding: 120px 15px 15px 15px;
				width: 95vw;
				position: absolute;
			}
			.btn-print{
				display: none;
			}
			header{
				top:0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			footer{
				bottom: 0;
				left: 0;
				right: 0;
				position: absolute;
				width: 100%;
			}
			.div-width-background{
				/*background-image: url("{{asset('assets/images/atonergi-bg2.png')}}");
				background-repeat: no-repeat;
				background-position: center; */

				position: relative;
				z-index: -1;
				margin: auto;
				/*opacity: 0.1; */
				width: 100vw;
				height: 100vh;
			}
		}
		fieldset{
			border: 1px solid black;
			margin:-.5px;
		}
		header{
			top: 0;
			width: 900px;
		}
		footer{
			bottom: 0;
			width: 900px;
		}
		.border-top{
			border-top: 1px solid black;
		}
		.btn-print{
			position: fixed;
			width: 100%;
			text-align: right;
			left: 0;
			top: 0;
			background: rgba(0,0,0,.2);
		}
		.btn-print button, .btn-print a{
			margin: 10px;
		}
		.border-bottom-dotted{
			border-bottom: 1px dotted black !important;
		}
		.div-page-break-after{
			page-break-after: always;
		}
		.div-page-break-after:last-child{
			page-break-after: auto;
		}
		.block{
			display: block;
		}
		.grey{
			color: grey;
		}
		.m-auto{
			margin: auto;
		}
		.w-50percent{
			width: 50%;
		}
		.title-atonergi{
			width: 75%;
			background-color: yellow;
			border: 1px solid black;
			margin: auto;
		}
		.mb-1{
			margin-bottom: 1rem;
		}
		.mb-2{
			margin-bottom: 2rem;
		}
		.mb-3{
			margin-bottom: 3rem;
		}
		.mb-4{
			margin-bottom: 4rem;
		}
		.mb-5{
			margin-bottom: 5rem;
		}
		.row{
			display: flex;
			flex-wrap: wrap;
			margin: auto;
			padding-right: 45px;
			padding-left: 45px;
		}
		.col-6{
			flex: 0 0 50%;
			max-width: 50%;
		}
		.col-12{
			flex: 0 0 99%;
			max-width: 100%;
		}
	</style>
</head>
<body>
	<div class="div-page-break-after">

		@php

		setlocale(LC_ALL, "id_ID");



		@endphp

		<div class="btn-print" align="right">
			<button onclick="javascript:window.print();">Print</button>
		</div>

		<div class="div-width">
			<h1 class="block text-center grey">
				REPORT DOKUMENTASI <br>
				INSTALATION PUMP	<br>
				LORENTZ {{$install[0]->si_pump_controller}} {{$install[0]->si_pump_pump}}
			</h1>
			<div class="grey m-auto w-50percent">
<pre>
<h2>
	NAMA DESA : {{$install[0]->si_city}}
	PROVINSI : {{$install[0]->si_province}}
	DATE PROJECT : {{$install[0]->si_installation_date}}
	HEAD : {{$install[0]->si_total_dynamic_head}} {{$install[0]->si_total_dinamyc_satuan}}
	DAILY OUTPUT : {{$install[0]->si_daily_flow_rate}} M3/DAY
	PIPE : {{$install[0]->si_pipe_diameter}} {{$install[0]->si_pipe_diameter_satuan}}
	SOLAR PANEL : {{$install[0]->si_power_total}} (@ {{$install[0]->si_power_each}} POLY) - {{$install[0]->si_quantity_generator}}
	TECHNICIAN PIC : {{$install[0]->si_installer}}
</h2>
</pre>
			</div>
		</div>
		<div class="div-width-background">
			<img width="100%" height="99.6%" src="{{asset('assets/images/atonergi-bg2.png')}}">
		</div>

	</div>

	<?php $count = 0; ?>
	@foreach ($judul as $key => $x)
		<div class="div-page-break-after">
			<div class="div-width">
				<div class="title-atonergi text-center mb-2">
					<h1>{{$x->si_judul}}</h1>
				</div>
				<div class="row text-center">
					@foreach ($image as $key => $z)
						@if ($z->si_judul == $x->si_judul)
							@if ($z->si_update == 1)
								<center>
									<div class="col-6 mb-2" style="margin-right:130px;">
									<img width="500px" height="600px" src="{{url('/') . '/' . $z->si_image}}">
									</div>
								</center>
							@elseif ($z->si_update == 2)
								<div class="col-6 mb-2">
									<img width="310px" height="500px" src="{{url('/') . '/' . $z->si_image}}">
								</div>
							@elseif ($z->si_update == 3)
								<?php $count += 1; ?>
								@if ($count == 3)
									<center><div class="col-6 mb-2">
										<img width="450px" height="350px" src="{{url('/') . '/' . $z->si_image}}">
									</div></center>
								@else
									<div class="col-6 mb-2">
										<img width="300px" height="300px" src="{{url('/') . '/' . $z->si_image}}">
									</div>
								@endif
							@elseif ($z->si_update == 4)
								<div class="col-6 mb-2">
									<img width="300px" height="300px" src="{{url('/') . '/' . $z->si_image}}">
								</div>
							@endif
						@endif
					@endforeach
				</div>
			</div>
			<div class="div-width-background">
				<img width="100%" height="99.6%" src="{{asset('assets/images/atonergi-bg2.png')}}">
			</div>
		</div>
	@endforeach
	<div class="div-page-break-after">
		<div class="div-width-background">
			<img width="100%" height="99.6%" src="{{asset('assets/images/atonergi-bg-end.png')}}">
		</div>
	</div>
</body>
</html>
