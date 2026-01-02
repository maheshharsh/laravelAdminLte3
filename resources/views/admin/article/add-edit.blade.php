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
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" name="image" accept="image/*">
                    <small class="form-text text-muted">
                        <strong>Max size: 2MB</strong> | Formats: JPG, PNG, WebP, GIF
                    </small>
                    @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <input type="file" class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror" name="gallery_images[]" accept="image/*" multiple>
                    <small class="form-text text-muted">
                        <strong>Max size per image: 2MB</strong> | Multiple images allowed
                    </small>
                    @error('gallery_images')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('gallery_images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                <!-- Video Section -->
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Video Content (Optional)') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Video File -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('Video File') }}</label>
                                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                           name="video_file" accept="video/mp4,video/avi,video/mov,video/wmv,video/flv,video/webm,video/mkv">
                                    <small class="form-text text-muted">
                                        <strong>Max size: 50MB</strong> | Formats: MP4, AVI, MOV, WMV, FLV, WebM, MKV
                                    </small>
                                    @error('video_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (!empty($article->video_file))
                                    <div class="mt-2">
                                        <video controls style="max-width: 300px; max-height: 200px;">
                                            <source src="{{ $article->video_file }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <p class="text-muted small mt-1">Current video file</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Video Thumbnail -->
                                <div class="form-group col-md-6">
                                    <label>{{ __('Video Thumbnail') }}</label>
                                    <input type="file" class="form-control @error('video_thumbnail') is-invalid @enderror" 
                                           name="video_thumbnail" accept="image/*">
                                    <small class="form-text text-muted">
                                        <strong>Max size: 2MB</strong> | Formats: JPG, PNG, WebP, GIF
                                    </small>
                                    @error('video_thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if (!empty($article->video_thumbnail))
                                    <div class="mt-2">
                                        <img src="{{ $article->video_thumbnail }}"
                                            class="img-thumbnail"
                                            style="max-width:200px; max-height:150px;">
                                        <p class="text-muted small mt-1">Current video thumbnail</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Video Description -->
                                <div class="form-group col-md-12">
                                    <label>{{ __('Video Description') }}</label>
                                    <textarea class="form-control @error('video_description') is-invalid @enderror" 
                                        name="video_description" 
                                        rows="3" 
                                        maxlength="1000"
                                        placeholder="{{ __('Enter video description (optional)') }}">{{ old('video_description', $article->video_description ?? '') }}</textarea>
                                    <small class="form-text text-muted">Maximum 1000 characters</small>
                                    @error('video_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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
        // File size validation functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function validateFileSize(input, maxSizeMB, errorMessage) {
            const file = input.files[0];
            if (file) {
                const maxBytes = maxSizeMB * 1024 * 1024;
                if (file.size > maxBytes) {
                    alert(errorMessage + '\nSelected file: ' + formatFileSize(file.size) + '\nMax allowed: ' + maxSizeMB + 'MB');
                    input.value = '';
                    return false;
                }
            }
            return true;
        }

        // Video file validation (50MB)
        $('input[name="video_file"]').on('change', function() {
            validateFileSize(this, 50, 'Video file is too large!');
        });

        // Image files validation (2MB)
        $('input[name="image"], input[name="video_thumbnail"]').on('change', function() {
            validateFileSize(this, 2, 'Image file is too large!');
        });

        // Gallery images validation
        $('input[name="gallery_images[]"]').on('change', function() {
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const maxBytes = 2 * 1024 * 1024; // 2MB
                if (file.size > maxBytes) {
                    alert('Gallery image "' + file.name + '" is too large!\nFile size: ' + formatFileSize(file.size) + '\nMax allowed: 2MB');
                    this.value = '';
                    break;
                }
            }
        });

        // Form validation
        $("#addEditarticle").validate({
            rules: {
                title: {
                    required: true,
                    maxlength: 255
                },
                slug: {
                    required: true,
                    maxlength: 255
                },
                category_id: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "{{ __('The title field is required.') }}",
                    maxlength: "{{ __('The title may not be greater than 255 characters.') }}"
                },
                slug: {
                    required: "{{ __('The slug field is required.') }}",
                    maxlength: "{{ __('The slug may not be greater than 255 characters.') }}"
                },
                category_id: {
                    required: "{{ __('Please select a category.') }}"
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
                // Final file size check before submit
                const videoFile = document.querySelector('input[name="video_file"]');
                const imageFile = document.querySelector('input[name="image"]');
                const thumbnailFile = document.querySelector('input[name="video_thumbnail"]');
                
                if (videoFile && videoFile.files[0] && videoFile.files[0].size > 50 * 1024 * 1024) {
                    alert('Video file is too large! Maximum size allowed is 50MB.');
                    return false;
                }
                
                if (imageFile && imageFile.files[0] && imageFile.files[0].size > 2 * 1024 * 1024) {
                    alert('Image file is too large! Maximum size allowed is 2MB.');
                    return false;
                }
                
                if (thumbnailFile && thumbnailFile.files[0] && thumbnailFile.files[0].size > 2 * 1024 * 1024) {
                    alert('Video thumbnail is too large! Maximum size allowed is 2MB.');
                    return false;
                }

                // Show loading state
                $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
                form.submit();
            }
        });

        CKEDITOR.replace('content');

        $('.select2-withoutsearch').select2({
            minimumResultsForSearch: Infinity,
            width: '100%',
            placeholder: "Select an option"
        });
    });
</script>
@endsection