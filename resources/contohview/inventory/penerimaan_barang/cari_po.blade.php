<div id="cari_po" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Add Data</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">


          <div class="table-responsive" style="margin-bottom: 15px;">
            <table class="table table-bordered table-hover data-table" cellspacing="0" id="abrams">
              <thead class="bg-gradient-info">
                <tr>
                 <th>No</th>
                  <th>PO</th>
                  <th>Vendor</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($po as $key => $value)
                  <tr onclick="cari_purchaseorder('{{$value->po_code}}')" style="cursor:pointer;">
                    <td>{{$key + 1}}</td>
                    <td>{{$value->po_code}}</td>
                    <td>{{$value->po_vendor}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>


         </div> <!-- End div row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
