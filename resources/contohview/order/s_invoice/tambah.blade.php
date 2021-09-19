<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Sales Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <label>Customer ID</label>
                    </div>
                    <div class="col-md-5 col-sm-6 col-xs-12">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm">
                        <div class="input-group-append">
                          <button class="btn btn-outline-info btn-sm" type="button" title="Add Customer" data-toggle="modal" data-target="#tambah-customer"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-0 col-xs-0">
                      <!-- empty -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <label>Order By</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="">
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-0 col-xs-0">
                      <!-- empty -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <label>Address</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <textarea class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-0 col-xs-0">
                      <!-- empty -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <label>Delivery Date</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm datepicker" name="">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-4 col-sm-12 col-xs-12" style="height: 1%;">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Date</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm datepicker" name="">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>S.I.#</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" name="">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Rev Quote</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" name="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;margin-top: 25px;">
                <div class="row">
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <label>Shipping Method</label>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control-sm form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <label>Shipping Terms</label>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control-sm form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <label>Delivery Date</label>
                  </div>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <input type="text" class="form-control-sm form-control datepicker" name="">
                    </div>
                  </div>
                </div>
              </div>
              </div><!-- End div row -->
              <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <label>Item</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" readonly="" name="" id="sin_kodeitem">
                  </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="" id="sin_item">
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Qty</label>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="number" class="form-control form-control-sm" name="" id="sin_qty">
                  </div>
                </div>
              </div>
              <div class="table-responsive" style="margin-bottom: 15px;">
                <table class="table table-hover data-table" cellspacing="0" id="t80bv">
                  <thead class="bg-gradient-info">
                    <tr>
                      <th>Item Code</th>
                      <th>Item Name</th>
                      <th>Qty</th>
                      <th>Unit</th>
                      <th>Description</th>
                      <th>Unit Price</th>
                      <th>Line Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Subtotal</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">  
                        <input type="text" class="form-control form-control-sm" name="">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Sales Tax</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">  
                        <input type="text" class="form-control form-control-sm" name="">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Total</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">  
                        <input type="text" class="form-control form-control-sm" name="">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
          
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@section('extra_script')
<script type="text/javascript">
  console.log('ay');
  $(document).ready(function(){
    var table           = $("#t80bv").DataTable();
        var sin_qty         = $("#sin_qty");
        var sin_item          = $("#sin_item");
        var sin_kodeitem    = $("#sin_kodeitem");

        var x = 1;
 
    sin_qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        table.row.add( [
            '<input type="text" id="item_name[]" class="form-control input-sm" readonly="" value="'+ sin_kodeitem.val() +'">',
            '<input type="text" id="item_name[]" class="form-control input-sm" value="'+ sin_item.val() +'">',
            '<input type="number" id="jumlah[]" class="form-control input-sm" value="'+ sin_qty.val() +'">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="unit_price[]" class="form-control input-sm">',
            '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
        ] ).draw( false );
  
        x++;
        sin_item.focus();
        sin_item.val('');
        sin_qty.val('');
      }
    } );
 
    

    $('#t80bv tbody').on( 'click', '.delete', function () {
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });

    

  });
</script>
@endsection