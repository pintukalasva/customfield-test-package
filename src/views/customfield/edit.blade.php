@extends('customfield::app')

@section('content')
<section class="content-header">
  <h1>
    Edit Custom Field
  </h1>
</section>
<div class="content">
  <div class="box box-primary">
    <div class="box-body">
      <form method="post" action="{{ route('customfield.update',$customfield->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Field Title *</label>
            <input type="text" class="form-control" id="name" name="field_title" value="{{ $customfield->name }}">
        </div>

        <div class="form-group">
            <label for="type">Field Type</label>
            <input type="hidden" name="field_type" value="{{ $customfield->type }}">
            <select class="form-control " name="field_type" id="field_type" style="width: 100%;" disabled="">
                <option value="text" {{ $customfield->type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="number" {{ $customfield->type == 'number' ? 'selected' : '' }}>Number</option>
                <option value="email" {{ $customfield->type == 'email' ? 'selected' : '' }}>E-mail</option>
                <option value="textarea" {{ $customfield->type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                <option value="select" {{ $customfield->type == 'select' ? 'selected' : '' }}>Select</option>
                <option value="related_field" {{ $customfield->type == 'related_field' ? 'selected' : '' }}>Related Field</option>
                <option value="checkbox" {{ $customfield->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                <option value="radio" {{ $customfield->type == 'radio' ? 'selected' : '' }}>Radio Button</option>            
            </select>
        </div>
        
          <div class='repeater attribute'> 
            <div data-repeater-list="attribute" >
              <label for="type">Add field attributes </label>
              <div class="row">
                <div class="col-lg-5">
                  <label for="name">Name *</label>
                </div> 
                <div class="col-lg-5">
                  <label for="name">Value *</label>
                </div>                
              </div>
              @if($customfield->attributes->first())
              @foreach($customfield->attributes as $attribute)
              <div data-repeater-item class="row">
                <div class="col-lg-5" style="margin-bottom: 20px">
                    <input type="text" class="form-control"  name="attribute_name" value="{{ $attribute->name }}"  required="" placeholder="Add attribute like (min,max,required)">                    
                </div>
                <div class="col-lg-5">
                    <input type="text" class="form-control"  name="attribute_value" value="{{ $attribute->value }}" required="">                    
                </div>
                <div class="col-lg-2">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                </div>
              </div>
              @endforeach
              @else
              <div data-repeater-item class="row">
                <div class="col-lg-5" style="margin-bottom: 20px">
                    <input type="text" class="form-control"  name="attribute_name" value=""  required="" placeholder="Add attribute like (min,max,required)">                    
                </div>
                <div class="col-lg-5">
                    <input type="text" class="form-control"  name="attribute_value" value="" required="">                    
                </div>
                <div class="col-lg-2">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                </div>
              </div>                
              @endisset

            </div>

            <div class="row " style="margin-bottom: 20px">
              <div class="col-lg-12">
                <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
              </div>
            </div> 
          </div>
          
          
          @if( $customfield->type == 'related_field' )
          <div class="form-group select_model ">
            <label for="type">Select table name</label>
            <select class="form-control " name="table_name" id="table_name" style="width: 100%;"  required="">
                <option>select table</option>
                @foreach($tables as $table)
                <option value="{{ $table }}" {{ $customfield->table_name == $table ? 'selected' : '' }}>{{ $table }}</option>
                @endforeach
               
            </select>
          </div>

          <div class="form-group show_column ">
            <label for="type">Select column name</label>
            <select class="form-control " name="column_name" id="column_name" style="width: 100%;"required="">
              @foreach($columns as $column)
              <option value="{{ $column }}" {{ $column == $customfield->column_name ? 'selected' : '' }}>{{ $column }}</option>
              @endforeach
            </select>
          </div>   
        @endif
        <div class='repeater option_list'> 
        <div data-repeater-list="option_list" class="hide checkbox_field" id="checkbox_field">
          <label for="type">Field option</label>
          <div class="row">

            <div class="col-lg-5">
              <label for="name">Name *</label>
            </div> 
            <div class="col-lg-5">
              <label for="name">Value *</label>
            </div>                
          </div>
          @if($customfield->options)
            @foreach($customfield->options as $option)
            <div data-repeater-item class="row">
              <div class="col-lg-5" style="margin-bottom: 20px">
                  <input type="text" class="form-control"  name="option_name" value="{{ $option->name }}">                    
              </div>
              <div class="col-lg-5">
                  <input type="text" class="form-control"  name="option_value" value="{{ $option->value }}">                    
              </div>
              <div class="col-lg-2">
                  <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
              </div>
            </div>
            @endforeach
          @endif
        </div>
                <div class="row hide checkbox_field" style="margin-bottom: 20px">
          <div class="col-lg-12">
            <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
          </div>
        </div>
      </div>


        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Update</button>
        <a href="{{ route('customfield.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script>
  	var field_value = $('#field_type').val();
  	if(field_value == 'checkbox')
  	{
  		$('.checkbox_field').removeClass('hide');
  	}
    else if(field_value == 'select')
    {
        $('.checkbox_field').removeClass('hide');

    }
    else if(field_value == 'radio')
    {
        $('.checkbox_field').removeClass('hide');

    }
    
    $(function(){
      $('#field_type').change(function(){
          var value = $('#field_type').val();

          if(value == 'checkbox')
          {
            $('.checkbox_field').removeClass('hide');
          }
          else
          {
            $('.checkbox_field').addClass('hide');
          }
      });
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function () {
        $('.repeater').repeater({
           
        });
    });
        $('#table_name').change(function(){
          $('.show_column').removeClass('hide');
          $.ajax({
            url: "{{ route('customfield.getcolumnname') }}?tablename=" + $(this).val(),
            method: 'GET',
            success: function(data) {
              $('#column_name').html(data);
            }
          });            
        });
</script>
@endsection
