<!-- Modal -->
<div id="aruskas" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Setting Arus Kas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          
          <div class="col-md-12 col-sm-12 col-xs-12">
            <label>Jenis Periode</label>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" id="filter">
                <option disabled selected>--Pilih--</option>
                <option value="bulan">Bulan</option>
                <option value="tahun">Tahun</option>
              </select>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <label>Periode Mulai</label>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <div id="datepicker-popup" class="input-group date datepicker alamraya-no-padding">
                  <input type="text" class="form-control" placeholder="dd-mm-yyyy">
                  <div class="input-group-addon alamraya-input-group-addon">
                    <span class="mdi mdi-calendar"></span>
                  </div>
              </div>
            </div>
          </div>
          

        </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>