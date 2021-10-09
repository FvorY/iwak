<!-- Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Lelang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">
          Mohon isi semua data yang bertanda <span style="color:red;">*</span>
        </div>
        <div class="row">
          <table class="table table_modalupdate">

          {{-- <tr>
            <td>Pilih User</td>
            <td>
              <input type="text" class="form-control form-control-md autocomplete pilihuser" name="pilihuser">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr> --}}
          <tr>
            <td>Nama Produk </td>
            <td>
              <b class="modal-title namaproduk"></b>
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Harga Awal <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext rp hargawal" name="price">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="update" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
