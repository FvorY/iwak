<div class="tab-pane fade" id="scoreboard_tab" role="tabpanel">
	<div class="card-body">
      <h4 class="card-title">Data Scoreboard</h4>
      	<div class="row">
      		<div class="col-md-2 col-sm-3 col-xs-12">
            	<label>Periode</label>
            </div>


						<div class="col-md-4 col-sm-7 col-xs-12">
							<div class="form-group" style="display: ">
								<div class="input-daterange input-group">
									<input id="tanggal3" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal3" type="text">
									<span class="input-group-addon">-</span>
									<input id="tanggal4" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal4" type="text" value="{{ date('d-m-Y') }}">
								</div>
							</div>
						</div>

						<div class="col-md-3 col-sm-3 col-xs-12" align="center">
			        <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatScoreByTgl()">
			          <strong>
			            <i class="fa fa-search" aria-hidden="true"></i>
			          </strong>
			        </button>
			        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelScore()">
			          <strong>
			            <i class="fa fa-undo" aria-hidden="true"></i>
			          </strong>
			        </button>
			      </div>

						<div align="right">
			          <select class="form-control input-sm" name="s_confirm" id="s_confirm" onchange="lihatScoreByTgl()">
			             <option selected value="ALL">Semua</option>
			             <option value="N">Belum Dikonfirmasi</option>
			             <option value="Y">Sudah Dikonfirmasi</option>
			           </select>			        
			      </div>
        </div>
      	<div class="row">

			<div class="table-responsive">
				<table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-score">
					<thead id="thead-score">
				    <tr>
				      <th>No</th>
				      <th>Date</th>
				      <th>Code</th>
				      <th>Employee</th>
				      <th>Status</th>
				      <th>Date Confirm</th>
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
