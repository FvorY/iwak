<!-- Modal -->
<div id="detailpesanan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Detail Pesanan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">
          Detail pesanan ini sudah termasuk diskon pada pembelian, jika diskon pada produk berlaku <span style="color:red;">*</span>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <p style="margin-left: 10px; margin-top: 20px;">Alamat Pengiriman : <span id="alamatpengiriman">Rp. 0</span></p>
        </div>

        <div class="row">
          <table class="table table_status table-hover " style="width: 100% !important">
              <thead class="bg-gradient-info">
                <tr>
                  <th>No</th>
                  <th>Produk</th>
                  <th>QTY</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>

              <tbody id="bodydetail">

              </tbody>


          </table>

          <div class="col-md-12 col-sm-12 col-xs-12">
            <h4 style="margin-left: 10px; margin-top: 20px;">Subtotal : <span id="subtotal">Rp. 0</span></h4>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
