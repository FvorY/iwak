<!-- Modal -->
<div id="buylelang" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Buy Direct</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
            <h2>PAYMENT</h2>
            <!-- Panel Group of the Page -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="alert alert-warning" role="alert">
                <h4> Please upload proof of payment correctly, and transfer according to the bank information below and transfer according to the total purchase. </h4>
              </div>
              <!-- Panel Panel Default of the Page -->

              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    STORE NAME : <span id="namatoko"> </span>
                  </h4>
                </div>
              </div>


              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    BANK NAME : <span id="bankname"> </span>
                  </h4>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    NO ACCOUNT : <span id="nomor_rekening"> </span>
                  </h4>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <input type="file" class="form-control form-control-sm uploadGambar" name="image" accept="image/*">


                  </h4>
                </div>
              </div>

              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <div class="col-md-8 col-sm-6 col-xs-12 image-holder" id="image-holder">

                        {{-- <img src="#" class="thumb-image img-responsive" height="100px" alt="image" style="display: none"> --}}

                    </div>
                  </h4>
                </div>
              </div>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpanbuy" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
