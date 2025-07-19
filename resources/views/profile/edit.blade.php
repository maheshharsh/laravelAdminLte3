{{-- <x-app-layout> --}}
@extends('admin.layouts.app')

@section('page_title', isset($barber->id) ? __('Profile') : __('Profile'))

@section('contentheader_title', isset($barber->id) ? __('Profile') : __('Profile'))

@section('content')
    <div class="py-12">
        <div class="max-w-7xl  sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- </x-app-layout> --}}
