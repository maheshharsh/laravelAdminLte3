@extends('admin.layouts.app')

@section('page_title', __('Advertisement Detail'))

@section('contentheader_title', __('Advertisement Detail'))

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <strong>{{__('Name')}}</strong>
                <p>{{ $advertisement->title }}</p>
            </div>
            <div class="form-group col-md-6">
                <label class="d-block font-weight-bold">{{ __('Advertisement Image') }}</label>

                @if (!empty($advertisement->adv_image))
                    <img src="{{ route('admin.file.serve', ['file_path' => $advertisement->adv_image]) }}"
                        alt="Advertisement Image"
                        class="img-fluid rounded"
                        style="max-height: 200px;">
                @else
                    <p class="text-danger">{{ __('No image available') }}</p>
                @endif
            </div>
    </div>
@endsection
