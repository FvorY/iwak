<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Billing Master Form</h4>
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
            <td>Type</td>
            <td>
              <select class="form-control form-control-sm" name="type" id="type" style="width: 100%;">
                  <option value=""> -- Select Type -- </option>
                  @foreach ($type as $key => $value)
                    <option value="{{$value->type_id}}">{{$value->type_nama}}</option>
                  @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td>Repeat</td>
            <td>
              <select class="form-control form-control-sm" name="looptype" id="looptype" style="width: 100%;">
                  <option value=""> -- Repeat Select -- </option>
                  @foreach ($looptype as $key => $value)
                    <option value="{{$value->looptype_id}}">{{$value->looptype_name}}</option>
                  @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td>Auto Debit</td>
            <td>
              <select class="form-control form-control-sm" name="autodebit" id="autodebit" style="width: 100%;">
                  <option value=""> -- Repeat Select -- </option>
                  <option value="Y"> Yes </option>
                  <option value="N"> No </option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Due Date</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext datepicker" name="date" value="{{Carbon\Carbon::now()->format('d-m-Y')}}">
            </td>
          </tr>
          <tr>
            <td>Note</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext note" name="note">
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
