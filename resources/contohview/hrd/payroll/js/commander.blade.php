<script>
    function hapus_tunj(id){
    // function hapus(parm){
    // var par   = $(parm).parents('tr');
    // var id    = $(par).find('.d_id').text();

        iziToast.show({
            overlay: true,
            close: false,
            timeout: 20000,
            color: 'dark',
            icon: 'fas fa-question-circle',
            title: 'Important!',
            message: 'Apakah Anda Yakin ?',
            position: 'center',
            progressBarColor: 'rgb(240, 0, 0)',
            buttons: [
              [
                '<button style="background: rgb(190, 0, 0); color: white;" onclick="success()">Delete</button>',
                function (instance, toast) {

                  $.ajax({
                     type: "post",
                     url: '{{route('hapus_tunjangan')}}',
                     data: '_token={{ csrf_token() }}&tman_id=' + id,
                     success: function(data){
                        if (data.status == 1) {
                            iziToast.success({
                                title: 'OK',
                                message: 'Successfully deleted record!',
                            });
                            tbl_tunj.ajax.reload();
                        }
                        else {
                            iziToast.warning({
                                title: 'Info',
                                message: 'Failed deleted record!',
                            });
                        }
                     },
                     error: function(){
                         iziToast.warning({
                            icon: 'fa fa-times',
                            message: 'Terjadi Kesalahan!',
                         });
                     },
                     async: false
                   });

                }
              ],
              [
                '<button class="btn btn-info">Cancel</button>',
                function (instance, toast) {
                  instance.hide({
                    transitionOut: 'fadeOutUp'
                  }, toast);
                }
              ]
            ]
          });


    }

     function reset_insert_form() {
            var form = $('#form_insert_tunj');

            form.find('[name="tman_id"]').val('');
            form.find('[name="tman_nama"]').val('');
            form.find('[name="tman_levelpeg"]').val('').trigger('change');
            form.find('[name="tman_periode"]').val('').trigger('change');
            form.find('[name="tman_value"]').val('');
        }

    function edit_tunj(obj) {
        var parent = $(obj).parents('tr')[0];
        var data = tbl_tunj.row( parent ).data();
        var form = $('#form_update_tunj');

        form.find('[name="tman_id"]').val( data.tman_id );
        form.find('[name="tman_nama"]').val( data.tman_nama );
        form.find('[name="tman_levelpeg"]').val( data.tman_jabatan ).trigger('change');
        form.find('[name="tman_periode"]').val( data.tman_periode ).trigger('change');
        form.find('[name="tman_value"]').val( data.tman_value );
    }
    $(document).ready(function(){



        // Sesi Tunjangan
        var tunj_url = "{{ url('/hrd/payroll/find-tunjangan') }}";

        tbl_tunj = $('#tbl_tunjangan').DataTable( {
            ajax: tunj_url,
            columns: [

                { data: "tman_nama" },
                {
                    data: null,
                    render : function(res) {
                        var result = '';
                        switch(res.tman_periode) {
                            case 'JM' :
                                result = 'Jam';
                            break;
                            case 'HR' :
                                result = 'Hari';
                            break;
                            case 'MG' :
                                result = 'Minggu';
                            break;
                            case 'TH' :
                                result = 'Tahun';
                            break;
                            case 'ST' :
                                result = 'Statis';
                            break;
                        }

                        return result;
                    }
                },
                { data: "tman_value" },
                {
                    data: null,
                    render : function(r) {
                        var btn = '<center><div class="btn-group"><button type="button" class="alamraya-btn-aksi btn btn-primary btn-lg " title="edit" data-toggle="modal" data-target="#edittunjangan" onclick="edit_tunj(this)"><label class="fa fa-pencil-alt"></label></button><button type="button" class="btn btn-danger btn-lg alamraya-btn-aksi" title="hapus" onclick="hapus_tunj(' + r.tman_id + ')"><label class="fa fa-trash"></label></button></div></center>';

                        return btn;
                    }
                },

            ]
        } );

        // ======================================================
    });

</script>
