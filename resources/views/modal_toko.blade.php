<!-- Modal -->
<div id="modal_toko" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Buka Toko</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
            <div class="alert alert-warning" role="alert">
              Mohon isi semua data yang bertanda <span style="color:red;">*</span>
            </div>
          {{-- <tr>
            <td>Pilih User</td>
            <td>
              <input type="text" class="form-control form-control-md autocomplete pilihuser" name="pilihuser">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr> --}}
          <tr>
            <td>Nama Toko <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext namatoko" name="namatoko">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Nomor Rekening <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nomor_rekening" name="nomor_rekening">
              <div class="alert alert-warning" role="alert">
                Mohon isi nomor rekening untuk kelancaran pembayaran
              </div>
            </td>
          </tr>
          <tr>
            <td>Nama Bank <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext bank" name="bank">
              <div class="alert alert-warning" role="alert">
                Mohon isi nama bank untuk kelancaran pembayaran
              </div>
            </td>
          </tr>
          <tr>
            <td>Profile Image Toko</td>
            <td>
              <input type="file" class="form-control form-control-sm uploadGambartoko" name="image" accept="image/*">
            </td>
          </tr>
          <tr>
            <td align="center" colspan="2">
              <div class="col-md-8 col-sm-6 col-xs-12 image-holder" id="image-holder">

                {{-- <img src="#" class="thumb-image img-responsive" height="100px" alt="image" style="display: none"> --}}

            </div>
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpantoko" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
