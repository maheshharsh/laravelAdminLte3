@extends('admin.layouts.app')

@section('page_title', __('Article Detail'))

@section('contentheader_title', __('Article Detail'))

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <strong>{{__('Title')}}</strong>
                <p>{{ $article->title }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Slug')}}</strong>
                <p>{{ $article->slug }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Sub Content')}}</strong>
                <p>{{ $article->sub_content }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Content')}}</strong>
                <p>{{ $article->content }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Category')}}</strong>
                <p>{{ $article->category->name }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('User')}}</strong>
                <p>{{ $article->user->name }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Published At')}}</strong>
                <p>{{ $article->published_at }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Is Featured')}}</strong>
                <p>{{ $article->is_featured ? 'True' : 'False' }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Is Published')}}</strong>
                <p>{{ $article->is_published ? 'True' : 'False' }}</p>
            </div>

            <div class="form-group col-md-6">
                <strong>{{__('Is Carousel')}}</strong>
                <p>{{ $article->is_carousel ? 'True' : 'False' }}</p>
            </div>

            <div class="form-group col-md-6">
                <label class="d-block font-weight-bold">{{ __('Featured Image') }}</label>

                @if (!empty($article->featured_image))
                    <img src="{{ route('admin.file.serve', ['file_path' => $article->featured_image]) }}"
                        alt="Article Image"
                        class="img-fluid rounded"
                        style="max-height: 200px;">
                @else
                    <p class="text-danger">{{ __('No image available') }}</p>
                @endif
            </div>

           <div class="form-group col-md-6">
            <label class="d-block font-weight-bold">{{ __('Gallery Images') }}</label>

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
            @else
                <p class="text-danger mb-0">{{ __('No images available') }}</p>
            @endif
        </div>

    </div>
@endsection
