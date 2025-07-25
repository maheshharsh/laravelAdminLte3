@extends('admin.layouts.app')

@section('page_title', isset($user->id) ? __('Edit User') : __('Add User'))

@section('contentheader_title', isset($user->id) ? __('Edit User') : __('Add User'))

@section('content')
    <!-- form start -->
    <form role="form" method="post" id="addEditUser"
        action="@if (isset($user->id)) {{ route('admin.users.update', ['user' => $user->id]) }}@else{{ route('admin.users.store') }} @endif"
        enctype="multipart/form-data">
        @if (isset($user->id))
            @method('PUT')
        @endif
        @csrf
        <div class="card-body">
            <div class="row">
                <!-- User Name -->
                <div class="form-group col-md-6">
                    <label for="name" class="requiredField">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder={{ __('Name') }}
                        value="@if (isset($user->name)) {{ old('name', $user->name) }}@else{{ old('name') }} @endif">
                </div>
                <!-- Email -->
                <div class="form-group col-md-6">
                    <label for="email" class="requiredField">{{ __('Email') }}</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder={{ __('Email') }}
                        value="@if (isset($user->email)) {{ old('email', $user->email) }}@else{{ old('email') }} @endif">
                </div>
                <!-- Password -->
                <div class="form-group col-md-6">
                    <label for="password"
                        @if (!isset($user->id)) class="requiredField" @endif>{{ __('message.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder={{ __('message.password') }} value="">
                </div>
                <!-- Confirm Password -->
                <div class="form-group col-md-6">
                    <label for="c_password"
                        @if (!isset($user->id)) class="requiredField" @endif>{{ __('message.confirm_password') }}</label>
                    <input type="password" class="form-control" id="c_password" name="c_password"
                        placeholder={{ __('message.confirm_password') }} value="">
                </div>
                <!-- Mobile No. -->
                <div class="form-group col-md-6">
                    <label for="mobileno" class="requiredField">{{ __('Mobile Number') }}</label>
                    <input type="tel" class="form-control numbers" id="mobileno" name="mobileno"
                        placeholder={{ __('Mobile Number') }}
                        value="@if (isset($user->mobileno)) {{ old('mobileno', $user->mobileno) }}@else{{ old('mobileno') }} @endif">
                </div>
                <!-- Gender -->
                <div class="form-group col-md-6">
                    <label for="gender" class="requiredField">{{ __('Gender') }}</label>
                    <select class="form-control select2-withoutsearch" name="gender">
                        <option value="" selected disabled>{{ __('message.please_select') }}</option>
                        @foreach (\App\Models\User::GENDER_OPTIONS as $key => $value)
                            <option value="{{ $key }}"
                                @if (old('gender') == $key || (isset($user->gender) && $user->gender == $key)) {{ 'selected' }} @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group col-md-6">
                    <label for="status" class="requiredField">{{ __('Status') }}</label>
                    <select class="form-control select2-withoutsearch" name="status">
                        <option value="" selected disabled>{{ __('message.please_select') }}</option>
                        @foreach (\App\Models\User::USER_STATUS_OPTIONS as $skey => $sValue)
                            <option value="{{ $skey }}"
                                @if (old('status') == $skey || (isset($user->status) && $user->status == $skey)) {{ 'selected' }} @endif>{{ $sValue }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Role -->
                <div class="form-group col-md-6">
                    <label for="role" class="requiredField">{{ __('Role') }}</label>
                    @php
                        $currentRole = old('role')
                            ? [old('role')]
                            : (isset($user->role)
                                ? [\App\Models\Role::where(\App\Models\Role::NAME, $user->role)->value('id')]
                                : []);
                    @endphp
                    <select name="role" class="form-control select2-withoutsearch" id="role">
                        <option value="" selected disabled>{{ __('message.please_select') }}</option>
                        @foreach ($roles->toArray() as $role)
                            <option value="{{ $role['name'] }}"
                                @if (in_array($role['id'], $currentRole)) {{ 'selected' }} @endif>{{ $role['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Permission -->
                <div class="form-group col-md-6" id="permissions_div">
                    <label for="permission">{{ __('Additional Permission') }}</label>
                    <select name="permission[]" class="select2 form-control" multiple="multiple" id="permissions">
                    </select>
                </div>
                <!-- Image -->
                <div class="form-group col-md-6 ">
                    <label>{{ __('Image') }}</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="image" accept="image/*" id="image">
                        <div class="input-group-append">
                            <label class="input-group-text" for="image">Browse</label>
                        </div>
                    </div>
                    @if (isset($user->profile_image))
                        <div class="deletable_image">
                            <img class="p-1"
                                src="{{ route('admin.file.serve', ['file_path' => $user->profile_image]) }}" height="80px"
                                width="80px">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="hidden"
                value="@if (isset($user->id)) {{ $user->id }}@else{{ '' }} @endif"
                id="user_id">
            <button type="submit"
                class="btn btn-primary">{{ isset($user->id) ? __('message.update') : __('message.submit') }}</button>
        </div>
    </form>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#addEditUser').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    c_password: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    },
                    mobileno: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                    role: {
                        required: true,
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
            $('.numbers').keyup(function() {
                this.value = this.value.replace(/^[a-z]+$/i, '');
            });

            $(".select2").select2({
                placeholder: "Please select",
                width: '100%'
            });
            $(document).on("select2:open", () => {
                document.querySelector(".select2-container--open .select2-search__field").focus()
            })
            $(".select2-withoutsearch").select2({
                placeholder: "Please select",
                minimumResultsForSearch: Infinity,
                width: '100%'
            });

            $('#role').on('change', function() {
                additionalPermission();
            });
            /* get additionalPermission  by role id*/
            function additionalPermission(isPermission = false) {
                var role = $('#role').val();
                var permissions = 0;
                if (isPermission) {
                    if ($.isArray(isPermission)) {
                        permissions = isPermission;
                    } else {
                        permissions = isPermission.split(',');
                    }
                }
                $.ajax({
                    url: "{{ route('admin.getRolePermission') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        roleId: role,
                    },
                    success: function(result) {
                        $('#permissions').empty();
                        var superUser = "{{ \App\Models\Role::SUPER_ADMIN }}";
                        if (result == superUser) {
                            hideOption(result)
                        } else {
                            hideOption()
                            $.each(result, function(key, value) {
                                var selected = '';
                                if ($.inArray(value.name, permissions) !== -1 || value.id ==
                                    permissions) {
                                    var selected = 'selected';
                                }
                                var selectedPermissions = $.map(value.name.split('_'), function(
                                    word) {
                                    return word.charAt(0).toUpperCase() + word.slice(1);
                                }).join(' ');
                                $('#permissions').append('<option value="' + value.name + '" ' +
                                    selected + '>' + selectedPermissions + '</option>');
                            });
                        }
                    }
                });
            }

            permission()

            function permission() {
                var oldAdditionalPermissionId =
                    "<?= old('permissions') != null ? implode(',', old('permissions')) : '' ?>";
                var userId = $("#user_id").val();
                if (oldAdditionalPermissionId) {
                    additionalPermission(oldAdditionalPermissionId);
                }
                if (userId) {
                    $("#password").rules("remove", "required");
                    $("#c_password").rules("remove", "required");
                }
            }

            hideOption()

            function hideOption($userRole = false) {
                if ($userRole) {
                    $("#permissions_div").prop('hidden', true);
                } else {
                    $("#permissions_div").prop('hidden', false);
                }
            }

            @if (isset($user->id) && !count(old()))
                var additionalPermissions = <?php echo json_encode($user->getPermissionNames()->toArray()); ?>;
                additionalPermission(additionalPermissions);
            @endif

        });
    </script>
@endsection
