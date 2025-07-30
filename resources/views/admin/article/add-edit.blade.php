@extends('admin.layouts.app')

@section('page_title', isset($article->id) ? __('Edit Article') : __('Add Article'))

@section('contentheader_title', isset($article->id) ? __('Edit Article') : __('Add Article'))

@section('content')
<div class="card">
    <form role="form" method="post" id="addEditArticle"
        action="{{ isset($article->id) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}"
        enctype="multipart/form-data">
        @if (isset($article->id))
            @method('PUT')
        @endif
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- Title -->
                <div class="form-group col-md-6">
                    <label for="title" class="required">{{ __('Title') }}</label>
                    <input type="text"
                        class="form-control @error('title') is-invalid @enderror"
                        id="title"
                        name="title"
                        placeholder="{{ __('Enter article title') }}"
                        value="{{ old('title', $article->title ?? '') }}">
                    @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="form-group col-md-6">
                    <label for="slug" class="required">{{ __('Slug') }}</label>
                    <input type="text"
                        class="form-control @error('slug') is-invalid @enderror"
                        id="slug"
                        name="slug"
                        placeholder="{{ __('Enter slug') }}"
                        value="{{ old('slug', $article->slug ?? '') }}">
                    @error('slug')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sub Content -->
                <div class="form-group col-md-6">
                    <label for="sub_content" class="required">{{ __('Sub Content') }}</label>
                    <input type="text"
                        class="form-control @error('sub_content') is-invalid @enderror"
                        id="sub_content"
                        name="sub_content"
                        placeholder="{{ __('Enter sub content') }}"
                        value="{{ old('sub_content', $article->sub_content ?? '') }}">
                    @error('sub_content')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div class="form-group col-md-6">
                    <label for="category_id" class="required">{{ __('Category') }}</label>
                    <select name="category_id"
                        id="category_id"
                        class="form-control select2-withoutsearch @error('category_id') is-invalid @enderror"
                        required>
                        <option value="" disabled {{ old('category_id', $article->category_id ?? '') == '' ? 'selected' : '' }}>
                            {{ __('Please Select') }}
                        </option>
                        @foreach ($categories as $categ)
                        <option value="{{ $categ->id }}"
                            {{ old('category_id', $article->category_id ?? '') == $categ->id ? 'selected' : '' }}>
                            {{ $categ->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- User -->
                <div class="form-group col-md-6">
                    <label for="user_id" class="required">{{ __('User') }}</label>
                    <select name="user_id"
                        id="user_id"
                        class="form-control select2-withoutsearch @error('user_id') is-invalid @enderror"
                        required>
                        <option value="" disabled {{ old('user_id', $article->user_id ?? '') == '' ? 'selected' : '' }}>
                            {{ __('Please Select') }}
                        </option>
                        @foreach ($users as $usr)
                        <option value="{{ $usr->id }}"
                            {{ old('user_id', $article->user_id ?? '') == $usr->id ? 'selected' : '' }}>
                            {{ $usr->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Content -->
                <div class="form-group col-md-6">
                    <label for="content" class="required">{{ __('Content') }}</label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                        id="content"
                        name="content"
                        rows="3"
                        placeholder="{{ __('Enter content') }}">{{ old('content', $article->content ?? '') }}</textarea>
                    @error('content')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Published At -->
                <div class="form-group col-md-6">
                    <label for="published_at">{{ __('Published At') }}</label>
                    <input type="datetime-local"
                        class="form-control @error('published_at') is-invalid @enderror"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at', isset($article->published_at) ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                        max="{{ now()->format('Y-m-d') }}">
                    @error('published_at')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Featured -->
                <div class="form-group col-md-6">
                    <label class="d-block">{{ __('Is Featured') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                            class="custom-control-input"
                            id="is_featured"
                            name="is_featured"
                            value="1"
                            {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_featured">{{ __('Yes') }}</label>
                    </div>
                </div>

                <!-- Is Published -->
                <div class="form-group col-md-6">
                    <label class="d-block">{{ __('Is Published') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                            class="custom-control-input"
                            id="is_published"
                            name="is_published"
                            value="1"
                            {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_published">{{ __('Yes') }}</label>
                    </div>
                </div>

                <!-- Is Carousel -->
                <div class="form-group col-md-6">
                    <label class="d-block">{{ __('Is Carousel') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                            class="custom-control-input"
                            id="is_carousel"
                            name="is_carousel"
                            value="1"
                            {{ old('is_carousel', $article->is_carousel ?? false) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_carousel">{{ __('Yes') }}</label>
                    </div>
                </div>


                <!-- Single Image -->
                <div class="form-group col-md-6">
                    <label>{{ __('Main Image') }}</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    @if (!empty($article->featured_image))
                    <div class="mt-2">
                        <img src="{{ route('admin.file.serve', ['file_path' => $article->featured_image]) }}"
                            class="img-thumbnail"
                            style="max-width:120px;">
                    </div>
                    @endif
                </div>

                <!-- Multiple Images -->
                <div class="form-group col-md-6">
                    <label>{{ __('Gallery Images') }}</label>
                    <input type="file" class="form-control" name="gallery_images[]" accept="image/*" multiple>
                    @if(isset($article) && $article->media && $article->media->count())
                    <div class="d-flex flex-wrap">
                        @foreach($article->media as $media)
                        <div class="position-relative m-1" style="width: 100px;">
                            <img src="{{ route('admin.file.serve', ['file_path' => $media->file_name]) }}"
                                class="img-thumbnail"
                                style="width:100px; height:100px; object-fit:cover;">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                {{ isset($article->id) ? __('Update') : __('Submit') }}
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-default float-right">
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
        $("#addEditarticle").validate({
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
                    required: "{{ __('The article name field is required.') }}",
                    maxlength: "{{ __('The article name may not be greater than 40 characters.') }}",
                    minlength: "{{ __('The article name must be at least 3 characters.') }}"
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