<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Marketing Team</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Marketing Name</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="d_name">
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Marketing ID</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="d_id" readonly="">
            </div>
          </div>
          
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Phone Number</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="d_tlp">
            </div>
          </div>
           
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>E-mail</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="email" class="form-control form-control-sm" name="d_email">
            </div>
          </div>
          
          
           <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Address</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" name="d_address" id="d_address"></textarea>
            </div>
          </div>
          
         
          
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Information</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" name="d_informasi" id="d_informasi"></textarea>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Marketing Type</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control" name="d_tipe">
                <option selected="" disabled="" value="">- Pilih -</option>
                <option value="spg">spg</option>
                <option value="spb">spb</option>
                <option value="sales">sales</option>
              </select>
            </div>
          </div>
         </div>
         <input type="hidden" name="kode_old">
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