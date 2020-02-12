@extends('customfield::app')
@section('content')
<section class="content-header">
  <h3>
    	Custom Fields
      <a href="{{ route('customfield.create') }}" class="btn btn-primary btn-flat">Add Custom Field</a>
  </h3>

</section>

<section class="content" style="margin-top: 20px;">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
        @if(session('success'))
          <div class="alert alert-success" style="margin-bottom: 20px;">
              {{ session('success') }}
          </div>
        @endif
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-body">
            <table id="example" class="table table-bordered display" style="width:100%">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Field Title</th>
                <th>Field Type</th>
                <th colspan="2">Actions</th>
                
            </tr>
        </thead>
        <tbody>
        	@foreach($customfields as $fields)
            <tr>
            	<td>{{ $fields->id }}</td>
                <td>{{ $fields->title }}</td>
                <td>{{ $fields->type }}</td>
                <td><a href="{{  route('customfield.edit',$fields->id) }}" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i>edit</a></td>
                <td><form action="{{ route('customfield.destroy',$fields->id) }}" method="post" onsubmit="return confirm('Are you sure want to dalete ?');" style="display: inline;">
					@csrf
					<input type="hidden" name="_method" value="delete">
					<button type="submit" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash-o"></i>delete</button>
					</form>
				</td>
            </tr>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    $('#example').DataTable();
	} );
</script>
@endsection