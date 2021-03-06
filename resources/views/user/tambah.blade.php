<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
            <div class="alert alert-warning" role="alert">
            Please fill in all the data marked with <span style="color:red;">*</span>
            </div>
          <tr>
            <td>Fullname <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext fullname" name="fullname">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Account number</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nomor_rekening" name="nomor_rekening">
            </td>
          </tr>
          <tr>
            <td>Bank Name</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext bank" name="bank">
            </td>
          </tr>
          <tr>
            <td>Email <span style="color:red;">*</span></td>
            <td>
              <input type="email" class="form-control form-control-sm inputtext email" name="email">
            </td>
          </tr>
          <tr>
            <td>Password <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext password" name="password">
            </td>
          </tr>
          <tr>
            <td>Level <span style="color:red;">*</span></td>
            <td>
              <select class="form-control role" name="role">
                <option value="" selected>- Pilih -</option>
                <option value="admin"> Admin </option>
                <option value="member"> Member </option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Phone <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext phone" name="phone">
            </td>
          </tr>
          <tr>
            <td>Address <span style="color:red;">*</span></td>
            <td>
              <textarea class="form-control form-control-sm address" name="address" rows="8" cols="80"></textarea>
              <div class="alert alert-warning" role="alert">
              This address will also be used for the shop address (Format: street name and house number (space) sub-district (space) city)
              </div>
            </td>
          </tr>
          <tr>
            <td>Gender <span style="color:red;">*</span></td>
            <td>
              <select class="form-control gender" name="gender">
                <option value="" selected>- Choose -</option>
                <option value="L"> Male </option>
                <option value="P"> Female </option>
              </select>
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
