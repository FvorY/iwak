<!-- Modal -->
<div id="check" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Process Checklist</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="row col-md-9 col-sm-12 col-xs-12">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <label>Customer ID</label>
            </div>
            <div class="col-md-5 col-sm-6 col-xs-12">
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm">
                <div class="input-group-append">
                  <button class="btn btn-outline-info btn-sm" type="button" title="Add Customer" data-toggle="modal" data-target="#tambah-customer"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-0 col-xs-0">
              <!-- empty -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Order By</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" name="" class="form-control form-control-sm">
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <!-- Empty -->
            </div>


            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Address</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <div class="form-group">
                <textarea class="form-control form-control-sm"></textarea>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <!-- Empty -->
            </div>
          </div>

          <div class="row col-md-3 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-12 col-xs-12">
              <label>Date</label>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="form-group">  
                <input type="text" class="form-control form-control-sm datepicker" name="">
              </div>
            </div>
            <div class="col-md-6 col-sm-3 col-xs-12">
              <label>S.O.#</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" name="" class="form-control form-control-sm">
              </div>
            </div>
            <div class="col-md-6 col-sm-3 col-xs-12">
              <label>Checker</label>
            </div>
            <div class="col-md-6 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" name="" value="{{ Auth::user()->name }}" class="form-control form-control-sm" readonly="" ">
                <input type="hidden" value="{{ Auth::user()->username }}" name="">
              </div>
            </div>
          </div>
          <div class="table-responsive" style="margin-top: 15px;">
            <table class="table table-hover" cellspacing="0">
              <thead class="bg-gradient-info">
                <tr>
                  <th>Item#</th>
                  <th>Qty</th>
                  <th>Description</th>
                  <th>Checklist</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>2</td>
                  <td>Grounding Kit</td>
                  <td>
                        <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox">
                          </div>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>2</td>
                  <td>Accesories Kit</td>
                  <td>
                        <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox">
                          </div>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>42</td>
                  <td>Solar Panel 100 Wp</td>
                  <td>
                        <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox">
                          </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button">Process</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>