<div class="tab-pane fade active show" id="konfirmas_kpi_tab" role="tabpanel">

	<div class="card-body">
	  <h4 class="card-title">Konfirmasi KPI</h4>
	  	<div class="row">
	  		<div class="col-md-2 col-sm-3 col-xs-12">
	        	<label>Periode</label>
	        </div>


					<div class="col-md-4 col-sm-7 col-xs-12">
		        <div class="form-group" style="display: ">
		          <div class="input-daterange input-group">
		            <input id="tanggal1" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal1" type="text" value="{{ date('d-m-Y') }}">
		            <span class="input-group-addon">-</span>
		            <input id="tanggal2" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal2" type="text" value="{{ date('d-m-Y') }}">
		          </div>
		        </div>
		      </div>

			<div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatKpiByTgl()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelIndex()">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>

			<div align="right">
          <select class="form-control input-sm" name="k_confirm" id="k_confirm" onchange="lihatKpiByTgl()">
             <option selected value="ALL">Semua</option>
             <option value="N">Belum Dikonfirmasi</option>
             <option value="Y">Sudah Dikonfirmasi</option>
           </select>        
      </div>
	    </div>
	  	<div class="row">

			<div class="table-responsive">
				<table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-index">
					<thead>
				    <tr>
				      <th>No</th>
				      <th>Date</th>
				      <th>Code</th>
				      <th>Employee</th>
				      <th>Status</th>
				      <th>Date Confirm</th>
				      <th>Total Score</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				  <tbody>

				  </tbody>
				</table>
			</div>

		</div>

	</div>

</div>
