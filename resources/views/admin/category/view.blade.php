@extends('admin.layouts.app')

@section('page_title', __('Category Detail'))

@section('contentheader_title', __('Category Detail'))

@section('content')
<div class="card-body">
    <div class="row">
        <div class="form-group col-md-6">
            <strong>{{__('Name')}}</strong>
            <p>{{ $category->name }}</p>
        </div>
    </div>
</div>
@endsection
