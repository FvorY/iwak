<!-- Modal -->
<div id="lihatbank" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">List Data Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="filter">
                  <option disabled selected>--Pilih Filter--</option>
                  <option value="hrd">Nomor Bukti</option>
                  <option value="keu">Tanggal Transaksi</option>
                  <option value="snm">Nama Transaksi</option>
                  <option value="prd">Nominal Transaksi</option>
                </select>
              </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="" placeholder="Pencarian...">
              </div>
            </div>
            <div class=" col-md-1 col-sm-12">
              <span class="input-group-append pull-right">
                <button type="button" class="btn btn-primary btn-sm icon-btn ml-2">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                        
              <div class="table-responsive ">
                <table class="table table-hover" cellspacing="0" >
                  <thead class="bg-gradient-info">
                    <tr>
                      <th >-</th>
                      <th >No. Bukti</th>
                      <th >Tgl. Transaksi</th>
                      <th >Nama Transaksi</th>
                      <th >Nominal Transaksi</th>
                    </tr>
                  </thead>
                  <tbody class="center">
                    <tr>
                      <!-- <td>-</td>
                      <td>#1</td>
                      <td>12-12-2018</td>
                      <td>Kas-kas an</td>
                      <td>
                        <div class="pull-left">Rp.</div>
                        <div class="pull-right">1.430.000,00</div>
                      </td> -->
                      <td colspan="5">Data tidak ditemukan</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
            </div>

            <div class="col-md-12 col-sm-6 col-xs-12">
              <label>Berhasil Menemukan 0 Data, dari Total Data 0</label>
            </div>
            

          
          

         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <!-- <button class="btn btn-primary" type="button">Process</button> -->
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>