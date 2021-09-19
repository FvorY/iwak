<!-- Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Edit Master Akun Keuangan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="save_data">  
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
              <label>Tipe Akun</label>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="form-group">
                <select class="form-control form-control-sm" id="type_akun" name="type_akun">
                  <option value="GENERAL">GENERAL</option>
                  <option value="DETAIL">DETAIL</option>
                </select>
              </div>
            </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Kelompok Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select class="form-control form-control-sm" name="nama_kelompok" id="nama_kelompok">
                      <option value="1">Aset Lancar</option>
                      <option value="2">Aset Tidak Lancar</option>
                      <option value="3">Kewajiban Jangka Pendek</option>
                      <option value="4">Ekuitas</option>
                      <option value="5">Pendapatan</option>
                      <option value="6">Beban Usaha</option>
                      <option value="7">Pendapatan Lain-Lain</option>
                      <option value="8">Beban Lain-Lain</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Nomor Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <div class="input-group">
                      <input type="text" name="nomor_akun" id="nomor_akun" class="form-control" placeholder="Masukkan Nomor Akun">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Nama Akun</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group form-group-sm">
                    <input type="text" name="nama_akun" id="nama_akun" class="form-control" placeholder="Masukkan Nama Akun">
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <label>Debet / Kredit</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="form-group">
                    <select class="form-control form-control-sm" id="posisi_akun" name="posisi_akun">
                      <option value="D">DEBET</option>
                      <option value="K">KREDIT</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <label>Group Neraca</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <div class="form-group form-group-sm">
                    <select class="form-control form-control-sm select2" id="group_neraca" name="group_neraca">
                      <option selected>Tidak Memiliki group Neraca</option>
                      @foreach ($grupakun as $element)
                        <option value="{{ $element->no_group }}">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <label>Group Laba Rugi</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <div class="form-group form-group-sm">
                    <select class="form-control form-control-sm select2" id="group_laba_rugi" name="group_laba_rugi">
                      <option selected>Tidak Memiliki group Neraca</option>
                      @foreach ($labarugi as $element)
                        <option value="{{ $element->no_group }}">{{ $element->no_group }} / {{ $element->nama_group }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <label>Saldo Bulan ini</label>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 sembunyikan" style="visibility:hidden;" >
                  <div class="form-group form-group-sm">
                    <input type="text" name="saldo" class="form-control text-right format_money" placeholder="Masukkan Group Laba Rugi">
                  </div>
                </div>
              </div>
            </div>
          </form>

         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="button">Simpan</button>
      </div>
    </div>

  </div>
</div>
