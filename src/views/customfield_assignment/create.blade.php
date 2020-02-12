@extends('customfield::app')

@section('content')
<section class="content-header">
  <h3>
    Add Custom Field Assignment
  </h3>
</section>
<div class="content">
  <div class="box box-primary">
      <div class="box-body">
        <form method="post" action="{{ route('customfields_assignment.store') }}">
          @csrf

          <div class="form-group">
            <label for="type">Custom Field</label>
            <select class="form-control " name="customfield_id" id="field_type" style="width: 100%;"  >
            	@foreach($customFields as $customfield)
            		<option value="{{ $customfield->id }}">{{ $customfield->title }}</option>
            	@endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="type">Model</label>
            <select class="form-control " name="model" id="field_type" style="width: 100%;"  >
            	@foreach($models as $model)
            		<option value="{{ $model }}">{{ $model }}</option>
            	@endforeach
            </select>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create</button>
            <a href="{{ route('customfields_assignment.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection