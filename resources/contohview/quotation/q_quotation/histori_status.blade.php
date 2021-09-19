<table class="table table-hover table-bordered" cellspacing="0">
  <thead class="bg-gradient-info">
    <tr>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data_dt as $val)
    <tr>
      <td><span class="badge badge-pill badge-{{ $val->s_color }}">{{ $val->s_name }}</span></td>
    </tr>
    @endforeach
  </tbody>
</table>