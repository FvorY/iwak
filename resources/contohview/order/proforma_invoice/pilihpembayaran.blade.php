<!-- Modal -->
<div id="pilihpembayaran" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Log Payment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="row log">

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Payment Type</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control form-control-sm" value="Payment" readonly="" name="payment_type">
              </select>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Paid to Account</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                <select class="form-control form-control-sm" name="akun">
                  <option @if ($data->po_type == 'Cash')
                    selected="" 
                  @endif value="Cash">Cash</option>
                  <option @if ($data->po_type == 'Deposit')
                    selected="" 
                  @endif value="Deposit">Deposit</option>
                </select>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Amount</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control-sm form-control" id="amount" name="amount">
            </div>
          </div>
          
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Date</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control-sm form-control" id="" readonly="" value="{{date('d-m-Y')}}" name="date">
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Payment Method</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="pay_method">
                <option @if ($data->po_type == 'tunai')
                  selected="" 
                @endif value="tunai">tunai</option>
                <option @if ($data->po_type == 'Transfer')
                  selected="" 
                @endif value="Transfer">Transfer</option>
              </select>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Reference</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
                  <input value="{{ $data->po_note2 }}" type="text" class="form-control-sm form-control" name="nota2">
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Notes</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input value="{{ $data->po_note }}" type="text" class="form-control-sm form-control" name="nota1">
            </div>
          </div>
         </div>
      </form>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" id="save_detail" onclick="save_detail()" >Save Detail</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>