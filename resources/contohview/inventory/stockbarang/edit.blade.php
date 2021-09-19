<!-- Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Edit Stock Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="modal-body">
          <form id="update_barang">
            <input type="hidden" name="id" id="id">
            <div class="row">
              <div class="col-md-3 col-sm-4 col-xs-12">
                <label class="tebal">Item</label>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <div class="form-group">
                    <select class="select2 itemedit" name="itemedit" onchange="autoitemedit()" id="itemedit">
                        <option value="">~ Select Item ~</option>
                        @foreach ($item as $key => $value)
                          <option value="{{$value->i_code}}">{{$value->i_code}} - {{$value->i_name}}</option>
                        @endforeach
                    </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-xs-12">
                <label class="tebal labelprice" id="labelpriceedit">Price</label>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <div class="form-group">
                    <input type="text" id="priceedit" class="form-control hanya_angka form-control-sm price" name="price" maxlength="20" required="">
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-xs-12">
                <label class="tebal">Unit</label>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <div class="form-group">
                    <input type="text" id="unitedit" class="form-control hanya_angka form-control-sm unit" name="unit" maxlength="20" required="" readonly>
                </div>
              </div>

              <div class="col-md-3 col-sm-4 col-xs-12">
                <label class="tebal">QTY</label>
              </div>
              <div class="col-md-3 col-sm-8 col-xs-12">
                <div class="form-group">
                    <input type="number" id="qtyedit"  class="form-control hanya_angka form-control-sm qty" name="qty" maxlength="20" required="">
                </div>
              </div>
            </div>
          </form>
          </div>
        <div class="modal-footer">
          <div id="ganti_tombol">
            <button class="btn btn-primary" type="button" onclick="update()">Save Data</button>
          </div>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
