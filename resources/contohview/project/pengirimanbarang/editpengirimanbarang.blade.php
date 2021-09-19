<!-- Modal -->
<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Pengiriman Barang</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="editdata">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>NO SO</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control form-control-sm" id="d_so" readonly type="text" name="d_so" style="cursor: pointer;">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Delivery Date</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control form-control-sm datepicker" id="d_delivery_date" readonly name="d_delivery_date" type="text" style="cursor: pointer;">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Receive Date</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control form-control-sm datepicker" name="d_receive_date" readonly type="text" style="cursor: pointer;">
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Receiver</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <input class="form-control form-control-sm" type="text" name="d_receiver" style="cursor: pointer;">
            </div>
          </div>
      </div>
    </div>
    </form>
      <div class="modal-footer">
        <button type="button" onclick="setting()" class="btn btn-info">Proses</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

</script>
