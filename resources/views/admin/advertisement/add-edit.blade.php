@extends('admin.layouts.app')

@section('page_title', isset($advertisement->id) ? __('Edit Advertisement') : __('Add Advertisement'))

@section('contentheader_title', isset($advertisement->id) ? __('Edit Advertisement') : __('Add Advertisement'))

@section('content')
    <div class="card">
        <form role="form" method="post" id="addEditadvertisement"
            action="{{ isset($advertisement->id) ? route('admin.advertisements.update', $advertisement->id) : route('admin.advertisements.store') }}"
            enctype="multipart/form-data">
            @if (isset($advertisement->id))
                @method('PUT')
            @endif
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="required">{{ __('Title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="{{ __('Enter advertisement title') }}"
                        value="{{ old('name', $advertisement->title ?? '') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label>{{ __('Image') }}</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="image" accept="image/*" id="image">
                        <div class="input-group-append">
                            <label class="input-group-text" for="image">Browse</label>
                        </div>
                    </div>
                    @if (isset($advertisement->adv_image))
                        <div class="deletable_image">
                            <img class="p-1"
                                src="{{ route('admin.file.serve', ['file_path' => $advertisement->adv_image]) }}" height="80px"
                                width="80px">
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    {{ isset($advertisement->id) ? __('Update') : __('Submit') }}
                </button>
                <a href="{{ route('admin.advertisements.index') }}" class="btn btn-default float-right"> 
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
            $("#addEditadvertisement").validate({
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
                        required: "{{ __('The advertisement name field is required.') }}",
                        maxlength: "{{ __('The advertisement name may not be greater than 40 characters.') }}",
                        minlength: "{{ __('The advertisement name must be at least 3 characters.') }}"
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
