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
  				<li class="breadcrumb-item active" aria-current="page">Form Master Scoreboard</li>
  			</ol>
  		</nav>
  	</div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Form Master Scoreboard</h4>
                    <div id="tab-general">
                      <div class="row mbl">
                        <div class="col-lg-12">
                          <div class="col-md-12">
                            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                            </div>
                          </div>

                          <div id="generalTabContent" class="tab-content responsive">
                            <!-- div index-tab -->
                              <form method="POST" id="form-save" name="formSave">
                              {{ csrf_field() }}
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                                <input type="hidden" name="kode_old" value="{{ $data->kpi_id }}">

                                <div class="col-md-3 col-sm-4 col-xs-12">
                                  <label class="tebal">Nama Parameter<span style="color: red">*</span></label>
                                </div>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                    <input type="text" id="nama_kpi" name="nama_kpi" class="form-control input-sm" value="{{ $data->kpi_name }}">
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">
                                  <label class="tebal">Divisi<span style="color: red">*</span></label>
                                </div>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group" id="divSelectDivisi">
                                    <input type="hidden" id="h_divisi" name="h_divisi" value="{{ $data->c_divisi }}" class="form-control input-sm" readonly>
                                    <input type="hidden" id="h_divisiid" name="h_divisiid" value="{{ $data->kpi_div_id }}" class="form-control input-sm" readonly>
                                    <select class="form-control input-sm select2" id="div_kpi" name="div_kpi" style="width: 100% !important;">
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">
                                  <label class="tebal">Jabatan<span style="color: red">*</span></label>
                                </div>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group" id="divSelectJabatan">
                                    <input type="hidden" id="h_jabatan" name="h_jabatan" value="{{ $data->c_posisi }}" class="form-control input-sm" readonly>
                                    <input type="hidden" id="h_jabatanid" name="h_jabatanid" value="{{ $data->kpi_jabatan_id }}" class="form-control input-sm" readonly>
                                    <select class="form-control input-sm select2" id="jbtn_kpi" name="jbtn_kpi" style="width: 100% !important;">
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">
                                  <label class="tebal">Nama Pegawai<span style="color: red">*</span></label>
                                </div>

                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group" id="divSelectJabatan">
                                    <input type="hidden" id="h_pegawai" name="h_pegawai" value="{{ $data->mp_name }}" class="form-control input-sm" readonly>
                                    <input type="hidden" id="h_pegawaiid" name="h_pegawaiid" value="{{ $data->kpi_p_id }}" class="form-control input-sm" readonly>
                                    <select class="form-control input-sm select2" id="peg_kpi" name="peg_kpi" style="width: 100% !important;">
                                    </select>
                                  </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12" align="right" id="change_function">
                                  <input type="button" name="tambah_data" value="Update Data" id="btn_simpan" class="btn btn-primary" onclick="updateData()">
                                </div>
                              </div>

                              <div class="col-md-12 col-sm-4 col-xs-12">
                                <label class="tebal" style="color: red">Keterangan : * Wajib diisi.</label>
                              </div>
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
      </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
  <script src="{{ asset('assets/validation/jquery.validate.js') }}"></script>
  <script type="text/javascript">
    $( document ).ready(function() {
      //fix to issue select2 on modal when opening in firefox
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
      var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      $('.select2').select2({
      });

      //select2 option selected
      $selectedDivisi = $("<option></option>").val($('#h_divisiid').val()).text($('#h_divisi').val());
      $("#div_kpi").append($selectedDivisi);

      $selectedJabatan = $("<option></option>").val($('#h_jabatanid').val()).text($('#h_jabatan').val());
      $("#jbtn_kpi").append($selectedJabatan);

      $selectedPegawai = $("<option></option>").val($('#h_pegawaiid').val()).text($('#h_pegawai').val());
      $("#peg_kpi").append($selectedPegawai);

      $( "#div_kpi" ).select2({
        placeholder: "Pilih Divisi...",
        ajax: {
          url: baseUrl + '/master/kpi/lookup-data-divisi',
          dataType: 'json',
          data: function (params) {
            return {
                q: $.trim(params.term)
            };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
        },
      });

      $('#div_kpi').change(function()
      {
        if($(this).val() != ""){
          $('#div_kpi').removeClass('has-error').addClass('has-valid');
          $('#jbtn_kpi').empty().attr('disabled', false);
          $('#peg_kpi').empty().attr('disabled', false);
        }else{
          $('#div_kpi').addClass('has-error').removeClass('has-valid');
          $('#jbtn_kpi').empty().attr('disabled', true);
          $('#peg_kpi').empty().attr('disabled', true);
        }

        var divisi = $('#div_kpi').val();
        $("#jbtn_kpi").select2({
          placeholder: "Pilih Jabatan...",
          ajax: {
            url: baseUrl + '/master/kpi/lookup-data-jabatan',
            dataType: 'json',
            data: function (params) {
              return {
                  q : $.trim(params.term),
                  divisi : divisi
              };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
          },
        });
      });

      $('#jbtn_kpi').change(function()
      {
        if($(this).val() != ""){
          $('#jbtn_kpi').removeClass('has-error').addClass('has-valid');
          $('#peg_kpi').empty().attr('disabled', false);
        }else{
          $('#div_kpi').addClass('has-error').removeClass('has-valid');
          $('#peg_kpi').empty().attr('disabled', true);
        }

        var divisi = $('#div_kpi').val();
        var jabatan = $('#jbtn_kpi').val();
        $("#peg_kpi").select2({
          placeholder: "Pilih Pegawai...",
          ajax: {
            url: baseUrl + '/master/kpi/lookup-data-pegawai',
            dataType: 'json',
            data: function (params) {
              return {
                  q : $.trim(params.term),
                  divisi : divisi,
                  jabatan : jabatan
              };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
          },
        });
      });

      //validasi
      $("#form-save").validate({
        // Specify validation rules
        rules:{
            nama_kpi : "required",
            div_kpi : "required",
            jbtn_kpi : "required",
            peg_kpi : "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
      });
    }); //end jquery

    function updateData() {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Update Data Master Scoreboard',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            var IsValid = $("form[name='formSave']").valid();
            if(IsValid)
            {
              $('#div_kpi').removeClass('has-error');
              $('#jbtn_kpi').removeClass('has-error');
              $('#peg_kpi').removeClass('has-error');
              $('#btn_simpan').text('Saving...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/master/scoreboard/update-score",
                type: "POST",
                dataType: "JSON",
                data: $('#form-save').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        window.location.href = baseUrl+"/master/scoreboard/index";
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        window.location.href = baseUrl+"/master/scoreboard/index";
                      }
                    });
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                position: 'center',
                message: "Mohon Lengkapi data form !",
                onClosing: function(instance, toast, closedBy){
                  $('#div_kpi').removeClass('has-error');
                  $('#jbtn_kpi').removeClass('has-error');
                  $('#peg_kpi').removeClass('has-error');
                }
              });
            } //end check valid
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }

    function randString(angka)
    {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < angka; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    }
  </script>
@endsection
