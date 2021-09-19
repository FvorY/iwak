@section('extra_style')
<style type="text/css">
  .min-width{
    min-width: 100px;
  }
</style>
@endsection
<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Purchase Order</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">

            
            <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Vendor</label>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="">
                  </div>
                </div>

                <div class="col-md-6 col-sm-0 col-xs-0">
                  <!-- Empty -->
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Adress</label>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="">
                  </div>
                </div>

                <div class="col-md-3 col-sm-0 col-xs-0">
                  <!-- Empty -->
                </div>
              </div>

              
           </div>

        
          <div class="col-md-3 col-sm-12 col-xs-12" style="height: 1%;">
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Date</label>
              </div>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm datepicker" name="">
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <label>P.O.#</label>
              </div>
              <div class="col-md-8 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" name="">
                </div>
              </div>
            </div>
          </div>

            </div>

        <div class="row" style="margin-top: 15px;">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
             <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Shipping Method</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" name="">
                </div>
              </div>

              

              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Shipping Term</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" name="">
                </div>
              </div>

              

              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Delivery Date</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm datepicker" name="">
                </div>
              </div>
            </div>
          </div>
        </div>

       <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" readonly="" name="" id="po_kodeitem">
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="" id="po_item">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Qty</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="number" class="form-control form-control-sm" name="" id="po_qty">
            </div>
          </div>
        </div>

           <div class="table-responsive" style="margin-bottom: 15px;">
             <table class="table table-bordered table-hover data-table" cellspacing="0" id="abrams">
               <thead class="bg-gradient-info">
                 <tr>
                  <th>Item Code</th>
                   <th>Item Name</th>
                   <th>Qty</th>
                   <th>Description</th>
                   <th>Price</th>
                   <th>Unit Price</th>
                   <th>Line Total</th>
                 </tr>
               </thead>
             </table>
           </div>

           <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                  <label>Subtotal</label>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" readonly="" name="">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                  <label>Sales Tax</label>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" name="">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-12 col-xs-12">
                  <label>Total</label>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-sm" readonly="" name="">
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
  $(document).ready(function(){
    var table           = $("#abrams").DataTable();
        var po_qty         = $("#po_qty");
        var po_item          = $("#po_item");
        var po_kodeitem       = $("#po_kodeitem");

        var x = 1;
 
    po_qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        table.row.add( [
            '<input type="text" id="item_kode[]" class="form-control input-sm min-width" readonly="" value="'+ po_kodeitem.val() +'">',
            '<input type="text" id="item_name[]" class="form-control input-sm min-width" value="'+ po_item.val() +'">',
            '<input type="number" id="jumlah[]" class="form-control input-sm min-width" value="'+ po_qty.val() +'">',
            '<input type="text" id="[]" class="form-control input-sm min-width">',
            '<input type="text" id="[]" class="form-control input-sm min-width">',
            '<input type="text" id="unit_price[]" class="form-control input-sm min-width">',
            '<button type="button" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
        ] ).draw( false );
  
        x++;
        po_item.focus();
        po_item.val('');
        po_qty.val('');
      }
    } );
 
    

    $('#abrams tbody').on( 'click', '.delete', function () {
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });

    

  });
</script>
@endsection