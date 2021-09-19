<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Pegawai</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>ID Employee</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="mp_id" readonly="">
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <label>NIK</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="mp_nik">
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Employee Name</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="mp_name">
            </div>
          </div>


           <div class="col-md-6 col-sm-6 col-xs-12">
            <label>E-mail</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="email" class="form-control" name="mp_email">
            </div>
          </div>
           <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Address</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <textarea class="form-control" name="mp_address" id="mp_address"></textarea>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Position</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12" >
            <div class="form-group">
              <select class="form-control" name="mp_position">
                <option value="">- Pilih -</option>
                @foreach ($jabatan as $key => $value)
                  <option value="{{$value->c_id}}">{{$value->c_posisi}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Education</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="form-control" name="mp_pendidikan">
                <option value="">- Pilih -</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="SMK">SMK</option>
                <option value="D1">D1</option>
                <option value="D2">D2</option>
                <option value="D3">D3</option>
                <option value="S1">S1</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Employee Status</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="form-control" name="mp_status">
                <option value="">- Pilih -</option>
                <option value="Lajang">Lajang</option>
                <option value="Menikah">Menikah</option>
              </select>
            </div>
          </div>

         </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" id="save_data">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
