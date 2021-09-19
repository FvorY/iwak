<script>
    // Datatable Absensi manajemen
    var absman_search = $('#absmanajemen_search');
    var absman_refresh = $('#absmanajemen_refresh');
    var absman_tgl_awal = $('#absmanajemen_tgl_awal');
    var absman_tgl_akhir = $('#absmanajemen_tgl_akhir');
    var absman_id_divisi = $('#absmanajemen_id_divisi');
    var absman_url = "{{ url('/hrd/absensi/absensi-manajemen') }}";

    var tbl_absman = $('#tbl_absmanajemen').DataTable( {
        ajax: absman_url,
        columns: [

            { data: "apm_tanggal" },
            { data: "apm_nama" },
            { data: "apm_jam_kerja" },
            { data: "apm_jam_masuk" },
            { data: "apm_jam_pulang" },
            { data: "apm_scan_masuk" },
            { data: "apm_scan_pulang" },
            { data: "apm_terlambat" },
            { data: "apm_jml_jamkerja" }

        ]
    } );



    absman_refresh.click(function(){
        // Merefresh tabel manajemen
        absman_tgl_awal.val('');
        absman_tgl_akhir.val('');
        tbl_absman.ajax.url(absman_url).load();
    });

    // Pencarian berdasarkan tanggal
    absman_search.click(function(){
        var date_param = '';
        var div_param = '';
        var tgl_awal = absman_tgl_awal.val() != '' ? absman_tgl_awal.val() : '' ;
        var tgl_akhir = absman_tgl_akhir.val() != '' ? absman_tgl_akhir.val() : '' ;
        var id_divisi = absman_id_divisi.val() != '' ? absman_id_divisi.val() : '' ;

        if(id_divisi != '') {
            div_param = 'id_divisi=' + id_divisi;
        }

        if(tgl_awal != '' && tgl_akhir != '') {
            date_param = '&tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
        }

        var tmp_url = absman_url + '?' + div_param + date_param;
        tbl_absman.ajax.url(tmp_url).load();
    });


    // ======================================================

</script>
