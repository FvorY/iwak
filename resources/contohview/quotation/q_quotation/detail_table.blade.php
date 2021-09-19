<table class="table table-hover table-bordered" cellspacing="0">
<thead class="bg-gradient-info">
  <tr>
    <th>Item Name</th>
    <th>Qty</th>
  </tr>
</thead>
<tbody>
	@foreach($data_dt as $val)
  <tr>
    <td>{{ $val->i_name }}</td>
    <td>{{ $val->qd_qty }}</td>
  </tr>
  @endforeach
</tbody>
</table>