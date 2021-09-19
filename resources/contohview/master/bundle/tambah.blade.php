
<!-- Modal -->
<form id="form-save">
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Bundle Item</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">


            <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Bundle Name</label>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group ">
                  <input type="text"  class="form-control huruf_besar form-control-sm ib_name" name="ib_name">
              </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">

                  <label class="tebal">Price (Factory)</label>

            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group disabled">
                  <input type="text" readonly=""  class="form-control form-control-sm right ib_price" name="ib_price" >
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-12">

                  <label class="tebal">Keterangan</label>

            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group">
                  <input type="text"  class="form-control form-control-sm huruf_besar  keterangan" name="keterangan" >
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-12">

                  <label class="tebal">Sell Price List</label>

            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group">
                  <input type="text"  class="form-control form-control-sm right sell_price" name="sell_price" value="0">
              </div>
            </div>


            <div class="col-md-3 col-sm-4 col-xs-12">
                <label class="tebal">Currency</label>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12 cur_div">
              <div class="form-group">
                  <select class="form-control m_currency" name="m_currency">
                    @foreach($currency as $val)
                      @if($val->cu_code == 'IDR')
                        <option selected="" value="{{$val->cu_code}}" data-nilai="{{ $val->cu_value }}">{{$val->cu_code}} || {{$val->cu_name}}</option>
                      @endif
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-12">
                  <label class="tebal">Lower Price</label>
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group">
                  <input type="text"  class="form-control form-control-sm right lower_price" name="lower_price" value="0">
              </div>
            </div>

        </div>
        <div class="row" style="border-top: 1px solid #98c3d1;padding-top: 15px;margin-top: 15px;margin-bottom: 15px;border-bottom: 1px solid #98c3d1;">
          <div class="col-md-1 col-sm-2 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-4 col-sm-10 col-xs-10">
            <div class="form-group">
              <select class="form-control form-control-sm" name="" id="bund_kodeitem">
                  <option selected="" value="">- Pilih -</option>
                  @foreach ($item as $e)
                    <option value="{{ $e->i_code }}" data-harga="{{ $e->i_price }}" data-name="{{ $e->i_name }}" data-currency="{{ $e->i_price_currency }}">{{ $e->i_code }} - {{ $e->i_name }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-1 col-sm-8 col-xs-2" style="width: 20%!important">
            <div class="form-group">
              <input style="text-align: center; width: 60%" type="text" readonly="" class="form-control form-control-sm  right"  id="currency">
            </div>
          </div>
          <div class="col-md-1 col-sm-1 col-xs-1">
            <label>Harga</label>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="" readonly="" placeholder="harga" id="bund_item">
            </div>
          </div>
          <div class="col-md-1 col-sm-1 col-xs-1">
            <label>Qty</label>
          </div>
          <div class="col-md-1 col-sm-2 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm right" name="bund_qty" id="bund_qty">
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered  gogo"  cellspacing="0" id="bundle_table" width="100%">

            <thead class="bg-gradient-info">
              <tr>
                <th width="20%">Item Code</th>
                <th width="20%">Item Name</th>
                <th width="5%">Qty</th>
                <th width="5%">Unit</th>
                <th width="30%">Price</th>
                <th width="30%">Total Price</th>
                <th width="1%">Action</th>
              </tr>
            </thead>
            <tbody id="edit_rep">

            </tbody>

          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" id="save_data" >Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</form>
