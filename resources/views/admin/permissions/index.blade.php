@extends('admin.layouts.app')

@section('page_title', __('Permissions'))

@section('contentheader_title', __('Permissions'))

@section('contentheader_btn')
{{-- @can('create_permission') --}}
<a href="{{ route('admin.permissions.create') }}" class="btn btn-success btn-add-new">
    <i class="fa fa-plus-circle"></i>&nbsp; <span> {{__('Add N ew')}} </span>
</a>
{{-- @endcan --}}
@endsection

@section('content')
    <div class="card-body">
        <table id="permissions_table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Code Name') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td></td>
                    <td><input type="text" class="form-control" placeholder="{{ __('Name') }}" data-index="1" /></td>
                    <td><input type="text" class="form-control" placeholder="{{ __('Code Name') }}" data-index="2" /></td>
                    <td></td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

<!-- Include delete modal popup. -->
@include('admin.layouts.delete-modal', ['name' => 'Permission' ])

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#permissions_table").DataTable({
            scrollX: true,
            columnDefs: [
                {"orderable": false, "targets": [0, 3]},
                {"className": "serial-no", "targets": [0]},
            ],
            ajax: {
                url: "{{ route('admin.permissions.index') }}",
                error: function (xhr, error, thrown) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}"; // Redirect to the login page for unauthorized access
                    }
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'code_name', name: 'code_name'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
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
        var baseUrl = "{{ url('admin/permissions') }}";

        $("#permissions_table").on('click', '.delete', function() {
            var id = $(this).data('id');
            var url = baseUrl + '/' + id;
            $("#delete_form").attr("action", url);
            $("#delete_modal").modal("show");
        });
    });
</script>
@endsection
