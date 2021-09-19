<!-- Modal -->
<div id="tambah_ttd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form TTD</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" class="form-horizontal ttd" action="{{ url('master/ttd/simpan') }}" accept-charset="UTF-8" id="tambahttd" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Name</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="text" class="form-control" name="name">
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Signature Image</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input type="file" class="form-control" name="signatureimage">
            </div>
          </div>
         </div>
      </div>
      </form>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="submit()">Save Data</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
