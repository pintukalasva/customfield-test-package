@foreach($custom_fields as $customfiled)
	@if($customfiled->type == 'related_field')
		@php
		$related_column = DB::table($customfiled->table_name)->where('id',$customfiled->pivot->field_value)->first();
		@endphp
		<tr>
			<td><b>{{ $customfiled->title }}<b></td>
			<td>{{ $related_column->{$customfiled->column_name} }}</td>
		</tr>
	@else
		<tr>
			<td><b>{{ $customfiled->title }}<b></td>
			<td>{{ $customfiled->pivot->field_value }}</td>
		</tr>														
	@endif
@endforeach
