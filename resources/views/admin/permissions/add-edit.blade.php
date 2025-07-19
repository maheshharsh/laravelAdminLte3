@extends('admin.layouts.app')

@section('page_title', isset($permission->id) ? __('Edit permission') : __('Add permission') )

@section('contentheader_title', isset($permission->id) ? __('Edit permission') : __('Add permission') )

@section('content')
    <form role="form" method="post" id="addEditPermission" action="@if(isset($permission->id)){{ route('admin.permissions.update', ['permission' => $permission->id]) }}@else{{ route('admin.permissions.store') }}@endif" enctype="multipart/form-data">
        @if(isset($permission->id))
            @method('PUT')
        @endif

        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name" class="requiredField">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder={{ __('Name') }} value="@if(isset($permission->name)){{ old('name', $permission->name) }}@else{{ old('name') }}@endif">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ isset($permission->id) ? __('Update') : __('Submit') }}</button>
        </div>
    </form>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#addEditPermission').validate({
            rules: {
              name: {
                required: true,
                maxlength:40,
              },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });

    });
</script>
@endsection
