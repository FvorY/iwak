
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
              <div class="form-group">
                  <input type="text"  class="form-control form-control-sm" name="ib_name">                                    
              </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
              
                  <label class="tebal">Bundle Price</label>
             
            </div>
            <div class="col-md-3 col-sm-8 col-xs-12">
              <div class="form-group">
                  <input type="text"  class="form-control form-control-sm format_money right" name="ib_price" readonly="">                               
              </div>
            </div>

        </div> 
        <div class="row" style="border-top: 1px solid #98c3d1;padding-top: 15px;margin-top: 15px;margin-bottom: 15px;border-bottom: 1px solid #98c3d1;">
          <div class="col-md-2 col-sm-4 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-2 col-sm-8 col-xs-12">
            <div class="form-group">  
              <select class="form-control form-control-sm" name="" id="bund_kodeitem"> 
                  <option selected="" value="">- Pilih -</option>
                  @foreach ($item as $e)
                    <option value="{{ $e->i_code }}" data-harga="{{ $e->i_price }}" data-name="{{ $e->i_name }}">{{ $e->i_code }} - {{ $e->i_name }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-2 col-sm-8 col-xs-12">
            <div class="form-group">  
              <input type="text" class="form-control form-control-sm" name="" readonly="" id="bund_item">
            </div>
          </div>
          <div class="col-md-3 col-sm-4 col-xs-12">
            <label>Qty</label>
          </div>
          <div class="col-md-3 col-sm-8 col-xs-12">
            <div class="form-group">  
              <input type="text" class="form-control form-control-sm format_money right" name="" id="bund_qty">
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered data-table gogo"  cellspacing="0" id="t72bu" width="100%">

            <thead class="bg-gradient-info">
              <tr>
                <th width="20%">Item Code</th>
                <th width="20%">Item Name</th>
                <th width="5%">Qty</th>
                <th width="5%">Unit</th>
                <th width="30%">Item Price</th>
                <th width="1%">Action</th>

              </tr>
            </thead>
            <tbody id="edit_rep">
              @foreach ($data_seq as $e)
              <tr>
                <td>{{ $e->ibd_id }}</td>
              </tr>
              @endforeach
            </tbody>
            
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" onclick="update()">Update Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</form>
