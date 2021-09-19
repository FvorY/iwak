<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Pembayaran Deposit</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          
          <div class="table-responsive" style="margin-bottom: 15px;">
            <table class="table table-hover data-table" cellspacing="0">
              <thead class="bg-gradient-info">
                <tr>
                  <th>Q.O.#</th>
                  <th>Customer</th>
                  <th>Total Bill</th>
                  <th>DP</th>
                  <th>Total Balance</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>A002</td>
                  <td>Alpha</td>
                  <td align="left">Rp. 700.000,-</td>
                  <td align="left">Rp. 0,-</td>
                  <td align="left">Rp. 700.000,00</td>
                </tr>
              </tbody>
            </table>
          </div>

          

         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="{{url('order/pembayarandeposit/pembayarandeposit/detail_pembayarandeposit')}}">Process</a>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>