<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary">
        <h4 class="modal-title">Tambah Data Lembur</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Pilih Jenis Pegawai</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="filter">
                  <option disabled selected>--Pilih--</option>
                  <option value="hrd">HRD dan General Affair</option>
                  <option value="keu">Keuangan dan Akuntansi</option>
                  <option value="snm">Sales dan Marketing</option>
                  <option value="prd">Produksi</option>
                  <option value="gnp">Gudang dan Pengiriman</option>
                  <option value="opr">Operator</option>
                  <option value="gmr">General Manager</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Tanggal Lembur</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <div id="datepicker-popup" class="input-group date datepicker">
                    <input type="text" class="form-control" placeholder="dd-mm-yyyy">
                    <div class="input-group-addon alamraya-input-group-addon">
                      <span class="mdi mdi-calendar"></span>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 alamraya-no-padding">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label>Jam Mulai</label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="input-group clockpicker alamraya-input-group-addon" data-placement="left" data-align="top">
                    <input type="text" class="form-control" value="09:00">
                    <span class="input-group-addon">
                      <i class="mdi mdi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 alamraya-no-padding">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <label>Jam Selesai</label>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="input-group clockpicker alamraya-input-group-addon" data-placement="right" data-align="top">
                    <input type="text" class="form-control" value="17:00">
                    <span class="input-group-addon">
                      <i class="mdi mdi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Divisi</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="filter">
                  <option disabled selected>--Pilih--</option>
                  <option value="hrd">HRD dan General Affair</option>
                  <option value="keu">Keuangan dan Akuntansi</option>
                  <option value="snm">Sales dan Marketing</option>
                  <option value="prd">Produksi</option>
                  <option value="gnp">Gudang dan Pengiriman</option>
                  <option value="opr">Operator</option>
                  <option value="gmr">General Manager</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Jabatan</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="filter">
                  <option disabled selected>--Pilih--</option>
                  <option value="hrd">HRD dan General Affair</option>
                  <option value="keu">Keuangan dan Akuntansi</option>
                  <option value="snm">Sales dan Marketing</option>
                  <option value="prd">Produksi</option>
                  <option value="gnp">Gudang dan Pengiriman</option>
                  <option value="opr">Operator</option>
                  <option value="gmr">General Manager</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Nama Pegawai</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="filter">
                  <option disabled selected>--Pilih--</option>
                  <option value="hrd">HRD dan General Affair</option>
                  <option value="keu">Keuangan dan Akuntansi</option>
                  <option value="snm">Sales dan Marketing</option>
                  <option value="prd">Produksi</option>
                  <option value="gnp">Gudang dan Pengiriman</option>
                  <option value="opr">Operator</option>
                  <option value="gmr">General Manager</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label>Keperluan</label>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
              </div>
            </div>
          

         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="button">Simpan</button>
      </div>
    </div>

  </div>
</div>
