@extends('admin.layouts.app')

@section('page_title', __('Categories'))

@section('contentheader_title', __('Categories'))

@section('contentheader_btn')
{{-- @can('create_permission') --}}
<a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-add-new">
    <i class="fa fa-plus-circle"></i>&nbsp; <span> {{__('Add New')}} </span>
</a>
{{-- @endcan --}}
@endsection

@section('content')
    <div class="card-body">
        <table id="categories_table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td></td>
                    <td><input type="text" class="form-control" placeholder="{{ __('Name') }}" data-index="1" /></td>
                    <td><input type="text" class="form-control" placeholder="{{ __('Slug') }}" data-index="2" /></td>
                    <td></td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

<!-- Include delete modal popup. -->
@include('admin.layouts.delete-modal', ['name' => 'Category' ])

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#categories_table").DataTable({
            scrollX: true,
            columnDefs: [
                {"orderable": false, "targets": [0, 3]},
                {"className": "serial-no", "targets": [0]},
            ],
            ajax: {
                url: "{{ route('admin.categories.index') }}",
                error: function (xhr, error, thrown) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}"; // Redirect to the login page for unauthorized access
                    }
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'slug', name: 'slug'},
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
        var baseUrl = "{{ url('admin/categories') }}";

        $("#categories_table").on('click', '.delete', function() {
            var id = $(this).data('id');
            var url = baseUrl + '/' + id;
            $("#delete_form").attr("action", url);
            $("#delete_modal").modal("show");
        });
    });
</script>
@endsection
