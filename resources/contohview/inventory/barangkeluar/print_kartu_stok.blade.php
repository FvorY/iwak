<!DOCTYPE html>
<html>
<head>
	<title>Kartu Stok</title>
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
			padding: 45px 15px 15px 15px;
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
		table,td,th{
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
				padding: 15px 15px 15px 15px;
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
			margin-bottom: .25rem;
		}
		.mb-2{
			margin-bottom: .5rem;
		}
		.mb-3{
			margin-bottom: 1rem;
		}
		.mb-4{
			margin-bottom: 1.5rem;
		}
		.mb-5{
			margin-bottom: 3rem;
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
		.red{
			color: red;
		}
	</style>
</head>
<body>
	<div class="btn-print" align="right">
		<button onclick="javascript:window.print();">Print</button>
	</div>
	<div class="div-page-break-after">
		<div class="div-width">
			<h1 class="calibri underline text-center">Item Stock Card</h1>
			<table class="border-none mb-3" width="100%">
				<tr>
					<td width="25%">Item Type</td>
					<td width="1%">:</td>
					@if ($data[0]->i_type != null)
						<td width="25%">{{$data[0]->i_type}}</td>
					@endif
					<td width="25%">Card No</td>
					<td width="1%">:</td>
					@if (!empty($cardno->pbd_code))
						<td width="25%">{{$cardno->pbd_code}}</td>
					@endif
				</tr>
				<tr>
					<td>Unit</td>
					<td>:</td>
					@if ($data[0]->u_unit != null)
						<td>{{$data[0]->u_unit}}</td>
					@endif
					<td colspan="3"><!-- Nothing here --></td>
				</tr>
			</table>

			<table width="100%" cellpadding="3px">
				<thead>
					<tr>
						<th width="15%">Date</th>
						<th>Receive From</th>
						<th>In</th>
						<th>Out</th>
						<th>Remain</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $key => $value)
						<tr>
							<td>{{Carbon\Carbon::parse($value->sm_insert)->format('d-m-Y')}}</td>
							<td>{{$value->sm_description}}</td>
							<td align="center" width="10%">{{$value->sm_qty}}</td>
							<td align="center" class="red" width="10%">{{$value->sm_use}}</td>
							<td align="center" width="10%">{{$value->sm_sisa}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
