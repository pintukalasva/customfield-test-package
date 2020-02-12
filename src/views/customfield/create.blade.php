@extends('customfield::app')
@section('content')
<section class="content-header">
  <h3>
    Add Custom Field
  </h3>
</section>

<div class="content">
  <div class="box box-primary">
      <div class="box-body">
        <form method="post" action="{{ route('customfield.store') }}">
 		@csrf

          <div class="form-group">
            <label for="name">Field Title *</label>
            <input type="text" class="form-control" id="field_title" name="field_title" required="">
          </div>

          <div class="form-group">
            <label for="type">Field Type</label>
            <select class="form-control " name="field_type" id="field_type" style="width: 100%;"  >
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="email">E-mail</option>
                <option value="textarea">Textarea</option>
                <option value="select">Select</option>
                <option value="related_field">Related Field</option>
                <option value="checkbox">Checkbox</option>
                <option value="radio">Radio Button</option>
            </select>
          </div>                

          <div class='repeater attribute'> 
            <div data-repeater-list="attribute" >
              <label for="type"> Add field attributes </label>
              <div class="row">
                <div class="col-lg-5">
                  <label for="name">Name *</label>
                </div> 
                <div class="col-lg-5">
                  <label for="name">Value *</label>
                </div>                
              </div>
              <div data-repeater-item class="row">
                <div class="col-lg-5" style="margin-bottom: 20px">
                    <input type="text" class="form-control"  name="attribute_name" required="" placeholder="Add attribute like (min,max,required,etc.)">                    
                </div>
                <div class="col-lg-5">
                    <input type="text" class="form-control"  name="attribute_value" required="">                    
                </div>
                <div class="col-lg-2">
                    <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                </div>
              </div>
            </div>

            <div class="row " style="margin-bottom: 20px">
              <div class="col-lg-12">
                <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
              </div>
            </div> 
          </div>

          <div class="form-group select_model hide">
            <label for="type">Select table name</label>
            <select class="form-control " name="table_name" id="table_name" style="width: 100%;" required="">
                <option>select table</option>
                @foreach($tables as $table)
                <option value="{{ $table }}">{{ $table }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group show_column hide">
            <label for="type">Select column name</label>
            <select class="form-control " name="column_name" id="column_name" style="width: 100%;" disabled="" required="">
              <option>select column</option>
            </select>
          </div>   
      
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
            <div data-repeater-item class="row">
              <div class="col-lg-5" style="margin-bottom: 20px">
                  <input type="text" class="form-control"  name="option_name">                    
              </div>
              <div class="col-lg-5">
                  <input type="text" class="form-control"  name="option_value">                    
              </div>              
              <div class="col-lg-2">
                  <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
              </div>
            </div>
          </div>

          <div class="row hide checkbox_field" style="margin-bottom: 20px">
            <div class="col-lg-12">
              <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
            </div>
          </div>
        </div>
		    <div class="form-group">
           <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check"></i> Create</button>
          <a href="{{ route('customfield.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
    $(function(){
          function myFunction(){
                $('.select_model').addClass('hide');
                $('.show_column').addClass('hide');
                $('#table_name').prop('disabled' , true);
                $('#column_name').prop('disabled' , true);        
          }

          function disable_attribute()
          {
              $(".attribute *").attr("disabled", "disabled").off('click');
              $('.attribute').addClass('hide');          
          }
          function anable_attribute()
          {
              $('.attribute').removeClass('hide');
              $(".attribute *").attr("disabled", false);
                        
          }
        $('#field_type').change(function(){
          var value = $('#field_type').val();

          if(value == 'checkbox' )
          {
           
            myFunction();
            anable_attribute();
            $('.checkbox_field').removeClass('hide');
          }
          else if(value == 'select')
          {
            
            myFunction();
            anable_attribute();
            $('.checkbox_field').removeClass('hide');

              function validateFm() {
                $(".validatForm").validate({
                  rules: {
                    field_title: {
                      required: true
                    }
                  }
                });
              }
          }
          else if(value == 'related_field')
          {
            disable_attribute();
            $('.checkbox_field').addClass('hide');
            $('.select_model').removeClass('hide');
            $('#table_name').prop('disabled' , false);
            $('#column_name').prop('disabled' , false);
          }
          else if(value == 'radio')
          {
            myFunction();
             anable_attribute();          
              $('.checkbox_field').removeClass('hide');

          }
          else
          {
            myFunction();
            anable_attribute();
            $('.checkbox_field').addClass('hide');
          }

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
      });

        

</script>

<script>
    $(document).ready(function () {
        $('.repeater').repeater({
           
        });
    });
</script>
@endsection
