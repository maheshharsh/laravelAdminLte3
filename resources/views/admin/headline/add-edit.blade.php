@extends('admin.layouts.app')

@section('page_title', isset($headline->id) ? __('Edit Headline') : __('Add Headline'))
@section('contentheader_title', isset($headline->id) ? __('Edit Headline') : __('Add Headline'))

@section('content')
    <div class="card">
        <form role="form" method="post" id="addEditHeadline"
            action="{{ isset($headline->id) ? route('admin.headlines.update', $headline->id) : route('admin.headlines.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if (isset($headline->id))
                @method('PUT')
            @endif

            <div class="card-body">
                {{-- Title --}}
                <div class="form-group">
                    <label for="title" class="required">{{ __('Title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="{{ __('Enter headline title') }}"
                        value="{{ old('title', $headline->title ?? '') }}">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="form-group">
                    <label for="category_id" class="required">{{ __('Category') }}</label>
                    <select name="category_id" class="form-control select2-withoutsearch" id="category_id" required>
                        <option value="" disabled {{ empty(old('category_id', $headline->category_id ?? '')) ? 'selected' : '' }}>
                            {{ __('Please Select') }}
                        </option>
                        @foreach ($category as $categ)
                            <option value="{{ $categ->id }}"
                                {{ (old('category_id') == $categ->id || (isset($headline) && $headline->category_id == $categ->id)) ? 'selected' : '' }}>
                                {{ $categ->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

               {{-- Content --}}
                <div class="form-group">
                    <label for="content" class="required">{{ __('Content') }}</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content"
                        name="content" placeholder="{{ __('Enter content') }}">{{ old('content', $headline->content ?? '') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    {{ isset($headline->id) ? __('Update') : __('Submit') }}
                </button>
                <a href="{{ route('admin.headlines.index') }}" class="btn btn-default float-right">
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
            $('#addEditHeadline').validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 100,
                        minlength: 3
                    },
                    content: {
                        required: true,
                        maxlength: 255,
                        minlength: 3
                    },
                    category: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "{{ __('The title field is required.') }}",
                        maxlength: "{{ __('The title may not be greater than 100 characters.') }}",
                        minlength: "{{ __('The title must be at least 3 characters.') }}"
                    },
                    content: {
                        required: "{{ __('The content field is required.') }}",
                        maxlength: "{{ __('The content may not be greater than 255 characters.') }}",
                        minlength: "{{ __('The content must be at least 3 characters.') }}"
                    },
                    category: {
                        required: "{{ __('Please select a category.') }}"
                    }
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
