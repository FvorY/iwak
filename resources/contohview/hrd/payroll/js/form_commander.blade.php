<script>
$(document).ready(function(){
// Function untuk menyimpan data tunjangan
	$('#tunj_insert_btn').click(function(){
		var data = $('#form_insert_tunj').serialize();
		$.ajax({
	        url  : '{{ url("/hrd/payroll/insert-tunjangan") }}',
	        type : 'POST',
	        data : data,
	        success : function(raw_resp) {
	           if(raw_resp.status == 1) {
		           iziToast.success({
                        title: 'OK',
                        message: 'Berhasil menyimpan data'
                    });  	
		           tbl_tunj.ajax.reload();
	           } 	
	           else {
	           	   iziToast.warning({
                        title: 'Info',
                        message: 'Gagal menyimpan data!'
                    });
	           }

	           $('#tambahtunjangan').modal('hide');
	        }
	    });
	});
	// =====================================================

	// Function untuk meng-update data tunjangan
	$('#tunj_update_btn').click(function(){
		var data = $('#form_update_tunj').serialize();
		$.ajax({
	        url  : '{{ url("/hrd/payroll/update-tunjangan") }}',
	        type : 'POST',
	        data : data,
	        success : function(raw_resp) {
	           // Mereset form
	           if(raw_resp.status == 1) {
		           iziToast.success({
                        title: 'OK',
                        message: 'Berhasil meng-update data'
                    });  	
		           tbl_tunj.ajax.reload();  	
		           
	           } 	
	           else {
	           	   iziToast.warning({
                        title: 'Info',
                        message: 'Gagal meng-update data data!'
                    });
	           }

	           $('#edittunjangan').modal('hide');
	        }
	    });
	});
	// =====================================================
});
</script>