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
            <label>Amount</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control-sm form-control amount" id="amount" name="amount" onblur="amountup()">
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Date</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm datepicker date" id="" value="{{date('d-m-Y')}}" name="datepay">
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Payment Method</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              @if ($so != null or $wo != null)
                <select class="form-control form-control-sm" name="pay_method" onchange="methodChange(this.value)">
                    @if ($so!=null)
                      <option @if ($so->so_type == 'tunai')
                        selected=""
                      @endif value="tunai">Tunai</option>
                      <option @if ($so->so_type == 'Transfer')
                        selected=""
                      @endif value="Transfer">Transfer</option>
                    @else
                      <option @if ($wo->wo_type == 'tunai')
                        selected=""
                      @endif>tunai</option>
                      <option @if ($wo->wo_type == 'Transfer')
                        selected=""
                      @endif>Transfer</option>
                    @endif
                </select>
              @else
                <select class="form-control form-control-sm" name="pay_method">
                  <option value="tunai">Tunai</option>
                  <option value="transfer">Transfer</option>
                </select>
              @endif

            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Pilih Akun Keuangan</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">

              <div id="akunKas">
                <select class="form-control form-control-sm pay_method" name="pay_akun" id="akunKas">
                    @foreach($akunKas as $key => $akun)
                      <option value="{{ $akun->id }}">{{ $akun->text }}</option>
                    @endforeach
                </select>
              </div>

              <div style="display: none;" id="akunBank">
                <select class="form-control form-control-sm pay_method" name="pay_akun">
                    @foreach($akunBank as $key => $akun)
                      <option value="{{ $akun->id }}">{{ $akun->text }}</option>
                    @endforeach
                </select>
              </div>

            </div>
          </div>

          {{-- <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Reference</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              @if ($so != null or $wo != null)
                @if ($so!=null)
                  <input value="{{ $so->so_note2 }}" type="text" class="form-control-sm form-control" name="nota2">
                @else
                  <input value="{{ $wo->wo_note2 }}" type="text" class="form-control-sm form-control" name="nota2">
                @endif
              @else
                <input type="text" class="form-control-sm form-control" name="nota2">
              @endif
            </div>
          </div> --}}

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Notes</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              @if ($so != null or $wo != null)
                @if ($so!=null)
                  <input value="{{ $so->so_note }}" type="text" class="form-control-sm form-control" name="nota1">
                @else
                  <input value="{{ $wo->wo_note }}" type="text" class="form-control-sm form-control" name="nota1">
                @endif
              @else
                <input type="text" class="form-control-sm form-control" name="nota1">
              @endif
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12" id="labelakunsisa" style="display:none">
            <label>Akui Nominal Lebih Sebagai</label>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" id="akunsisa" style="display:none">
            <div class="form-group">
              <div>
                <select class="form-control form-control-sm akunsisa" name="akunsisa">
                    @foreach($akunsisa as $key => $akun)
                      <option value="{{ $akun->ak_id }}">{{ $akun->ak_nomor }} - {{ $akun->ak_nama }}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>

        <div class="col-md-3 col-sm-6 col-xs-12" id="labellebih">
          <label>Nominal Lebih</label>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
              <input type="text" readonly class="form-control-sm form-control" name="lebih">
          </div>
        </div>

      </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" id="save_detail" onclick="save_detail()" >Save Detail</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">

  function amountup(){
    var amount = $('#amount').val();
    var remain = $('#tmpremain').val();
    
    amount = amount.replace(/[^0-9\-]+/g,"");
    if (parseInt(amount) > parseInt(remain)) {
      var lebih = parseInt(amount) - parseInt(remain);
      iziToast.warning({
              icon: 'fa fa-info',
              message: 'Nominal melebihi remain!',
          });
      $('#amount').val(accounting.formatMoney(remain,"", 0, ".",','));
      $('#akunsisa').css('display', '');
      $('#labelakunsisa').css('display', '');
      $('input[name=lebih]').val(accounting.formatMoney(lebih,"", 0, ".",','));
  }
}

  function methodChange(e){
    if(e == 'Transfer'){
      document.getElementById('akunKas').style.display = 'none';
      document.getElementById('akunBank').style.display = 'inline';
    }else{
      document.getElementById('akunKas').style.display = 'inline';
      document.getElementById('akunBank').style.display = 'none';
    }
  }
</script>
