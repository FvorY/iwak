<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Barang Keluar</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">


            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Item Out Code</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="">
              </div>
            </div>
            <div class="col-md-6 col-sm-0 col-xs-0">
              <!-- Empty -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Date</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm datepicker" readonly name="">
              </div>
            </div>
            <div class="col-md-6 col-sm-0 col-xs-0">
              <!-- Empty -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Information</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <textarea class="form-control"></textarea>
              </div>
            </div>
            <div class="col-md-6 col-sm-0 col-xs-0">
              <!-- Empty -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label title="Tipe Pengeluaran">Expenditures Type</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm">
                  <option>--Select--</option>
                  <option>Penjualan</option>
                  <option>Service</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-sm-0 col-xs-0">
              <!-- Empty -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label title="Nama Peminta">Request Name</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="">
              </div>
            </div>
            <div class="col-md-6 col-sm-0 col-xs-0">
              <!-- Empty -->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label title="Nama Peminta">Expiration Date</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm datepicker" name="" readonly="" value="{{date('d-m-Y', strtotime('+2 week'))}}">
              </div>
            </div>


        </div>
        <div class="row" style="border-top:1px solid #e6ecf5; padding-top:15px;">

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Amount</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="number" class="form-control-sm form-control" name="">
            </div>
          </div>


        </div>

        <div class="table-responsive">
          <table class="table ">
            <thead class="bg-gradient-info">
              <tr>
                <th>Item Name</th>
                <th>Stock Warehouse</th>
                <th>Amount</th>
                <th>Unit</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>

      </div> <!-- End div modal-content -->
      <div class="modal-footer">
        <button class="btn btn-primary" type="button">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
