<!-- Modal -->
<div id="pay" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Upload Bukti Transfer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nama Toko</td>
            <td>
              <b id="namatoko">  </b>
              <input type="hidden" id="id_transaction" name="id" value="">
            </td>
          </tr>
          <tr>
            <td>Nomor Rekening</td>
            <td>
              <b id="nomor_rekening">  </b>
            </td>
          </tr>
          <tr>
            <td>Nama Bank</td>
            <td>
              <b id="bank">  </b>
            </td>
          </tr>
          <tr>
            <td>Image</td>
            <td>
              <input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">
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
          <button class="btn btn-primary" id="simpan" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
