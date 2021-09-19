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
<form id="form-save">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Request Order</h4>
        <button type="button" class="close" onclick="close()" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">


          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Request Order Code</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm readonly" name="ro_code_header" id="ro_code" value="{{ $nota }}">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Price Total</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm right readonly" name="ro_total_header" id="ro_total_header">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Date Request Order</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm datepicker_today" name="ro_date">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>QTY Total</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm right readonly" name="ro_qty_header" id="ro_qty_header">
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Vendor</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="ro_vendor_header" id="ro_vendor_header">
                <option selected="" value="">- Pilih -</option>
                @foreach ($vendor as $e)
                <option value="{{ $e->s_kode }}">{{ $e->s_company }} - {{ $e->s_name }} </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6 col-sm-0 col-xs-0">
            <!-- empty -->
          </div>
        </div>

         <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Item</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" id="rp_kodeitem">
                <option selected="" value="">- Pilih -</option>
                @foreach ($item as $i)
                  <option value="{{ $i->i_code }}" data-currency="{{$i->cu_symbol}}" data-name="{{ $i->i_name }}" data-price="{{ $i->i_price }}"
                    @if ($i->sg_qty != null)
                      data-qty="{{ $i->sg_qty }}"
                    @else
                      data-qty='0'
                    @endif
                  >{{ $i->i_code }} - {{ $i->i_name }} </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-1 col-sm-12 col-xs-12">
            <label>Price</label>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm right readonly" name="" id="rp_item">
            </div>
          </div>
          <div class="col-md-1 col-sm-12 col-xs-12">
            <label>Qty</label>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm right hanya_angka"  name="" id="rp_qty" >
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table data-table table-hover" cellspacing="0" id="t72a">
            <thead class="bg-gradient-info">
              <tr>
                 <th>Item Code</th>
                 <th>Item Name</th>
                 <th>Unit Price</th>
                 <th>Price</th>
                 <th width="1%">Qty</th>
                 <th width="1%">Stock Warehouse</th>
                 <th width="1%">Action</th>
               </tr>
             </thead>
             <tbody id="muncul">

             </tbody>
           </table>
         </div>


      </div> <!-- End div modal-content -->
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" onclick="simpan()" >Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

</form>
  </div>
</div>
