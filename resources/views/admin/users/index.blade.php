@extends('admin.layouts.app')

@section('page_title', __('User'))

@section('contentheader_title', __('User'))

@section('contentheader_btn')
{{-- @can('create_user') --}}
<a href="{{ route('admin.users.create') }}" class="btn btn-success btn-add-new">
    <i class="fa fa-plus-circle"></i>&nbsp; <span>{{ __('Add New') }}</span>
</a>
{{-- @endcan --}}
@endsection

@section('content')
    <div class="card-body">
        <table id="users_table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td></td>
                    <td><input type="text" class="form-control" placeholder="{{__('Name')}}" data-index="1" /></td>
                    <td><input type="text" class="form-control" placeholder="{{__('Email')}}" data-index="2" /></td>
                    <td><input type="text" class="form-control" placeholder="{{__('Role')}}" data-index="3" /></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td></td>
                    <td>{{ $user->name ?? config('constants.empty_value') }}</td>
                    <td>{{ $user->email ?? config('constants.empty_value') }}</td>
                    <td>{{ $user->getRoleNames()->first() }}</td>
                    <td class="action-column">
                        {{-- @can('view_user') --}}
                            <a href="{{ route('admin.users.show', $user->id) }}" title="View"><i class="fa fa-eye"></i></a>
                        {{-- @endcan
                        @can('update_user') --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                        {{-- @endcan
                        @can('delete_user') --}}
                            <a href="#" class="delete" title="Delete" data-id="{{ $user->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                        {{-- @endcan --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<!-- Include delete modal popup. -->
@include('admin.layouts.delete-modal', ['name' => 'user'])

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#users_table').DataTable({
            scrollX: true,
            columnDefs: [
                {"orderable": false, "targets": [0,4]},
                {"className": "serial-no", "targets": [0]},
            ],
        });
        $(table.table().container()).on('keyup', 'thead input', function () {
            table.column($(this).data('index'))
            .search(this.value)
            .draw();
        });
        table.on('order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();

        
        var baseUrl = "{{ url('admin/users') }}";
        $("#users_table").on("click", ".delete", function() {
            var id = $(this).data('id');
            var url = $baseUrl + "/" + id;
            $("#delete_form").attr("action", url);
            $("#delete_modal").modal("show");
        });
    });
</script>
@endsection
