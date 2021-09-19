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
        <h4 class="modal-title">Form Quotation</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form class="row form_quote">
          {{ csrf_field() }}
          <input type="hidden" name="totaltax">
          <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Customer</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="row">
                    <div class="col-sm-10">
                      <div class="form-group">
                        <select style="width: 100%" class="form-control form-control-sm customer"  name="customer">
                          <option value="0">--Select Customer--</option>
                          @foreach($customer as $i)
                          <option value="{{$i->c_code}}">{{$i->c_code}} - {{$i->c_name}}</option>
                          @endforeach
                        </select>
                        <label style="color: red" hidden  class="valid valid_0"><b>Customer Harus Dipilih</b></label>
                      </div>
                    </div>
                  <div class="col-sm-2">
                      <button class="btn btn-outline-info btn-sm" type="button" title="Add Customer" data-toggle="modal" data-target="#tambah-customer"><i class="fa fa-plus"></i></button>
                  </div>
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
                  <textarea name="address" class="form-control address"></textarea>
                  <label style="color: red" hidden  class="valid valid_1"><b>Alamat Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-3 col-sm-0 col-xs-0">
                <!-- empty -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Type Quotation</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select style="width: 100%" class="form-control form-control-sm type_qo" id="type_qo" name="type_qo">
                    <option value="0">--Select Type--</option>
                    <option value="SWP">SWP</option>
                    <option value="WP">WP</option>
                    <option value="ACC">Accesories</option>
                    <option value="OFD">Off Grid</option>
                    <option value="ONG">On Grid</option>
                  </select>
                  <label style="color: red" hidden  class="valid valid_2"><b>Type Quotation Harus Dipilih</b></label>
                </div>
              </div>
              <div class="col-md-3 col-sm-0 col-xs-0">
                <!-- empty -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Type Product</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select style="width: 100%" class="form-control form-control-sm type_p" id="type_p" name="type_p">
                    <option value="0">--Select Type--</option>
                      @foreach ($type_product as $val)
                        <option value="{{$val->it_code}}">{{$val->it_code}}</option>
                      @endforeach
                  </select>
                  <label style="color: red" hidden  class="valid valid_3"><b>Type Product Harus Dipilih</b></label>
                </div>
              </div>
            </div>

          </div>

          <div class="col-md-4 col-sm-12 col-xs-12" >
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Date</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" value="{{ $now }}" class="form-control form-control-sm datepicker date" name="date">
                  <label style="color: red" hidden  class="valid valid_4"><b>Date Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Quote#</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" readonly="" class="form-control form-control-sm quote" name="quote">
                  <label style="color: red" hidden  class="valid valid_5"><b>Quote Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Ship to</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm ship_to" name="ship_to">
                  <label style="color: red" hidden  class="valid valid_6"><b>Ship to Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Marketing</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  @if(Auth::user()->akses('QUOTE MARKETING','aktif'))
                    <select class="marketing" name="marketing">
                      <option>--Select Marketing--</option>
                      @foreach($marketing as $i)
                        <option value="{{$i->mk_id}}">{{$i->mk_code}} - {{$i->mk_name}}</option>
                      @endforeach
                    </select>
                  @else
                    <input readonly="" type="text" class="form-control marketing form-control-sm" name="marketing" value="{{Auth::user()->m_name}}">
                  @endif
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Item Status</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <select class="itemstatus" name="itemstatus">
                      <option>--Select Item Status--</option>
                      <option value="Y">Ready</option>
                      <option value="N">Indent</option>
                    </select>
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
                  <select style="width: 100%" class="form-control form-control-sm ship_method" name="ship_method">
                    <option value="0">--Select Shipping Method--</option>
                    <option value="Sea">Sea</option>
                    <option value="Land Freight">Land Freight</option>
                    <option value="Air Freight">Air Freight</option>
                  </select>
                  <label style="color: red" hidden  class="valid valid_7"><b>Shipping Method Harus Dipilih</b></label>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Shipping Terms</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control-sm form-control ship_term" name="ship_term">
                  <label style="color: red" hidden  class="valid valid_8"><b>Shipping Terms Harus Diisi</b></label>
                </div>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Delivery Date</label>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control-sm form-control datepicker delivery" name="delivery">
                  <label style="color: red" hidden  class="valid valid_9"><b>Delivery Date Harus Diisi</b></label>
                </div>
              </div>
            </div>
          </div>
        </form><!-- End div row -->
        <div class="row" style="margin-top: 15px;border-top: 1px solid #98c3d1;padding-top:15px;border-bottom: 1px solid #98c3d1; margin-bottom: 15px;">
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Item Name</label>
          </div>
          <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="form-group item_div">
              <select class="form-control form-control-sm item" name="item">
                <option value="0">--Select item--</option>
                @foreach ($item as $val)
                  <option value="{{$val->i_code}}">{{$val->i_code}} - {{$val->i_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Qty</label>
          </div>
          <div class="col-md-2 col-sm-8 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm q_qty" name="" id="q_qty" title="Press Enter">
            </div>
          </div>
        </div>
          <div class="table-responsive" style="margin-bottom: 15px;">
            <table class="table table-hover datatbl" cellspacing="0" id="apfsds">
              <thead class="bg-gradient-info">
                <tr>
                  <th>Item</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Description</th>
                  <th>Unit Price</th>
                  <th>Total (Rp)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <form class="row total_form">
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Subtotal</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" value="0" type="text" class="form-control form-control-sm" readonly="" name="subtotal" id="subtotal">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Sales Tax</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" readonly type="text" class="form-control form-control-sm" value="0" name="tax" id="tax">
                  </div>
                </div>
                <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                  <label>Total</label>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input style="text-align: right;" type="text" class="form-control form-control-sm" readonly="" name="total" value="0" id="total">
                  </div>
                  <label style="color: red" hidden  class="valid valid_10"><b>Total Tidak Boleh 0</b></label>
                </div>
              </form>
            </div>
          </div>


      </div>
      <div class="modal-footer">
        <button class="btn btn-primary save" type="button">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
