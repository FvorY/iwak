 @foreach($data as $i=>$g)
  <div class="panel-default">
    <a data-toggle="collapse" href="#collapse{{ $i }}">
    <div class="panel-heading bg-gradient-primary panel-bg panel-top" style="border: 1px solid #e5e5e5;color:white;padding-left: 15px;">
      <h4 class="panel-title">
       {{ $grup_menu[$i]->gm_nama }}
      </h4>
    </div>
    </a>
    <div id="collapse{{ $i }}" class="panel-collapse collapse">
      <div class="panel-body" style="border: 1px solid #e5e5e5;">
        <div class="table-responsive">
        <table class="table table-hover table-bordered" width="100%" cellspacing="0">
          <thead class="bg-gradient-info">
            <tr>
              <th width="500">Nama Menu</th>
              <th>Aksi</th>
              <th>Tambah</th>
              <th>Ubah</th>
              <th>Print</th>
              <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
            @for($a = 0; $a < count($data[$i]); $a++ )
            <tr>
              <td>
                {{ $data[$i][$a] }}
                <input class="penanda" value="{{ $data[$i][$a] }}" name="penanda" type="hidden" />
              </td>
              <td align="center">
                  <label class="label">
                    @foreach($hak_akses as $c=>$val)
                      @if($val->ha_menu == $data[$i][$a])
                        <input @if($val->aktif == 1) checked="" @endif  class="label__checkbox aksi" name="aksi" type="checkbox" />
                      @endif
                    @endforeach
                    <span class="label__text">
                      <span class="label__check">
                        <i class="fa fa-check icon"></i>
                      </span>
                    </span>
                  </label>
              </td>
              <td align="center">
                  <label class="label">
                  @foreach($hak_akses as $c=>$val)
                    @if($val->ha_menu == $data[$i][$a])
                      <input @if($val->tambah == 1) checked="" @endif  class="label__checkbox tambah" name="tambah" type="checkbox" />
                    @endif
                  @endforeach
                    <span class="label__text">
                      <span class="label__check">
                        <i class="fa fa-check icon"></i>
                      </span>
                    </span>
                  </label>
              </td>
              <td align="center">
                  <label class="label">
                  @foreach($hak_akses as $c=>$val)
                    @if($val->ha_menu == $data[$i][$a])
                      <input @if($val->ubah == 1) checked="" @endif  class="label__checkbox ubah" name="ubah" type="checkbox" />
                    @endif
                  @endforeach
                    <span class="label__text">
                      <span class="label__check">
                        <i class="fa fa-check icon"></i>
                      </span>
                    </span>
                  </label>
              </td>
              <td align="center">
                  <label class="label">
                  @foreach($hak_akses as $c=>$val)
                    @if($val->ha_menu == $data[$i][$a])
                      <input @if($val->hapus == 1) checked="" @endif class="label__checkbox print" name="print" type="checkbox" />
                    @endif
                  @endforeach
                    <span class="label__text">
                      <span class="label__check">
                        <i class="fa fa-check icon"></i>
                      </span>
                    </span>
                  </label>
              </td>
              <td align="center">
                    <label class="label">
                    @foreach($hak_akses as $c=>$val)
                      @if($val->ha_menu == $data[$i][$a])
                        <input @if($val->print == 1) checked="" @endif class="label__checkbox hapus" name="hapus" type="checkbox" />
                      @endif
                    @endforeach
                      <span class="label__text">
                        <span class="label__check">
                          <i class="fa fa-check icon"></i>
                        </span>
                      </span>
                    </label>
              </td>
            </tr>
            @endfor
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
@endforeach

<script type="text/javascript">
  $('.aksi').change(function(){
    var level = $('.level').val();
    var par = $(this).parents('tr');
    var tanda = $(par).find('.penanda').val();
    var aksi = $(this).is(':checked');
    $.ajax({
      url:baseUrl + '/setting/hak_akses/centang',
      data:{level,tanda,aksi},
      success:function(data){

      }
    });

  })

  $('.tambah').change(function(){
    var level = $('.level').val();
    var par = $(this).parents('tr');
    var tanda = $(par).find('.penanda').val();
    var tambah = $(this).is(':checked');
    $.ajax({
      url:baseUrl + '/setting/hak_akses/centang',
      data:{level,tanda,tambah},
      success:function(data){

      }
    });
  })

  $('.ubah').change(function(){
    var level = $('.level').val();
    var par = $(this).parents('tr');
    var tanda = $(par).find('.penanda').val();
    var ubah = $(this).is(':checked');
    $.ajax({
      url:baseUrl + '/setting/hak_akses/centang',
      data:{level,tanda,ubah},
      success:function(data){

      }
    });
  })

  $('.print').change(function(){
    var level = $('.level').val();
    var par = $(this).parents('tr');
    var tanda = $(par).find('.penanda').val();
    var print = $(this).is(':checked');
    $.ajax({
      url:baseUrl + '/setting/hak_akses/centang',
      data:{level,tanda,print},
      success:function(data){

      }
    });
  })

  $('.hapus').change(function(){
    var level = $('.level').val();
    var par = $(this).parents('tr');
    var tanda = $(par).find('.penanda').val();
    var hapus = $(this).is(':checked');
    $.ajax({
      url:baseUrl + '/setting/hak_akses/centang',
      data:{level,tanda,hapus},
      success:function(data){

      }
    });
  })
</script>
