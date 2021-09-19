<!DOCTYPE html>
<html>
<head>
	<title>Print Checklist Form</title>
	<style>
*{
	font-family: arial;
	text-align: center;

}
table {
    border-collapse: collapse;
    font-size:12px;
}

table, td, th {
    border: 1px solid black;
}



.header-left {
	float: left;
	width: 60%;
	text-align: left;
}
.header-right{
	float: right;
	width: 39%;
	text-align: right;

}
.border-left{
	border-left: 5px solid yellow;
}
.header-right p{
	font-size: 12px;
	text-align: right;
}
.header-right h1, h2, h3, h4, h5, h6{
	text-align: right;
}
.header-left p, h1, h2, h3, h4, h5, h6{
	text-align: left;
}
.header-left p{
	12px;
}
.table1 tr > td{
	border-style: hidden;
}
.div-width{
	width: 900px;
	position: relative;
	margin: auto;
}
.div-width:before{
	content: "";
	background-image: url("{{asset('assets/atonergi.png')}}");
	background-repeat: no-repeat;
	background-position: center;
	position: absolute;
	display: block;
	z-index: -1;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	opacity: 0.1;
}
.top
{
	vertical-align: top;
	text-align: left;
}
.top-center
{
	vertical-align: top
	text-align:center;
}
.bottom
{
	vertical-align: bottom;
	text-align: left;
}
.blank
{
	height: 15px;
}
.tebal
{
	font-weight: bold;
}
.half-left
{
	float: left;
	width: 49.9%;
	border-right: 1px solid black;
}
.half-right
{
	float: right;
	width: 49.9%;
	border-left: 1px solid black;
}
.footer
{
	height: 70px;
}
.email{
	color: blue;
	text-decoration: underline;
}
.border-none{
	border:none;
}
.text-left{
	text-align: left;
}
.text-right{
	text-align: right;
}

.float-left{
	float: left;
}
.float-right{

	float: right;
}
@page{
	size: portrait;
	margin: 0;
	-webkit-print-color-adjust:exact;
	color-adjust:exact;
}
@media print{
	.div-width{
		width: 95%;
	}
	.btn-print{
		display: none;
	}
}
.btn-print button, .btn-print a{
	float: right;
}
.page-break{
	page-break-after: always;
}
#print_checklistform tr:nth-child(even) {
    background-color: #f2f2f2bb;
}
.none-background-color{
	background-color: inherit !important;
}
.italic{
	font-style: italic;
}
	</style>
</head>
<body>
	<div class="btn-print">
		<button onclick="javascript:window.print();">Print</button>
	</div>
	<div class="page-break">
		<div class="div-width">

			<div class="header-left">
				<img width="300px" height="80px" src="{{asset('assets/atonergi.png')}}">
			</div>
			<div class="header-right border-left">
				<h3 style="text-align: right;">PT. REJA ATON ATONERGI</h3>
				<p>62-31-99682814 | www.atonergi.com | Juanda Regency F-9, Sedati - Pabean, Surabaya</p>
			</div>
			<div class="header-left" style="margin-bottom: 15px;">
				<h1>Checklist Form</h1>
				<table class="border-none" width="50%">
					<tbody>
						<tr >
							<td class="text-left border-none">Order By :</td>
							<td class="text-left border-none">{{$data->c_name}}</td>

						</tr>

					</tbody>
				</table>

			</div>

			<div class="header-right" style="margin-top: 15px;margin-bottom: 55px;">
				<table class="border-none" width="100%">
					<tbody>
						<tr >
							<td class="text-left border-none">Date : </td>
							<td class="text-left border-none">{{Carbon\Carbon::parse($data->d_delivery_date)->format('F d, Y')}}</td>

						</tr>
						<tr>
							<td class="text-left border-none">S.O#</td>
							<td class="text-left border-none">{{$data->so_nota}}</td>
						</tr>
						<tr>
							<td class="text-left border-none">Customer ID</td>
							<td class="text-left border-none">{{$data->q_customer}}</td>
						</tr>
						<tr>
							<td class="text-left border-none">Checker</td>
							<td class="text-left border-none">{{Auth::user()->m_name}}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<table class="border-none" id="print_checklistform" width="100%">
				<thead>
					<tr>
						<th class="border-none" width="1%">No.</th>
						<th class="border-none" width="15%">Item Name #</th>
						<th class="border-none" width="5%">Qty</th>
						<th class="border-none">Description</th>
						<th class="border-none">Checklist</th>
						<th class="border-none">Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0 ?>
					@foreach ($item as $aku)
						{{ $count += 1}}
						<tr>
							<td>{{$count}}</td>
							<td>{{$aku->i_name}}</td>
							<td>{{$aku->qd_qty}}</td>
							<td>{{$aku->i_description}}</td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@foreach ($acc as $value)
						{{ $count += 1}}
						<tr>
							<td>{{$count}}</td>
							<td>{{$value->a_acc}}</td>
							<td>{{(int)$value->a_qty}}</td>
							<td>{{$value->a_description}}</td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@for($i = 0; $i<10;$i++)
					<tr>
						<td class="blank"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endfor
				</tbody>
			</table>
			<div class="float-right text-left" style="width: 100%;font-size: 12px;margin-top: 55px;">
				<table class="border-none" width="100%">
					<thead>
						<tr>
							<th class="border-none"></th>
							<th class="border-none"></th>
							<th class="border-none">{{date('d M Y')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr style="border-top: 1px solid black;">
							<td class="border-none">Warehouse</td>
							<td class="border-none">Authorized By</td>
							<td class="border-none">Date</td>
						</tr>
						<tr>
							<td class="border-none"></td>
							<td class="border-none"><img width="100" height="80" src="{{asset('assets/approved.png')}}"></td>
							<td class="border-none"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	window.print();
</script>
</html>
