@extends('admin.layouts.app')

@section('page_title', isset($permission->id) ? __('Edit Permission') : __('Add Permission'))

@section('contentheader_title', isset($permission->id) ? __('Edit Permission') : __('Add Permission'))

@section('content')
    <div class="card">
        <form role="form" method="post" id="addEditPermission"
            action="{{ isset($permission->id) ? route('admin.permissions.update', $permission->id) : route('admin.permissions.store') }}"
            enctype="multipart/form-data">
            @if (isset($permission->id))
                @method('PUT')
            @endif
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="required">{{ __('Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="{{ __('Enter permission name') }}"
                        value="{{ old('name', $permission->name ?? '') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    {{ isset($permission->id) ? __('Update') : __('Submit') }}
                </button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-right">
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
            $("#addEditPermission").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 40,
                        minlength: 3
                    },
                    guard_name: {
                        required: true,
                        maxlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "{{ __('The permission name field is required.') }}",
                        maxlength: "{{ __('The permission name may not be greater than 40 characters.') }}",
                        minlength: "{{ __('The permission name must be at least 3 characters.') }}"
                    },
                    guard_name: {
                        required: "{{ __('The guard name field is required.') }}",
                        maxlength: "{{ __('The guard name may not be greater than 20 characters.') }}"
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
