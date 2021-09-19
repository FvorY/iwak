<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Uang Keluar</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nominal</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nominal" name="nominal">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Note</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext note" name="note">
            </td>
          </tr>
          <tr>
            <td>Date</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext datepicker" name="date" value="{{Carbon\Carbon::now()->format('d-m-Y')}}">
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
