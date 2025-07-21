@extends('admin.layouts.app')

@section('page_title', isset($role->id) ? __('Edit Role') : __('Add Role'))

@section('contentheader_title', isset($role->id) ? __('Edit Role') : __('Add Role'))

@section('content')
    <div class="container-fluid">
        <!-- form start -->
        <form role="form" method="post" id="addEditRole"
            action="@if (isset($role->id)) {{ route('admin.roles.update', ['role' => $role->id]) }}@else{{ route('admin.roles.store') }} @endif"
            enctype="multipart/form-data">
            @if (isset($role->id))
                @method('PUT')
            @endif

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="requiredField">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder={{ __('Name') }}
                        value="@if (isset($role->name)) {{ old('name', $role->name) }}@else{{ old('name') }} @endif">
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            @if (isset($role->id))
                                @php
                                    $rolePermissions = $role->permissions()->pluck('id')->toArray();
                                @endphp
                            @endif
                            <label>{{ __('Add Permissions') }}</label>
                            <select class="duallistbox" name="permissions[]" multiple="multiple">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}"
                                        {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}</option>
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
                <button type="submit"
                    class="btn btn-primary">{{ isset($role->id) ? __('message.update') : __('message.submit') }}</button>
            </div>
        </form>

    @endsection

    @section('javascript')
        <!-- Bootstrap Duallistbox -->
        <link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
        <script src="{{ asset('admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize duallistbox
                $('.duallistbox').bootstrapDualListbox({
                    selectorMinimalHeight: 300,
                    moveOnSelect: false,
                    nonSelectedListLabel: 'Available Permissions',
                    selectedListLabel: 'Assigned Permissions',
                    preserveSelectionOnMove: 'moved',
                    moveAllLabel: 'Move all',
                    removeAllLabel: 'Remove all',
                    infoText: 'Showing all {0}',
                    infoTextFiltered: '<span class="badge badge-warning">Filtered</span> {0} from {1}',
                    infoTextEmpty: 'Empty list',
                    filterPlaceHolder: 'Filter',
                filterTextClear: 'Show all'
            });

                // Customize buttons if needed
                $(".moveall i").removeClass('glyphicon-arrow-right').addClass('fa fa-arrow-right');
                $(".removeall i").removeClass('glyphicon-arrow-left').addClass('fa fa-arrow-left');

                // Form validation
                $('#addEditRole').validate({
                    rules: {
                        name: {
                            required: true
                        },
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
                    }
                });
            });
        </script>
    @endsection
