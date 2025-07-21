@extends('admin.layouts.app')

@section('page_title', __('User Detail'))

@section('contentheader_title', __('User Detail'))

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <strong>{{__('Name')}}</strong>
                <p>{{ $user->name }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Email')}}</strong>
                <p>{{ $user->email }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Mobile Number')}}</strong>
                <p>{{ $user->mobileno }}</p>
            </div>
            <div class="form-group col-md-6">
                <strong>{{__('Gender')}}</strong>
                <p>{{ $user->gender ? 'Male' : 'Female' }}</p>
            </div>
            
            <div class="form-group col-md-6">
                <strong>{{__('Status')}}</strong>
                <p>{{ $user->status ? 'Active' : 'Inactive'}}</p>
            </div>
            <div class="col-md-6">
                <strong>{{__('Role')}}</strong>
                <p>{{ $user->getRoleNames()->first() }}</p>
            </div>
            @if($user->getPermissionNames()->first())
            <div class="col-md-6">
                <strong>{{__('Additional Permission')}}</strong>
                <ol class="px-3" type="1">
                @foreach($user->getPermissionNames() as $permission)
                    <li>{{ $permission }}</li>
                @endforeach
                </ol>
            </div>
            @endif
            <div class="form-group col-md-6">
                <strong>{{__('User image')}}</strong>
                <p>
                @if(isset($user->profile_image))
                    <img src="{{ route('admin.file.serve', ['file_path' => $user->profile_image]) }}" class="user-image" >
                @else
                    {{ config('constants.empty_value') }}
                @endif
                <p>
            </div>
        </div>
    </div>
@endsection
