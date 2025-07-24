@extends('admin.layouts.app')

@section('page_title', __('Headline Detail'))

@section('contentheader_title', __('Headline Detail'))

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <strong>{{__('Name')}}</strong>
                <p>{{ $headline->title }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Category')}}</strong>
                <p>{{ $headline->category->name }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Content')}}</strong>
                <p>{{ $headline->content }}</p>
            </div>
    </div>
@endsection
