<!-- Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Jabatan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_edit">
         <input type="hidden" name="id">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Divisi</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="from-control select2" name="divisi" id="divisiedit" disabled>
                <option value=""> - Pilih - </option>
                @foreach ($divisi as $key => $value)
                  <option value="{{$value->c_id}}">{{$value->c_divisi}}</option>
                @endforeach
              </select>
            </div>
          </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Nama Jabatan</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control" name="namajabatan" id="namajabatanedit">
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" id="edit_data">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>
