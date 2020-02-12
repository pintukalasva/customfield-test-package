@extends('customfield::app')
@section('content')
<section class="content-header">
  <h3>
      Custom Fields Assignment
      <a href="{{ route('customfields_assignment.create') }}" class="btn btn-primary btn-flat">Add CustomField Assignment</a>
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
                <th>CustomField ID</th>   
                <th>Model</th>
                <th colspan="2">Action</th>
                
            </tr>
        </thead>
        <tbody>
          @foreach($customfields_assignment as $assignment)
            <tr>
              <td>{{ $assignment->id }}</td>
                <td>{{ $assignment->custom_field_id }}</td>
                <td>{{ $assignment->model }}</td>
                <td><a href="{{  route('customfields_assignment.edit',$assignment->id) }}" class="btn btn-flat btn-success btn-sm"><i class="fa fa-edit"></i>edit</a></td>
                <td><form action="{{ route('customfields_assignment.destroy',$assignment->id) }}" method="post" onsubmit="return confirm('Are you sure want to dalete ?');" style="display: inline;">
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