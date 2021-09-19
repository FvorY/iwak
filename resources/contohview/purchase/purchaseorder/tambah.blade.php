
<!-- Modal -->
<form id="form_cari">
<div id="cari" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Cari</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">

          <table class="table table-bordered table-hover table-striped" id="tablecari">
            <thead>
              <tr>
                <th>No</th>
                <th>No. RO</th>
                <th>Tanggal</th>
                <th>Vendor</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ro as $key => $value)
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$value->ro_code}}</td>
                  <td>{{Carbon\Carbon::parse($value->ro_insert)->format('d-m-Y')}}</td>
                  <td id="{{$value->ro_code}}">{{$value->s_company}}</td>
                  <td align="center">
                    <div class="checkbox checkbox-primary checkbox-inline col-sm-2">
                                    <input type="checkbox" id="check{{$key}}" class="check" name="check[]" value="{{$value->ro_code}}">
                                    <label for="check{{$key}}"></label>
                    </div>
                  </td>
                  <input type="hidden" name="vendor[]" class="vendor" value="{{$value->ro_vendor}}">
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" id="create_po" style="margin-right: 0.1px;">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="margin-right: 50px;">Close</button>
      </div>
    </div>

  </div>
</div>
</div>
</form>
