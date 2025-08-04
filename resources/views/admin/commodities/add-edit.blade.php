@extends('admin.layouts.app')

@section('page_title', isset($commodities->id) ? __('Edit Commodities') : __('Add Commodities'))
@section('contentheader_title', isset($commodities->id) ? __('Edit Commodities') : __('Add Commodities'))

@section('content')
    <div class="card">
        <form role="form" method="post" id="addEditcommodities"
            action="{{ isset($commodities->id) ? route('admin.commodities.update', $commodities->id) : route('admin.commodities.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if (isset($commodities->id))
                @method('PUT')
            @endif

            <div class="card-body">
                {{-- Title --}}
                <div class="form-group">
                    <label for="title" class="required">{{ __('Title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="{{ __('Enter commodities title') }}"
                        value="{{ old('title', $commodities->title ?? '') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

               {{-- Price --}}
                <div class="form-group">
                    <label for="price" class="required">{{ __('Price') }}</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                        name="price" placeholder="{{ __('Enter price') }}"
                        value="{{ old('price', $commodities->price ?? '') }}">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    {{ isset($commodities->id) ? __('Update') : __('Submit') }}
                </button>
                <a href="{{ route('admin.commoditiess.index') }}" class="btn btn-default float-right">
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
        $(document).ready(function () {
            $('#addEditcommodities').validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 100,
                        minlength: 3
                    },
                    price: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "{{ __('The title field is required.') }}",
                        maxlength: "{{ __('The title may not be greater than 100 characters.') }}",
                        minlength: "{{ __('The title must be at least 3 characters.') }}"
                    },
                    price: {
                        required: "{{ __('The price field is required.') }}",
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    $('button[type="submit"]').prop('disabled', true);
                    form.submit();
                }
            });
        });
    </script>
@endsection
