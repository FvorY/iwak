<!-- Modal -->
<div id="detail_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:700px;">
<form id="form-detail">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Item Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div>
          <p><r class="badge badge-danger">*NOTE : data yang sudah di approve tidak bisa di edit </r></p>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered" cellspacing="0">
            <thead class="bg-gradient-info">
              <tr>
                <th align="center">Name</th>
                <th align="center">Price</th>
                <th align="center">Qtry</th>
                <th align="center">Approved</th>
              </tr>
            </thead>
            <tbody id="detail_rep">

            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        @if (Auth::user()->m_jabatan == 'MANAGER')
          <div id="change_detail">
            <button class="btn btn-primary" type="button" id="approve_data" >Approve</button>
          </div>        
        @endif
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

</form>
  </div>
</div>
