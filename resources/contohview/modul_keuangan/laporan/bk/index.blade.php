<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laporan Bukti Kas Keluar</title>
        
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/bootstrap_4_1_3/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/font-awesome_4_7_0/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
  		<link rel="stylesheet" type="text/css" href="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">

		<style>

			body{
				background: rgba(0,0,0, 0.5);
			}

			/*.bs-datepicker-container { z-index: 3000; }*/

			.lds-dual-ring {
			  display: inline-block;
			  width: 64px;
			  height: 64px;
			}
			.lds-dual-ring:after {
			  content: " ";
			  display: block;
			  width: 46px;
			  height: 46px;
			  margin: 1px;
			  border-radius: 50%;
			  border: 5px solid #dfc;
			  border-color: #dfc transparent #dfc transparent;
			  animation: lds-dual-ring 1.2s linear infinite;
			}
			@keyframes lds-dual-ring {
			  0% {
			    transform: rotate(0deg);
			  }
			  100% {
			    transform: rotate(360deg);
			  }
			}

		    .navbar-brand {
		    	padding-left: 30px;
		    }

		    .navbar-nav {
		      flex-direction: row;
		      padding-right: 40px; 
		    }
		    
		    .nav-link {
		      padding-right: .5rem !important;
		      padding-left: .5rem !important;
		    }
		    
		    /* Fixes dropdown menus placed on the right side */
		    .ml-auto .dropdown-menu {
		      left: auto !important;
		      right: 0px;
		    }

		    .nav-item{
		    	color: white;
		    }

		    .navbar-nav li{
		        border-left: 1px solid rgba(255, 255, 255, 0.1);
		        padding: 0px 25px;
		        cursor: pointer;
		    }

		    .navbar-nav li:last-child{
		    	border-right: 1px solid rgba(255, 255, 255, 0.1);
		    }

		    .ctn-nav {
		    	background: rgba(0,0,0, 0.7);
		    	position: fixed;
		    	bottom: 1.5em;
		    	z-index: 1000;
		    	font-size: 10pt;
		    	box-shadow: 0px 0px 10px #aaa;
		    	border-radius: 10px
		    }

		    #title-table{
		    	padding: 0px;
		    }

		    .table-data{
		    	font-size: 9pt;
		    	color: #2E2E2E;
		    }

		    .table-data td, #table-data th {
		    	padding: 5px 10px;
		    	border: 1px solid #2E2E2E;
		    }

		    /*.table-data td.appropriate:first-child{
		    	border: 1px solid green;
		    }*/

		    .table-data td.head{
		    	border: 1px solid white;
		    	background: #0099CC;
		    	color: white;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    .table-data td.sub-head{
		    	border: 1px solid #0099CC;
		    	color: #333;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #contentnya{
	          width: 65%;
	          padding: 0px 20px;
	          background: white;
	          min-height: 700px;
	          border-radius: 2px;
	          margin: 0 auto;
	        }

		</style>


		<style type="text/css" media="print">
          @page { size: portrait; }
          nav{
            display: none;
          }

          .ctn-nav{
            display: none;
          }

          #contentnya{
          	width: 100%;
          	padding: 0px;
          	margin-top: -80px;
          }

          .table-data th, .table-data td{
             -webkit-print-color-adjust: exact;
          }

          #table-data td.not-same{
             color: red !important;
             -webkit-print-color-adjust: exact;
          }

          .page-break { display: block; page-break-before: always; }
      	</style>
	</head>

	<body>
		<div id="vue-element">
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="box-shadow: 0px 5px 10px #555;">
			    <a class="navbar-brand" href="{{ url('/') }}">{{ jurnal()->companyName }}</a>

			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>

			    <div class="collapse navbar-collapse" id="navbarCollapse">
			      <ul class="navbar-nav ml-auto">

			      	<li class="nav-item">
			      	  <a href="{{ route('laporan.keuangan.index') }}" style="color: #ffbb33;">
			          	<i class="fa fa-backward" title="Kembali Ke Menu Laporan"></i>
			          </a>
			        </li>

			        <li class="nav-item">
			          	<i class="fa fa-print" title="Print Laporan" @click="print"></i>
			        </li>

			        {{-- <li class="nav-item dropdown" title="Download Laporan">
			          	<i class="fa fa-download" id="dropdownMenuButton" data-toggle="dropdown"></i>

			            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#" style="font-size: 10pt;" @click='downloadPdf'>
						    	<i class="fa fa-file-pdf-o" style="font-weight: bold;"></i> &nbsp; Download PDF
						    </a>

						    <div class="dropdown-divider"></div>

						    <a class="dropdown-item" href="#" style="font-size: 10pt;" @click='downloadExcel'>
						    	<i class="fa fa-file-excel-o" style="font-weight: bold;"></i> &nbsp; Download Excel
						    </a>
					    </div>
			        </li> --}}

			        <li class="nav-item">
			          <i class="fa fa-sliders" title="Pengaturan Laporan" @click="showSetting"></i>
			        </li>

			      </ul>
			    </div>
			</nav>

			<div class="container-fluid" style="background: none; margin-top: 70px; padding: 10px 30px;">
				<div id="contentnya" style="padding-top: 20px;">

					<?php 
						$tanggal_1 = date('d/m/Y', strtotime($_GET['d1']));
					?>					

					{{-- Judul Kop --}}

						<table width="100%" class="table-data" border="0" style="font-size: 9pt;">
				          <thead>
				            <tr>
				            	<td rowspan="2" style="vertical-align: top;">Dibayarkan Kepada :</td>
				            	<td width="30%" rowspan="2" style="font-size: 12pt; font-weight: bold; text-align: center;">
				            		{{ ($_GET['type'] == 'bkk') ? 'Bukti Kas Keluar' : 'Bukti Kas Masuk' }}
				            	</td>
				            	<td width="35%">Nomor &nbsp;: &nbsp;<b>{{ $nomor }}</b></td>
				            </tr>

				            <tr>
				            	<td>Tanggal : &nbsp;<b>{{ date('d/m/Y', strtotime($tgl)) }}</b></td>
				            </tr>
				          </thead>
				        </table>

				    {{-- End Judul Kop --}}

					<table width="100%" class="table-data" border="0" style="font-size: 9pt;">
			          <thead>
			            <tr>
			            	<td class="appropriate" width="18%" style="border-left: 1px solid #2E2E2E; border-right: 1px solid #2E2E2E; border-bottom: 0px; border-top: 0px;"></td>
			            	<td width="18%" style="background: #4B515D; color: white; border-right: 1px solid white; text-align: center;">
			            		Perkiraan
			            	</td>
			            	<td width="46%" style="background: #4B515D; color: white; border-right: 1px solid white; text-align: center;">
			            		Uraian
			            	</td>
			            	<td width="18%" style="background: #4B515D; color: white; text-align: center;">
			            		Jumlah
			            	</td>
			            </tr>

			            <?php $tot = 0; ?>
			            	@foreach($data as $key => $detail)
			            <tr>			            	
				            	<td class="appropriate" width="18%" style="border-left: 1px solid #2E2E2E; border-right: 1px solid #2E2E2E; border-bottom: 0px; border-top: 0px;"></td>
				            	<td width="18%" style="background: rgba(0,0,0,0.1); color: #333; text-align: center;">
				            		{{ $detail->ak_nomor }}
				            	</td>
				            	<td width="46%" style="background: white; color: #333; text-align: left;">
				            		{{ $detail->jr_keterangan }}
				            	</td>
				            	<td width="18%" style="background: rgba(0,0,0,0.1); color: #333; text-align: right;">
				            		{{ number_format($detail->jrdt_value, 2) }}
				            	</td>
				            	
			            </tr>
			            <?php $tot += $detail->jrdt_value ?>
				            @endforeach
			          </thead>

			          <tfoot>
			          	<tr>
			            	<td class="appropriate" width="18%" style="border-left: 1px solid #2E2E2E; border-right: 1px solid #2E2E2E; border-bottom: 0px; border-top: 0px;"></td>
			            	<td width="18%" style="background: rgba(0,0,0,0.1); color: #333; text-align: center;">
			            		&nbsp;
			            	</td>
			            	<td width="46%" style="background: white; color: #333; text-align: center;">
			            		&nbsp;
			            	</td>
			            	<td width="18%" style="background: rgba(0,0,0,0.1); color: #333; text-align: right;">
			            		&nbsp;
			            	</td>
			            </tr>

			          	<tr>
			            	<td class="appropriate" width="18%" style="text-align: center;">Terbilang</td>
			            	<td colspan="2" width="18%" style="background: rgba(0,0,0,0.1); color: #333; text-align: left;">
			            		{{ penyebut($tot) }}
			            	</td>
			            	<td width="18%" style="background: white; color: #333; text-align: right;">
			            		{{ number_format($tot, 2) }}
			            	</td>
			            </tr>
			          </tfoot>
			        </table>

			        {{-- bootopm Kop --}}

						<table width="100%" class="table-data" border="0" style="font-size: 9pt; margin-top: 10px">
				          <thead>
				            <tr>
				            	<td width="40%" style="vertical-align: top; font-weight: bold; border-bottom: 0px;">Catatan :</td>
				            	<td width="15%" style="background: #4B515D; color: white; border-right: 1px solid white; text-align: center; font-size: 8pt;"> Pembukuan </td>
				            	<td width="15%" style="background: #4B515D; color: white; border-right: 1px solid white; text-align: center; font-size: 8pt;"> Mengetahui </td>
				            	<td width="15%" style="background: #4B515D; color: white; border-right: 1px solid white; text-align: center; font-size: 8pt;"> Kasir </td>
				            	<td width="15%" style="background: #4B515D; color: white; border-right: 1px solid #2e2e2e; text-align: center; font-size: 8pt;"> Penerima </td>
				            </tr>

				            <tr>
				            	<td width="40%" style="vertical-align: top; font-weight: bold; border-top: 0px;"></td>
				            	<td width="15%" style="background: white; color: white; border-right: 1px solid #2e2e2e; text-align: center; font-size: 8pt; padding-bottom: 50px;"> </td>
				            	<td width="15%" style="background: white; color: white; border-right: 1px solid #2e2e2e; text-align: center; font-size: 8pt;"> </td>
				            	<td width="15%" style="background: white; color: white; border-right: 1px solid #2e2e2e; text-align: center; font-size: 8pt;"> </td>
				            	<td width="15%" style="background: white; color: white; border-right: 1px solid #2e2e2e; text-align: center; font-size: 8pt;"> </td>
				            </tr>
				          </thead>
				        </table>

				    {{-- bootopm Kop --}}
				</div>
			</div>

	        <div class="ez-popup" id="setting-popup">
	            <div class="layout" style="width: 35%; min-height: 150px;">
	                <div class="top-popup" style="background: none;">
	                    <span class="title">
	                        Setting Laporan Bukti Kas
	                    </span>

	                    <span class="close"><i class="fa fa-times" style="font-size: 12pt; color: #CC0000"></i></span>
	                </div>
	                
	                <div class="content-popup">
	                	<form id="form-setting" method="get" action="{{ route('laporan.keuangan.bk') }}">
	                	<input type="hidden" readonly name="_token" value="{{ csrf_token() }}">
	                    <div class="col-md-12">

	                    	<div class="row mt-form">
	                            <div class="col-md-4">
	                                <label class="modul-keuangan">Type Bukti Kas</label>
	                            </div>

	                            <div class="col-md-7">
	                            	<select name="type" id="type" class="form-control" style="font-size: 9pt">
	                            		<option value="bkk">Bukti Kas Keluar</option>
	                            		<option value="bkm">Bukti Kas Masuk</option>
	                            	</select>
	                            </div>

	                        </div>

	                        <div class="row mt-form">
	                            <div class="col-md-4">
	                                <label class="modul-keuangan">Pilih Tanggal</label>
	                            </div>

	                            <div class="col-md-7">
                    				<vue-datepicker :name="'d1'" :id="'d1'" :title="'Tidak Boleh Kosong'" :readonly="true" :placeholder="'Pilih Tanggal'" :format="'dd-mm-yyyy'" :styles="'font-size: 9pt;'"></vue-datepicker>
	                            </div>
	                        </div>

	                    </div>

	                    <div class="col-md-12" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px;">
	                    	<div class="row">
		                    	<div class="col-md-4 offset-8 text-right" style="padding: 0px;">
		                    		<button type="submit" class="btn btn-info btn-sm">Proses</button>
		                    	</div>
		                    </div>
	                    </div>

	                    </form>
	                </div>
	            </div>
	        </div>

	        <iframe style="display: none;" id='pdfIframe' src=''/></iframe>
		</div>

		<script src="{{ asset('modul_keuangan/js/jquery_3_3_1.min.js') }}"></script>
		<script src="{{ asset('modul_keuangan/bootstrap_4_1_3/js/bootstrap.min.js') }}"></script>
		<script src="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.js')}}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/select2/dist/js/select2.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>

    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/vue_2_x.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/select.component.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datepicker.component.js') }}"></script>

    	<script type="text/javascript">

			var vue = new Vue({
				el: '#vue-element',
				data: {

				},

				mounted: function(){
					$('#d1').val('{{ date('d-m-Y', strtotime($tgl)) }}');
					$('#type').val('{{ $_GET['type'] }}');
				},

				methods: {
					showSetting: function(evt){
						evt.preventDefault();
	                	evt.stopImmediatePropagation();

	                	$('#setting-popup').ezPopup('show');
					},

					print: function(evt){
	            		evt.preventDefault();
	            		evt.stopImmediatePropagation();

	            		$.toast({
                            text: "Sedang Mencetak Laporan",
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'info',
                            hideAfter: 8000,
                            showHideTransition: 'slide',
                            allowToastClose: false,
                            stack: false
                        });

	            		window.print();

	            		// $('#pdfIframe').attr('src', '{{route('laporan.keuangan.laba_rugi.print')}}?'+that.url.searchParams)
	            	},

	            	prosesLaporan: function(){
	            		alert('okee');
	            	}
				}
			})

    	</script>
	</body>
</html>
