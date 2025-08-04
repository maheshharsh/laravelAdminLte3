@extends('admin.layouts.app')

@section('page_title', __('Commodities Detail'))

@section('contentheader_title', __('Commodities Detail'))

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <strong>{{__('Title')}}</strong>
                <p>{{ $commodity->title }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Category')}}</strong>
                <p>{{ $commodity->category->name }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Price')}}</strong>
                <p>{{ $commodity->price }}</p>
            </div>
    </div>
@endsection
