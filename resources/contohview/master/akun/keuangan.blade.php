@extends('main')
@section('content')




<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">	
    	<nav aria-label="breadcrumb" role="navigation">
    		<ol class="breadcrumb bg-info">
    			<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
    			<li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active" aria-current="page">Master Data Akun Keuangan</li>
    			<li class="breadcrumb-item active" aria-current="page">Master Data Akun Keuangan</li>
    		</ol>
    	</nav>
    </div>

  	<div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
        	<div class="col-md-12 col-xs-12 col-xs-12">
              <div class="panel-default">
                <a data-toggle="collapse" href="#collapse1">
                <div class="panel-heading bg-gradient-primary panel-bg panel-top" style="border: 1px solid #e5e5e5;color:white;padding-left: 15px;">
                  <h4 class="panel-title">
                    Harta
                  </h4>
                </div>
                </a>
                <div id="collapse1" class="panel-collapse collapse">
                  <div class="panel-body" style="border: 1px solid #e5e5e5;">
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                      <thead class="bg-gradient-info">
                        <tr>
                          <th width="15%">Kode Akun</th>
                          <th width="20%">Nama Akun</th>
                          <th>Pembukaan Akun</th>
                          <th width="15%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="padding-left: 20px;">1010000</td>
                          <td>Harta Lancar</td>
                          <td align="right">0,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 40px;">1010100</td>
                          <td>Kas &amp; Setara Kas</td>
                          <td align="right">0,00</td>
                          <td align="center">
                           <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 60px;">1010101</td>
                          <td>Kas Pusat</td>
                          <td align="right">123.450,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>                                    </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 60px;">1010102</td>
                          <td>Kas BCA</td>
                          <td align="right">1.230,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
          
              <div class="panel-default">
                <a data-toggle="collapse" href="#collapse2" style="width: 100%;">
                <div class="panel-heading bg-gradient-primary panel-bg" style="border: 1px solid #e5e5e5;color:white;padding-left: 15px;">
                  <h4 class="panel-title">
                    Kewajiban
                  </h4>
                </div>
                </a>
                <div id="collapse2" class="panel-collapse collapse">
                  <div class="panel-body" style="border: 1px solid #e5e5e5;">
                    <div class="table-responsive">
                     <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                      <thead class="bg-gradient-info">
                        <tr>
                          <th width="15%">Kode Akun</th>
                          <th width="20%">Nama Akun</th>
                          <th>Pembukaan Akun</th>
                          <th width="15%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="padding-left: 20px;">2010000</td>
                          <td>Kewajiban Jangka Pendek</td>
                          <td align="right">0,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 40px;">2010100</td>
                          <td>Hutang Non Usaha</td>
                          <td align="right">0,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 60px;">2010101</td>
                          <td>Hutang ke Pihak III</td>
                          <td align="right">123.450,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-left: 60px;">2010102</td>
                          <td>Hutang Pajak</td>
                          <td align="right">1.230,00</td>
                          <td align="center">
                            <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                          </td>
                        </tr>
                      </tbody>
                     </table>
                    </div>
                  </div>
                </div>
              </div>
          
              <div class="panel-default">
              <a data-toggle="collapse" href="#collapse3" style="width: 100%;">
                <div class="panel-heading bg-gradient-primary panel-bg" style="border: 1px solid #e5e5e5;color:white;padding-left: 15px;">
                  <h4 class="panel-title">
                      Modal
                  </h4>
                </div>
              </a>
                <div id="collapse3" class="panel-collapse collapse">
                  <div class="panel-body" style="border: 1px solid #e5e5e5;">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-gradient-info">
                          <tr>
                            <th width="15%">Kode Akun</th>
                            <th width="20%">Nama Akun</th>
                            <th>Pembukaan Akun</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="padding-left: 20px;">3010000</td>
                            <td>Modal Disetor</td>
                            <td align="right">0,00</td>
                            <td align="center">
                              <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 40px;">3010100</td>
                            <td>Modal Bapak Muhammad</td>
                            <td align="right">0,00</td>
                            <td align="center">
                              <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 40px;">3010200</td>
                            <td>Modal Bapak A</td>
                            <td align="right">123.450,00</td>
                            <td align="center">
                              <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-left: 20px;">3020000</td>
                            <td>Laba</td>
                            <td align="right">1.230,00</td>
                            <td align="center">
                              <div class=""> 
                       <a href="#" class="btn btn-info btn-xs" title="Tambah Sub Akun"><i class="fa fa-plus"></i></a>   
                       <a href="#" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                       <a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
                      </div>  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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