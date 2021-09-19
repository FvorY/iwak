<!-- Modal -->
<div id="tambah-vendor" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Vendor</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <form id="save_vendor" class="save_vendor">
          <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Name PIC</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_name">
              <label style="color: red" hidden="" class="valid_1"><b>Username Harus Diisi</b></label>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Company</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_company">
              <label style="color: red" hidden="" class="valid_2"><b>Company Harus Diisi</b></label>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Hometown</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="v_hometown">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($kota as $kt)
                  <option value="{{ $kt->id }}">{{ $kt->id }} - {{ $kt->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Phone Number</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_tlp">
            </div>
          </div>
           
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>E-mail</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="email" class="form-control form-control-sm" name="v_email">
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Phone Number 1</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_tlp1">
            </div>
          </div>
          
           <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Address</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" id="v_alamat" name="v_alamat"></textarea>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Vendor Type</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="v_tipe">
                <option selected="" readonly="" value="">- Pilih -</option>
                <option value="Piutang">Piutang</option>
                <option value="Tunai">Tunai</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Plafon Credit</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="v_plafon">
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Credit Terms</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="v_credit">
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Bank Name</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="v_namabank">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($bank as $bn)
                  <option value="{{ $bn->id }}">{{ $bn->id }} - {{ $bn->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Account Number</label>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_accountnumber">
            </div>
          </div>
          <div class="col-md-1 col-sm-1 col-xs-12">
            <div class="form-group rubah">
              <button type="button" class="btn btn-primary btn-xs" onclick="tambah_bank()"><i class="fa fa-plus"></i></button>
            </div>
          </div>

            <div class="col-md-3 col-sm-3 col-xs-12 hide">
              <label>Bank town</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide">
              <div class="form-group">
              <select class="form-control form-control-sm" name="v_bank_town">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($kota as $kt)
                  <option value="{{ $kt->id }}">{{ $kt->id }} - {{ $kt->name }}</option>
                @endforeach
              </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide">
              <label>Account Name </label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide">
              <div class="form-group">
                <input type="text" class="form-control" name="v_bank_pic">
              </div>
            </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Bank name 1</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control form-control-sm" name="v_namabank_1">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($bank as $bn)
                  <option value="{{ $bn->id }}">{{ $bn->id }} - {{ $bn->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Account Number 1</label>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" name="v_accountnumber_1">
            </div>
          </div>
          <div class="col-md-1 col-sm-1 col-xs-12">
            <div class="form-group rubah_1">
              <button type="button" class="btn btn-primary btn-xs" onclick="tambah_bank_1()"><i class="fa fa-plus"></i></button>
            </div>
          </div>

            <div class="col-md-3 col-sm-3 col-xs-12 hide_1">
              <label>Bank town 1</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide_1">
              <div class="form-group">
              <select class="form-control form-control-sm" name="v_bank_town_1">
                <option selected="" readonly="" value="">- Pilih -</option>
                @foreach ($kota as $kt)
                  <option value="{{ $kt->id }}">{{ $kt->id }} - {{ $kt->name }}</option>
                @endforeach
              </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide_1">
              <label>Account Name 1</label>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 hide_1">
              <div class="form-group">
                <input type="text" class="form-control" name="v_bank_pic_1">
              </div>
            </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>NPWP</label>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="v_npwp">
            </div>
          </div>
          <div class="col-md-6 col-sm-0 col-xs-0">
            <!-- Empty -->
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <label>Information</label>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
              <textarea class="form-control form-control-sm" id="v_informasi" name="v_informasi"></textarea>
            </div>
          </div>
          <input type="hidden" name="v_kode_old">
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