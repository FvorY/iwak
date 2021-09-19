@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
  	<div class="col-lg-12">
  		<nav aria-label="breadcrumb" role="navigation">
  			<ol class="breadcrumb bg-info">
  				<li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="#">Home</a></li>
  				<li class="breadcrumb-item">Master</li>
  				<li class="breadcrumb-item active" aria-current="page">Master Print Out Term & Condition</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Master Print Out & Condition</h4>
                    @if (App\mMember::akses('MASTER PRINT OUT TERM & CONDITION', 'tambah'))
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<button type="button" class="btn btn-info" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    @endif
                    <div class="table-responsive">
  				            <table class="table table-hover table-bordered" id="table-print" cellspacing="0">
  				                          <thead class="bg-gradient-info">
  				                            <tr>
                                        <th>No</th>
                                        <th>Print</th>
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
  </div>
</div>

<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Tambah Print Out Term & Condition</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Print</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <div class="input-group">
                <textarea name="print" class="form-control" rows="8" cols="80"></textarea>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Menu</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <select class="form-control" name="menu" id="menu">
                  <option value="QO">Quotation (QO)</option>
                  <option value="WO">Work Order (WO)</option>
                  <option value="SO">Sales Order (SO)</option>
                  <option value="PI">Proforma Invoice (PI)</option>
                </select>
            </div>
          </div>
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" onclick="simpan('simpan')">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Edit Print Out Term & Condition</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <form id="form_save">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Print</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <div class="input-group">
                <textarea name="printe" id="printe" class="form-control" rows="8" cols="80"></textarea>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-xs-12">
            <label>Menu</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <select class="form-control" name="menu" id="menue">
                  <option value="QO">Quotation (QO)</option>
                  <option value="WO">Work Order (WO)</option>
                  <option value="SO">Sales Order (SO)</option>
                  <option value="PI">Proforma Invoice (PI)</option>
                </select>
            </div>
          </div>
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <div id="change_function">
          <button class="btn btn-primary" type="button" onclick="simpan('update')">Save Data</button>
        </div>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script type="text/javascript">
var table;

  table = $('#table-print').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:baseUrl + '/master/printout/datatable_print',
            },
             columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center d_id'
                  },
                  {
                     targets: 1 ,
                     className: 'center status'
                  },
                  {
                     targets: 2 ,
                     className: 'center aksi'
                  },
                ],
            "columns": [
            { "data": "number" },
            { "data": "p_print" },
            { "data": "aksi" },
            ]
      });

  function tambah(){
    $('#tambah').modal('show');
  }

  function simpan(parm){
    if (parm == 'simpan') {
      var print = $('textarea[name=print]').val();
      var menu = $('#menu').val();
    } else if (parm == 'update') {
      var print = $('textarea[name=printe]').val();
      var menu = $('#menue').val();
    }
    $.ajax({
      type: 'get',
      data: {print, menu},
      dataType: 'json',
      url: baseUrl + '/master/printout/simpan',
      success : function(response){
        if (response.status == 'berhasil') {
          iziToast.success({
            icon: 'fas fa-check-circle',
            message: 'Successfully!',
          });
          table.ajax.reload();
          var print = $('textarea[name=print]').val('');
          $('#tambah').modal('hide');
          $('#edit').modal('hide');
        } else {
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!',
          });
        }
      }
    })
  }

  function hapus(id) {
      iziToast.show({
              overlay: true,
              close: false,
              timeout: 20000,
              color: 'dark',
              icon: 'fas fa-question-circle',
              title: 'Important!',
              message: 'Apakah Anda Yakin ?!',
              position: 'center',
              progressBarColor: 'rgb(0, 255, 184)',
              buttons: [
                [
                  '<button style="background-color:red;">Delete</button>',
                  function (instance, toast) {

                    $.ajax({
                      type: 'get',
                      data: {id:id},
                      dataType: 'json',
                      url: baseUrl + '/master/printout/hapus',
                      success : function(response){
                        if (response.status == 'berhasil') {
                          iziToast.success({
                            icon: 'fas fa-check-circle',
                            message: 'Data Telah Tersimpan!',
                          });
                          table.ajax.reload();
                        } else {
                          iziToast.warning({
                            icon: 'fa fa-times',
                            message: 'Terjadi Kesalahan!',
                          });
                        }
                        },
                        error:function(){
                          iziToast.warning({
                            icon: 'fa fa-times',
                            message: 'Terjadi Kesalahan!',
                          });
                        }
                    });

                  }
                ],
                [
                  '<button style="background-color:#44d7c9;">Cancel</button>',
                  function (instance, toast) {
                    instance.hide({
                      transitionOut: 'fadeOutUp'
                    }, toast);
                  }
                ]
              ]
            });
    }

    function edit(id){
      $.ajax({
        type: 'get',
        data: {id},
        dataType: 'JSON',
        url: baseUrl + '/master/printout/edit',
        success : function(response){
          $('textarea[name=printe]').text(response[0].p_print);
          $('#menue').find('option[value='+response[0].p_menu+']').trigger('change');

          $('#edit').modal('show');
        }
      });
    }

</script>
@endsection
