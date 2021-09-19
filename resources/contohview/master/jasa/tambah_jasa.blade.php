<!-- Modal -->
<div id="tambah_jasa" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Jasa</h4>
        <button type="button" class="close" onclick="reset()" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="t55am1">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Services Name</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="hidden" name="i_id" id="i_id">
                <input type="text" class="form-control form-control-sm huruf_besar reset" name="i_name" id="i_name">
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Price</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control hanya_angka form-control-sm reset" min="1" name="i_price" id="i_price">
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Unit</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm reset" name="i_unit" id="i_unit">
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Description</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <textarea class="form-control form-control-sm reset" name="i_description" id="i_description"></textarea>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>Akun</label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control" name="akun" id="akun">
                  <option value="">--Select Type--</option>
                  @foreach ($akun as $key => $value)
                    <option value="{{$value->ak_id}}">{{$value->ak_nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button class="btn btn-primary simpan_jasa" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="reset()">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
