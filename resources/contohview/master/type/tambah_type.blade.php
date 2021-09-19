<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Tipe Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
          <form class="row" id="simpan_tipe">  
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Type Code</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input style="text-transform: uppercase;" type="text" class="form-control form-control-sm" name="t_code">
              </div>
            </div>
          
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Type Name</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input style="text-transform: uppercase;" type="text" class="form-control form-control-sm" name="t_name">
              </div>
            </div>
            <input type="hidden" name="it_codex">
          </form>

         
      </div>
      <div class="modal-footer">
        <div id="ganti_tombol">
          <button class="btn btn-primary" type="button" onclick="simpan()">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>