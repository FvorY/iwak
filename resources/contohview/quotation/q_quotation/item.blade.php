<select style="width: 100%" class="form-control form-control-sm item" name="item">
	<option value="0">--Select Item</option>
	@foreach($item as $i )
	<option value="{{ $i->np_kode }}">{{ $i->np_kode }} - {{ $i->i_name }}</option>
	@endforeach
</select>