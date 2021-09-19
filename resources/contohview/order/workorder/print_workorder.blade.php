<!DOCTYPE html>
<html>
<head>
	<title>Print Quotation</title>
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
	width: 90vw;
	margin: auto;
	position: relative;
	background: transparent;
}
.div-width-background{
	content: "";
	background-image: url("{{asset('assets/atonergi.png')}}");
	background-repeat: no-repeat;
	background-position: center;
	position: absolute;
	z-index: -1;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	opacity: 0.1;
	width: 90vw;
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
.btn-print button, .btn-print a{
	float: right;
}
@media print{

	.btn-print{
		display: none;
	}
	.div-width-background{
		-webkit-print-color-adjust: exact;
		margin: auto;
	}
}
@page{
	size: portrait;
	margin: 0;
}
#print_salesorder tr:nth-child(even) {
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
<div class="div-width-background">

</div>
<div class="div-width">

	<div class="header-left">
		<img width="300px" height="80px" src="{{asset('assets/atonergi.png')}}">
	</div>
	<div class="header-right border-left">
		<h3 style="text-align: right;">PT. REJA ATON ATONERGI</h3>
		<p>62-31-99682814 | www.atonergi.com | Juanda Regency F-9, Sedati - Pabean, Surabaya</p>
	</div>
	<div class="header-left" style="margin-bottom: 15px;">
		<h1>WORK ORDER</h1>
		<table class="border-none" width="50%">
			<tbody>
				<tr >
					<td class="text-left border-none">Cust :</td>
					<td class="text-left border-none">{{ $head->c_name }}</td>

				</tr>
				<tr>
					<td class="text-left border-none"></td>
					<td class="text-left border-none"><e class="email">{{ $head->c_email }}</e></td>
				</tr>
			</tbody>
		</table>

	</div>

	<div class="header-right" style="margin-top: 15px;">
		<table class="border-none" width="100%">
			<tbody>
				<tr >
					<td class="text-left border-none">Date : </td>
					<td class="text-left border-none">{{ carbon\carbon::parse($head->q_date)->format('M d, Y') }}</td>

				</tr>
				<tr>
					<td class="text-left border-none">Rev Quote#</td>
					<td class="text-left border-none">{{ $head->q_nota }}</td>
				</tr>
				<tr>
					<td class="text-left border-none">Rev Work Order#</td>
					<td class="text-left border-none">{{ $head->wo_nota }}</td>
				</tr>
				<tr>
					<td class="text-left border-none">Customer ID</td>
					<td class="text-left border-none">{{ $head->q_customer }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="header-right" style="margin-top: 15px;">
		<table class="border-none" width="50%">
			<tbody>
				<tr>
					<td class="text-left border-none">Ship to : </td>
					<td class="text-left border-none">{{ $head->q_ship_to }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<table class="border-none" width="100%" style="margin-bottom: 15px;">

		<thead>
			<tr class="border-none">
				<th class="border-none" width="30%">Shipping Method</th>
				<th class="border-none" width="">Shipping Terms</th>
				<th class="border-none" width="30%">Delivery Date</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{ $head->q_shipping_method }}</td>
				<td>{{ $head->q_term }}</td>
				<td>{{ carbon\carbon::parse($head->q_delivery)->format('d-m-Y') }}</td>
			</tr>
		</tbody>

	</table>

	<table class="border-none" id="print_salesorder" width="100%">
		<thead>
			<tr>
				<th class="border-none" width="1%">No.</th>
				<th class="border-none" width="155px">Item Name #</th>
				<th class="border-none" width="10%">Qty</th>
				<th class="border-none" width="10%">Unit</th>
				<th class="border-none">Description</th>
				<th class="border-none">Unit Price</th>
				<th class="border-none">Line Total</th>
			</tr>
		</thead>
		<tbody>
			@php
				$total_all = 0;
			@endphp

			@foreach($data as $i=> $b)
			<tr>
				<td>{{ $i+1 }}</td>
				<td>{{ $b->i_name }}</td>
				<td>{{ $b->qd_qty }}</td>
				<td>{{ $b->u_unit }}</td>
				<td class="text-left">{{ $b->qd_description }}</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						{{ number_format($b->qd_price, 2, ",", ".") }}
					</div>
				</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						@php
							$total_all += $b->qd_total;
						@endphp
						{{ number_format($b->qd_total, 2, ",", ".") }}
					</div>
				</td>
			</tr>
			@endforeach
			@foreach($array as $a)
			<tr>
				<td class="blank"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<div class="float-left">

					</div>
					<div class="float-right">

					</div>
				</td>
				<td>
					<div class="float-left">

					</div>
					<div class="float-right">

					</div>
				</td>
			</tr>
			@endforeach
			<tr class="none-background-color">
				<td class="border-none" colspan="5"></td>
				<td class="border-none text-right">Total</td>
				<td>
					<div class="float-left">
						Rp.
					</div>
					<div class="float-right">
						{{ number_format($total_all, 2, ",", ".") }}
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="text-left" style="font-size: 12px;width: 40%;">
		<?php echo $term->p_print; ?>
	</div>
	<div class="float-left text-left" style="font-size: 12px;margin-top: 5px;width: 25%;">
		PT. REJA ATON ENERGI<br>
		JUANDA REGENCY, F-9<br>
		SIDOARJO, 61253<br>
		62-31-99682814<br>
		atonergi@gmail.com
	</div>
	<div class="float-left text-left" style="font-size: 12px;">
		<table class="border-none">
			<tr>
				<td class="border-none text-left">1.</td>
				<td class="border-none text-left">Banking Detail</td>
			</tr>
			<tr>
				<td class="border-none text-left"></td>
				<td class="border-none text-left">Bank Central Asia ( BCA )</td>
			</tr>
			<tr>
				<td class="border-none text-left"></td>
				<td class="border-none text-left">KCU Sidoarjo</td>
			</tr>
			<tr>
				<td class="border-none text-left"></td>
				<td class="border-none text-left">018.901.1000 a.n PT Reja Aton Energi</td>
			</tr>
		</table>
	</div>
	<div class="float-right text-left" style="width: 40%;font-size: 12px;">
		<table class="border-none" width="100%">
			<thead>
				<tr>
					<th class="border-none"><img width="100" height="50" src="{{asset('assets/checked.jpg')}}"></th>
					<th class="border-none">{{date('d M Y')}}</th>
				</tr>
			</thead>
			<tbody>
				<tr style="border-top: 1px solid black;">
					<td class="border-none">Authorized By</td>
					<td class="border-none">Date</td>
				</tr>
				<tr>
					<td class="border-none"></td>
					<td class="border-none"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</body>
<script type="text/javascript">
	window.print();
</script>
</html>
