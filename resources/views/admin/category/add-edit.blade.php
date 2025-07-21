@extends('admin.layouts.app')

@section('page_title', isset($category->id) ? __('Edit category') : __('Add category') )

@section('contentheader_title', isset($category->id) ? __('Edit category') : __('Add category') )

@section('content')
    <form role="form" method="post" id="addEditcategory" action="@if(isset($category->id)){{ route('admin.category.update', ['category' => $category->id]) }}@else{{ route('admin.category.store') }}@endif" enctype="multipart/form-data">
        @if(isset($category->id))
            @method('PUT')
        @endif

        @csrf
        <div class="card-body">
            <div class="form-group col-md-6">
                <label for="name" class="requiredField">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder={{ __('Name') }} value="@if(isset($category->name)){{ old('name', $category->name) }}@else{{ old('name') }}@endif">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ isset($category->id) ? __('message.update') : __('message.submit') }}</button>
        </div>
    </form>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#addEditcategory').validate({
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
