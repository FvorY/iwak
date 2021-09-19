<!DOCTYPE html>
<html>
<head>
	<title>Print Purchase Order</title>
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
}
@media print{
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

	</style>
</head>
<body>
	<div class="btn-print">
		<button onclick="window.print()">Print</button>
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
				<h1>Purchase Order</h1>
				<table class="border-none" width="60%">
					<tbody>
						<tr >
							<td class="text-left border-none">Vendor :</td>
							<td class="text-left border-none">{{ $print_header->s_company }}</td>

						</tr>
						<tr>
							<td class="text-left border-none"></td>
							<td class="text-left border-none"><e class="email">{{ $print_header->s_email }}</e></td>
						</tr>
						<tr>
							<td class="text-left border-none"></td>
							<td class="text-left border-none">{{ $print_header->s_address }}</td>
						</tr>
						<tr>
							<td class="text-left border-none"></td>
							<td class="text-left border-none">[{{ $print_header->s_phone }}]</td>
						</tr>
					</tbody>
				</table>

			</div>

			<div class="header-right" style="margin-top: 15px;">
				<table class="border-none" width="100%">
					<tbody>
						<tr >
							<td class="text-left border-none">Date : </td>
							<td class="text-left border-none">{{ $print_header->po_date }}</td>

						</tr>
						<tr>
							<td class="text-left border-none">S.O#</td>
							<td class="text-left border-none">{{ $print_header->po_code }}</td>
						</tr>
						<tr>
							<td class="text-left border-none">Customer ID</td>
							<td class="text-left border-none">-</td>
						</tr>
						<tr>
							<td class="text-left border-none">Rev Quote#</td>
							<td class="text-left border-none">-</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="header-right" style="margin-top: 15px;margin-bottom: 15px;">
				<table class="border-none" width="50%">
					<tbody>
						<tr>
							<td class="text-left border-none">Ship to : -</td>
							<td class="text-left border-none"></td>
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
						<td>{{ $print_header->po_shipping_method }}</td>
						<td>{{ $print_header->po_shipping_term }}</td>
						<td>{{ $print_header->po_delivery_date }}</td>
					</tr>
				</tbody>

			</table>

			<table class="border-none" width="100%">
				<thead>
					<tr>
						<th class="border-none">No</th>
						<th class="border-none" width="155px">Item Name #</th>
						<th class="border-none" width="10%">Qty</th>
						<th class="border-none" width="10%">Unit</th>
						<th class="border-none" >Description</th>
						<th class="border-none">Unit Price</th>
						<th class="border-none" width="30%">Line Total</th>
					</tr>
				</thead>
				<tbody>					
					@foreach ($print_seq as $index => $seq)
						<tr>
							<td>{{ $index+1 }}</td>
							<td>{{ $seq->i_name }}</td>
							<td>{{ $seq->podt_qty_approved }}</td>
							<td>{{ $seq->u_unit }}</td>
							<td>{{ $seq->i_description }}</td>
							<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{ number_format($seq->podt_unit_price,2,',','.') }}
							</div>
							</td>
							<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{ number_format($seq->podt_price,2,',','.') }}
							</div>
							</td>


						</tr>
					@endforeach

					<tr>
						<td class="border-none" colspan="5"></td>
						<td class="border-none text-right">Subtotal</td>
						<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{ number_format($print_header->po_subtotal,2,',','.') }}
							</div>
						</td>
					</tr>
					<tr>
						<td class="border-none" colspan="5"></td>
						<td class="border-none text-right">Sales Tax</td>
						<td>
							<div class="float-left">

							</div>
							<div class="float-right">
								{{ number_format($print_header->po_sales_tax,2,',','.') }}
							</div>
						</td>
					</tr>
					<tr>
						<td class="border-none" colspan="5"></td>
						<td class="border-none text-right">Total</td>
						<td>
							<div class="float-left">
								Rp.
							</div>
							<div class="float-right">
								{{ number_format($print_header->po_total_net,2,',','.') }}
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="text-left" style="margin-top: -40px;font-size: 12px;width: 40%;">
				1. Please send two copies of your invoice.<br>
				2. Enter this order in accordance with prices, terms, delivery method, and specification listed above.<br>
				3. Please notify US immediately if you are unable to ship as specified.<br>
				4. Send all correspondence to:
			</div>
			<div class="float-left text-left" style="font-size: 12px;margin-top: 5px;width: 25%;">
				PT. REJA ATON ENERGI<br>
				JUANDA REGENCY, F-9<br>
				SIDOARJO, 61253<br>
				62-31-99682814<br>
				atonergi@gmail.com
			</div>
			<div class="float-right text-left" style="width: 40%;font-size: 12px;">
				<table class="border-none" width="100%">
					<thead>
						<tr>
							<th class="border-none"></th>
							<th class="border-none">{{date('d M Y')}}</th>
						</tr>
					</thead>
					<tbody>
						<tr style="border-top: 1px solid black;">
							<td class="border-none">Authorized By</td>
							<td class="border-none">Date</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	window.print()
</script>
</html>
