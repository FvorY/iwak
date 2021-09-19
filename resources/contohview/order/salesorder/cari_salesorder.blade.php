<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Sales Order</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          
          <div class="table-responsive" style="margin-bottom: 15px;">
            <table class="table table-hover data-table" cellspacing="0">
              <thead class="bg-gradient-info">
                <tr>
                  <th>S.O.#</th>
                  <th>S.I.#</th>
                  <th>Customer</th>
                  <th>Total Bill</th>
                  <th>DP</th>
                  <th>Total Balance</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>A002</td>
                  <td>I001</td>
                  <td>Alpha</td>
                  <td align="left"><p style="float: left;">Rp.</p> 2.000.000,00</td>
                  <td align="left"><p style="float: left;">Rp.</p> 500.000,00</td>
                  <td align="left"><p style="float: left;">Rp.</p> 1.500.000,00</td>
                  <td>
                    <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox">
                          <i class="input-helper"></i></label>
                        </div>
                        
                  </td>
                </tr>
                <tr>
                  <td>A002</td>
                  <td>I002</td>
                  <td>Bravo</td>
                  <td align="left"><p style="float: left;">Rp.</p> 2.000.000,00</td>
                  <td align="left"><p style="float: left;">Rp.</p> 500.000,00</td>
                  <td align="left"><p style="float: left;">Rp.</p> 1.500.000,00</td>
                  <td>
                    <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox">
                          <i class="input-helper"></i></label></div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          

         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="{{url('order/salesorder/s_order/detail_salesorder')}}">Process</a>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>