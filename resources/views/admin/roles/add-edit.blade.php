@extends('admin.layouts.app')

@section('page_title', isset($role->id) ? __('Edit Role') : __('Add Role') )

@section('contentheader_title', isset($role->id) ? __('Edit Role') : __('Add Role') )

@section('content')
<div class="container-fluid">
    <!-- form start -->
    <form role="form" method="post" id="addEditRole" action="@if(isset($role->id)){{ route('admin.roles.update', ['role' => $role->id]) }}@else{{ route('admin.roles.store') }}@endif" enctype="multipart/form-data">
        @if(isset($role->id))
            @method('PUT')
        @endif

        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name" class="requiredField">{{ __('Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder={{ __('Name') }} value="@if(isset($role->name)){{ old('name', $role->name) }}@else{{ old('name') }}@endif">
            </div>

            <div class="row">
                <div class="col-12">
                <div class="form-group">
                    @if(isset($role->id))
                        @php
                            $rolePermissions = $role->permissions()->pluck('id')->toArray();
                        @endphp
                    @endif
                    <label>{{ __('Add Permissions') }}</label>
                    <select class="duallistbox" name="permissions[]" multiple="multiple">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ (isset($rolePermissions) && (in_array($permission->id, $rolePermissions))) ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $permission->name)) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- /.form-group -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ isset($role->id) ? __('message.update') : __('message.submit') }}</button>
        </div>
    </form>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox();
        $(".moveall").html("<i class='fa fa-arrow-right'></i>");
        $(".removeall").html("<i class='fa fa-arrow-left'></i>");
        $('#addEditRole').validate({
            rules: {
              name: {
                required: true
              },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
            }
        });

    });
</script>
@endsection
