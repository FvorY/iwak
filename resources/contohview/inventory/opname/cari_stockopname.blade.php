
<table class="table table-hover data-table">
	
	<tbody>	
		@foreach ($data as $index => $a)
		  <tr>
	        <td>{{ $index+1 }}</td>
	        <td>{{ $a->i_name }}</td>
	        <td>{{ $a->i_unit }}</td>
	        <td><input type="text" name="" value="{{ $a->sg_qty }}" class="form-control right stock_system" readonly=""></td>
	        <td><input type="text" name="" class="form-control stock_real format_money_kosongan right" onkeyup="stock_real(this)"></td>
	        <td><input type="text" name="" class="form-control status_item" readonly=""></td>
	        <td><input type="text" name="" class="form-control right status_total" readonly=""></td>
	        <td><input type="text" name="" class="form-control" ></td>
	      </tr>
	    @endforeach
	</tbody>
</table>


