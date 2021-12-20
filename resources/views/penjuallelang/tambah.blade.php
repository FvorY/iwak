<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Lelang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">
        Please fill in all the data marked with <span style="color:red;">*</span>
        </div>
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Select Product <span style="color:red;">*</span></td>
            <td>
              <select class="form-control produk" name="id_produk">
                <option value="" selected>- Choose -</option>
                @foreach ($produk as $key => $value)
                  <option value="{{$value->id_produk}}">{{$value->name}}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td>Price <span style="color:red;">*</span></td>
            <td>
              <input type="text" class="form-control form-control-sm price rp" name="price">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpan" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
