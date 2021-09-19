<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Currency</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="modal-body">
          <table class="table table_form">
            <tr>
              <td><h5>CODE</h5></td>
              <td width="250">
                <select class="form-control currency" style="width: 250px" name="currency">
                    <option value="0">Select - Currency</option>
                  @foreach ($currency as $val)
                    <option value="{{ $val->cu_code }}">{{ $val->cu_code }}</option>
                  @endforeach
                </select>
              </td>
              <td>
                <input style="font-size: 15px" type="text" readonly="" class="form-control symbol" name="">
              </td>
              
            </tr>
            <tr>
              <td ><h5>Currency Name</h5></td>
              <td style="font-size: 15px" colspan="2"><input type="text" readonly="" name="country" class="country form-control"></td>
            </tr>
            <tr>
              <td ><h5>Value</h5></td>
              <td style="font-size: 15px" colspan="2"><input type="text" name="value" class="value form-control"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <div id="ganti_tombol">
            <button class="btn btn-primary simpan" type="button" >Save Data</button>
          </div>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
