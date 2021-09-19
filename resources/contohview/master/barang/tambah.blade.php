<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Master Data Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="modal-body">
          <form id="simpan_barang">

            <input type="hidden" value="{{csrf_token()}}" name="_token">

            <div class="row">

              <div class="col-lg-6 col-md-12">

                <div class="row">

                  <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Item Name</label>
                  </div>
                  <div class="col-lg-6 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <input type="text"  class="form-control form-control-sm huruf_besar" name="item_name">
                        <input type="hidden"  class="form-control form-control-sm kode_barang huruf_besar" name="kode_barang">
                    </div>
                  </div>

                  <div class="col-lg-6 col-sm-4 col-xs-12">
                      <label class="tebal">Type</label>
                  </div>
                  <div class="col-lg-6 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <select class="form-control" name="type_barang">
                          <option value="">--Select Type--</option>
                          @foreach($type_barang as $tipe)
                            <option value="{{$tipe['it_code']}}">{{$tipe['it_code']}} || {{$tipe['it_name']}}</option>
                          @endforeach

                        </select>
                    </div>
                  </div>

                  <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Weight</label>
                  </div>
                  <div class="col-lg-6 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <input type="text"  class="form-control hanya_angka form-control-sm weight" name="weight">
                    </div>
                  </div>



                  <div class="col-lg-6 col-sm-4 col-xs-12">

                        <label class="tebal">Min Stock</label>

                  </div>
                  <div class="col-lg-6 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control hanya_angka form-control-sm min_stock" name="min_stock">
                    </div>
                  </div>


                  <div class="col-lg-6 col-sm-4 col-xs-12">
                      <label class="tebal">Unit#</label>
                  </div>
                  <div class="col-lg-6 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <select class="unit" name="unit">
                          @foreach($unit as $i)
                            <option value="{{$i->u_id}}">{{$i->u_unit}}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                </div>



              </div>


                <div class="col-lg-6 col-sm-12">

                  <div class="row">
                  {{--
                    <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Currency</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12" style="width: 100%">
                      <div class="form-group">
                          <select class="form-control currency" name="currency">
                            @foreach($currency as $val)
                              <option @if ($val->cu_code == 'IDR')
                                selected=""
                              @endif value="{{$val->cu_code}}">{{$val->cu_code}} || {{$val->cu_name}}</option>
                            @endforeach

                          </select>
                      </div>
                    </div> --}}




                    <div class="col-lg-6 col-sm-4 col-xs-12">
                          <label class="tebal">Sell Price</label>

                          <label class="pull-right"><input type="radio" name="sell_price_currency" value="idr">IDR</label>
                          <label class="pull-right mr-3-custom"><input type="radio" name="sell_price_currency" value="usd">USD</label>

                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <input type="text"  class="form-control hanya_angka rp form-control-sm sell_price" name="sell_price" maxlength="20" required="">
                      </div>

                    </div>




                   <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Lower Price</label>

                          <label class="pull-right"><input type="radio" name="lower_price_currency" value="idr">IDR</label>
                          <label class="pull-right mr-3-custom"><input type="radio" name="lower_price_currency" value="usd">USD</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <input type="text"  class="form-control hanya_angka rp form-control-sm lower_price" name="lower_price" maxlength="20" required="">
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-4 col-xs-12">
                      <label class="tebal">Price</label>

                          <label class="pull-right"><input type="radio" name="price_currency" value="idr">IDR</label>
                          <label class="pull-right mr-3-custom"><input type="radio" name="price_currency" value="usd">USD</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <input type="text"  class="form-control hanya_angka rp form-control-sm price" name="price" maxlength="20" required="">
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Category</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <select class="category" name="category">
                            <option value="">--Select Type--</option>
                            <option value="Barang Jual">Barang Jual</option>
                            <option value="Aksesoris instalasi">Aksesoris instalasi</option>
                            <option value="Lain - Lain">Lain - Lain</option>
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Akun Pendapatan</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <select class="akunpendapatan" name="akunpendapatan">
                            <option value="">--Select Type--</option>
                            @foreach ($akun as $key => $value)
                              <option value="{{$value->ak_id}}">{{$value->ak_nama}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Akun Persediaan</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <select class="akunpersediaan" name="akunpersediaan">
                            <option value="">--Select Type--</option>
                            @foreach ($akun as $key => $value)
                              <option value="{{$value->ak_id}}">{{$value->ak_nama}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-4 col-xs-12">
                        <label class="tebal">Akun Beban</label>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                          <select class="akunbeban" name="akunbeban">
                            <option value="">--Select Type--</option>
                            @foreach ($akun as $key => $value)
                              <option value="{{$value->ak_id}}">{{$value->ak_nama}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                  </div>
                </div>



              <div class="col-lg-3 col-sm-4 col-xs-12">

                    <label class="tebal">Description</label>

              </div>
              <div class="col-lg-9 col-sm-8 col-xs-12">
                <div class="form-group">
                    <textarea class="form-control form-control-sm" name="description"></textarea>
                </div>
              </div>

              <div class="col-lg-3 col-sm-4 col-xs-12 122mm">
                <label>Image</label>
              </div>

              <div class="col-lg-3 col-sm-8 col-xs-12 122mm">

                <div class="form-group">

                  <div class="file-upload">
                    <div class="file-select">
                      <div class="file-select-button" id="fileName">Image</div>
                      <div class="file-select-name" id="noFile">Choose Image...</div>
                      <input type="file" name="image" onchange="loadFile(event)" id="chooseFile" accept="image/*">
                    </div>
                  </div>

                </div>

              </div>

              <div class="col-lg-1 col-sm-4 col-xs-12 122mm">
                <label>Preview</label>
              </div>

              <div class="col-lg-3 col-sm-8 col-xs-12 122mm">
                  <div class="preview_td">
                      <img id="output" >

                  </div>
              </div>

              <div class="col-12" id="check_change_image">

              </div>

              <input type="hidden" name="item_codex">
            </div>
          </form>
          </div>
        <div class="modal-footer">
          <div id="ganti_tombol">
            <button class="btn btn-primary" type="button" onclick="simpan()">Save Data</button>
          </div>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
