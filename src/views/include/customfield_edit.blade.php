<div class="row">
  @php
    $i = 1;
    $value ="";
  @endphp

  @foreach($custom_fields as $custom_field)
    @php
        if(isset($custom_field->pivot->field_value))
        {
          $value = $custom_field->pivot->field_value;
        }

    @endphp
    @if($custom_field->type == 'text' || $custom_field->type == 'number' || $custom_field->type == 'email')
      <div class="col-md-3">
        <div class="form-group">
            <label> {{ $custom_field->title }} </label>
            <input type="{{ $custom_field->type }}" name="{{ $custom_field->name }}" value="{{ $value }}" @foreach($custom_field->attributes  as $attribute ) {{ $attribute->name }} ="{{ $attribute->value }}" @endforeach class="form-control">
        </div>
      </div>
    @endif
    
    @if($custom_field->type == 'textarea')
      <div class="col-md-3">
        <div class="form-group">
            <label>{{ $custom_field->title }}</label>
            <textarea rows="3" class="form-control" name="{{ $custom_field->name }}">{{ $value }}</textarea>
        </div>
      </div>                  
    @endif

    @if($custom_field->type == 'select')
      <div class="col-md-3">
        <div class="form-group">
            <label>{{ $custom_field->title }}</label>
            <select class="form-control" name="{{ $custom_field->name }}">
              @foreach($custom_field->options as $option)
                <option value="{{ $option->value }}" {{ $option->value == $value ? 'selected' : '' }}> {{ $option->name }} </option>
              @endforeach
            </select>
        </div>
      </div>                  
    @endif

    @if($custom_field->type == 'related_field')
    <div class="col-md-3">
      <div class="form-group">
        @php
          $related_column = DB::table($custom_field->table_name)->get();
        @endphp
          <label>{{ $custom_field->title }}</label>
          <select class="form-control" name="{{ $custom_field->name }}">
            @foreach($related_column as $column_value)
              <option value="{{ $column_value->id }}" {{ $column_value->id == $value ? 'selected' : '' }}> {{ $column_value->{$custom_field->column_name} }} </option>
            @endforeach
          </select>
      </div>
    </div>
  @endif                  

    @if($custom_field->type == 'checkbox')
      <div class="col-md-3">
        <div class="form-group">
            <label>{{ $custom_field->title }}</label>
            @foreach($custom_field->options as $option)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $custom_field->name }}[]" value="{{ $option->value }}" id="{{ $option->value }}" {{ in_array($option->value, explode(',', $value)) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $option->value }}">
                  {{ $option->name }}
                </label>
              </div>
            @endforeach
        </div>
      </div>
    @endif

    @if($custom_field->type == 'radio')
      <div class="col-md-3">
        <div class="form-group">
            <label>{{ $custom_field->title }}</label>
            @foreach($custom_field->options as $option)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $custom_field->name }}" value="{{ $option->value }}" id="{{ $option->value }}" {{ $option->value == $value ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $option->value }}">
                  {{ $option->name }}
                </label>
              </div>
            @endforeach
        </div>
      </div>
    @endif
  @php
    $value ="";
  @endphp
  @endforeach  
</div>