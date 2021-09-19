<!-- Modal -->
<div id="tambah-akun" class="modal fade" role="dialog">
  <div class="modal-dialog modal-m">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Setting Account</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
            <input type="hidden" name="old_name" class="old_name" >
            <table class="table tabel_modal">
              <tr>
                <td>Username</td>
                <td>
                  {{ csrf_field() }}
                  {{-- <input type="hidden" name="_token" class="token" value=""> --}}
                  <input type="text" name="username"  placeholder="username" class="username form-control form-control-sm">
                  <label style="color: red" hidden="" class="valid_1"><b>Username Harus Diisi</b></label>
                  <label style="color: red" hidden="" class="valid_u"><b>Username Sudah Terpakai</b></label>
                  <input type="hidden" name="id" class="id valid_2" >
                </td>
              </tr>
              <tr>
                <td>Password</td>
                <td>
                  <input type="text" name="password" placeholder="password" class="password form-control form-control-sm">
                  <label style="color: red" hidden="" class="valid_3"><b>Password Harus Diisi</b></label>
                </td>
              </tr>
              <tr>
                <td>Name</td>
                <td>
                  <input type="text" name="nama" placeholder="nama" class="nama huruf_besar form-control form-control-sm">
                  <label style="color: red" hidden="" class="valid_4"><b>Nama Harus Diisi</b></label>
                </td>
              </tr>
              <tr>
                <td>Mewakili Pegawai</td>
                <td>
                  <select class="pegawai form-control" name="pegawai">
                    <option selected="" value="0"> - Pilih Pegawai - </option>
                    @foreach ($pegawai as $key => $value)
                      <option value="{{$value->mp_id}}">{{$value->mp_name}}</option>
                    @endforeach
                  </select>
                  <label style="color: red" hidden="" class="valid_5"><b>Pegawai Harus Diisi</b></label>
                </td>
              </tr>
              <tr>
                <td>Account Level</td>
                <td class="level_td">
                  <select class="level form-control" name="level">
                    <option selected="" value="0">Choose - Level</option>
                    @foreach($level as $val)
                      <option value="{{$val->j_id}}">{{$val->j_nama}}</option>
                    @endforeach
                  </select>
                  <label style="color: red" hidden="" class="valid_6"><b>Level Harus Dipilih</b></label>
                </td>
              </tr>
              <tr>
                <td>Photo</td>
                <td>
                  <div class="file-upload">
                    <div class="file-select">
                      <div class="file-select-button" id="fileName">Image</div>
                      <div class="file-select-name" id="noFile">Choose Image...</div>
                      <input type="file" name="image" onchange="loadFile(event)" id="chooseFile">
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Preview</td>
                <td align="center">
                  <div class="preview_td">
                      <img style="width: 100px;height: 100px;border:1px solid pink" id="output" >
                  </div>
                </td>
              </tr>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary simpan" >Save Data</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
