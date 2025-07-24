@extends('admin.layouts.app')

@section('page_title', __('Advertisement'))

@section('contentheader_title', __('Advertisement'))

@section('contentheader_btn')
    {{-- @can('create_permission') --}}
    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-success btn-add-new">
        <i class="fa fa-plus-circle"></i>&nbsp; <span>{{ __('Add New') }}</span>
    </a>
    {{-- @endcan --}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="advertisement_table" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>
                            <input type="text" class="form-control" placeholder="{{ __('Search Title') }}" data-index="1" />
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    {{-- Delete confirmation modal --}}
    @include('admin.layouts.delete-modal', ['name' => 'Advertisement'])
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        const baseUrl = "{{ url('admin/advertisements') }}";

        const table = $('#advertisement_table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                url: "{{ route('admin.advertisements.index') }}",
                error: function (xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    }
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[1, 'asc']],
            columnDefs: [
                { className: 'serial-no', targets: [0] },
            ],
            initComplete: function () {
                const api = this.api();
                $('#advertisement_table thead input').on('keyup', function () {
                    api.column($(this).data('index')).search(this.value).draw();
                });
            }
        });

        // Reorder serial number column
        table.on('order.dt search.dt', function () {
            let i = 1;
            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell) {
                cell.innerHTML = i++;
            });
        }).draw();

        // Delete action
        $('#advertisement_table').on('click', '.delete', function () {
            const id = $(this).data('id');
            const deleteUrl = `${baseUrl}/${id}`;
            $('#delete_form').attr('action', deleteUrl);
            $('#delete_modal').modal('show');
        });
    });
</script>
@endsection
