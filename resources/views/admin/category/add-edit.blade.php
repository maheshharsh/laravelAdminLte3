@extends('admin.layouts.app')

@section('page_title', isset($category->id) ? __('Edit Category') : __('Add Category'))

@section('contentheader_title', isset($category->id) ? __('Edit Category') : __('Add Category'))

@section('content')
    <div class="card">
        <form role="form" method="post" id="addEditCategory"
            action="{{ isset($category->id) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
            enctype="multipart/form-data">
            @if (isset($category->id))
                @method('PUT')
            @endif
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="required">{{ __('Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="{{ __('Enter category name') }}"
                        value="{{ old('name', $category->name ?? '') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug" class="required">{{ __('Slug') }}</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                        name="slug" placeholder="{{ __('Enter category slug') }}"
                        value="{{ old('slug', $category->slug ?? '') }}">
                    @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    {{ isset($category->id) ? __('Update') : __('Submit') }}
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-right">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- jQuery Validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#addEditcategory").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 40,
                        minlength: 3
                    },
                    slug: {
                        required: true,
                        maxlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "{{ __('The category name field is required.') }}",
                        maxlength: "{{ __('The category name may not be greater than 40 characters.') }}",
                        minlength: "{{ __('The category name must be at least 3 characters.') }}"
                    },
                    slug: {
                        required: "{{ __('The slug field is required.') }}",
                        maxlength: "{{ __('The slug may not be greater than 20 characters.') }}"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    // Disable submit button to prevent multiple submissions
                    $('button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });
        });
    </script>
@endsection
