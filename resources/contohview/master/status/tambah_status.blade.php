<!-- Modal -->
<div id="tambah_status" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Status</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_status">
          <tr>
            <td>Status Name</td>
            <td>
              <input type="text" class="form-control form-control-sm name" name="name">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Status Color</td>
            <td>
              <select class="form-control form-control-sm" name="status" id="i_status_color" style="width: 100%;">                
                  <option value="0">--Select Status--</option>
                  <option value="primary">Primary</option>                
                  <option value="secondary">Secondary</option>                
                  <option value="success">Success</option>                
                  <option value="info">Info</option>                
                  <option value="warning">Warning</option>                
                  <option value="danger">Danger</option>                
              </select>
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary simpan_status" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>