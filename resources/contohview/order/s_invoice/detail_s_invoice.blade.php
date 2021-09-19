@extends('main')
@section('content')

@include('order.s_invoice.log_payment')
<!-- partial -->
<div class="content-wrapper">
  <div class="col-lg-12">
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb bg-info">
        <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
        <li class="breadcrumb-item">Order</li>
        <li class="breadcrumb-item">Sales Invoice</li>
        <li class="breadcrumb-item active" aria-current="page">Detail Sales Invoice</li>
      </ol>
    </nav>
  </div>
  <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">Sales Invoice</h4>

                <form class="row detail_bayar">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Quote#</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control form-control-sm" value="{{$data->q_nota}}" name="q_nota">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Sales Invoice#</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" readonly="" class="form-control-sm form-control po_nota" value="{{$data->si_nota}}" name="po_nota">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Customer ID</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control-sm form-control" value="{{$data->q_customer}}" name="">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Date</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control-sm form-control" value="{{Carbon\Carbon::parse($data->si_date)->format('d-m-Y')}}" name="">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Ship to</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" value="{{$data->q_ship_to}}" readonly="" name="">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Date Payment</label>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="form-control-sm form-control date_payment datepicker" value="{{$data->si_date}}" name="dates">
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Shipping Method</label>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control-sm form-control" readonly="" value="{{$data->q_shipping_method}}" name="">
              </div>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Shipping Terms</label>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control-sm form-control" readonly="" value="{{$data->q_term}}" name="">
              </div>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Delivery Date</label>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control-sm form-control" readonly="" value="{{Carbon\Carbon::parse($data->q_delivery)->format('d-m-Y')}}" name="">
              </div>
            </div>
          </div>
          <div class="table-responsive alamraya-btn-add-row">
            <table class="table table-hover data-table" cellspacing="0">
              <thead class="bg-gradient-info">
                <tr>
                  <th>No</th>
                  <th>Item</th>
                  <th>Unit</th>
                  <th>Price</th>
                  <th>Line Before Tax</th>
                  <th>Tax</th>
                  <th>Line Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($datadt as $key => $value)
                  <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$value->i_code}} - {{$value->i_name}}</td>
                    <td>{{$value->u_unit}}</td>
                    <td>
                      <div class="pull-left">Rp.</div>
                      <div class="pull-right">{{number_format($value->qd_price,2,',','.')}}</div>
                    </td>
                    <td>
                      <div class="pull-left">Rp.</div>
                      <div class="pull-right">{{number_format($value->qd_beforetax,2,',','.')}}</div>
                    </td>
                    <td>
                      <div class="pull-left">Rp.</div>
                      <div class="pull-right">{{number_format($value->qd_tax,2,',','.')}}</div>
                    </td>
                    <td>
                      <div class="pull-left">Rp.</div>
                      <div class="pull-right">{{number_format($value->qd_total,2,',','.')}}</div>
                    </td>
                  </tr>
                @endforeach
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
                        <input type="text" class="form-control form-control-sm" name="subtotal" value="{{number_format($data->q_subtotal,2,',','.')}}" readonly="">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Sales Tax</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="tax" value="{{number_format($data->q_tax,2,',','.')}}" readonly="">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Total</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="total" value="{{number_format($data->q_total,2,',','.')}}" readonly="" id="total_harga">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>DP</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="dp" id="dp" readonly="" value="{{number_format($data->q_dp,2,',','.')}}">
                      </div>
                    </div>

                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Payment Log</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <button class="btn btn-primary btn-sm btn-block pilihpembayaran" data-toggle="modal" data-target="#pilihpembayaran">Detail</button>
                        </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Payment</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="payment" id="payment" value="{{number_format($data->q_total,2,',','.')}}" readonly="">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Total Paid</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="total_paid" id="total_paid" readonly="" value="{{number_format($data->q_total,2,',','.')}}">
                      </div>
                    </div>
                    <div class="offset-md-8 col-md-2 col-sm-6 col-xs-12">
                      <label>Remaining</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="" readonly="" value="0" id="remain">
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                      <a href="{{url('/order/s_invoice/s_invoice')}}" class="btn btn-secondary" >Back</a>
                  </div>
              </div>
                </div>

                </div>
        </div>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')

<script type="text/javascript">

  $(function() {
    $('.currency').maskMoney(
      {
        prefix:'RP. ',
        allowZero: true,
        allowNegative: true,
        thousands:'.',
        decimal:',',
        affixesStay: false
      }
    );
  })

</script>

@endsection
