<!-- Modal -->
<div id="tambah-customer" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save"> 
       <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Customer Name</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="c_name">
            </div>
          </div>
          
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Customer ID</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" readonly="" value="{{ $nota }}">
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Company Name</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="c_company_name">
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Phone Number</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="c_phone">
            </div>
          </div>
          {{-- <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Customer ID</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="c_id" readonly="">
            </div>
          </div> --}}
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Hometown</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="c_hometown">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($kota as $kt)
                  <option value="{{ $kt->id }}">{{ $kt->id }} - {{ $kt->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Phone Number 1</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="c_phone_1">
            </div>
          </div>
           
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>E-mail</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="email" class="form-control form-control-sm" name="c_email">
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Birth Date</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" maxlength="10" class="form-control form-control-sm datepicker" name="c_birthday">
            </div>
          </div>
          
           <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Address</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" id="c_address" name="c_address"></textarea>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Customer Type</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="c_type">
                <option selected="" disabled="" value="">- Pilih -</option>
                <option>Piutang</option>
                <option>Tunai</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Plafon Credit</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="c_plafon">
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Credit Terms</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="c_creditterms">
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>NPWP / KTP</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="c_npwp">
            </div>
          </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
            {{-- <label>NPWP</label> --}}
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            {{-- <div class="form-group"> --}}
              {{-- <input type="text" class="form-control" name="c_npwp"> --}}
            {{-- </div> --}}
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            {{-- <label>NPWP</label> --}}
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            {{-- <div class="form-group"> --}}
              {{-- <input type="text" class="form-control" name="c_npwp"> --}}
            {{-- </div> --}}
          </div>
          <div class="col-md-6 col-sm-0 col-xs-0">
            <!-- Empty -->
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Information</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" id="c_information" name="c_information"></textarea>
            </div>
          </div>
          <input type="hidden" name="kode_old">
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" id="save_data">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>