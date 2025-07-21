@extends('admin.layouts.app')

@section('page_title', __('message.category'))

@section('contentheader_title', __('message.category'))

@section('contentheader_btn')
@can('create_category')
<a href="{{ route('admin.category.create') }}" class="btn btn-success btn-add-new">
    <i class="fa fa-plus-circle"></i>&nbsp; <span>{{ __('message.addnew') }}</span>
</a>
@endcan
@endsection

@section('content')
    <div class="card-body">
        <table id="category_table" class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td></td>
                    <td><input type="text" class="form-control" placeholder="{{__('Name')}}" data-index="1" /></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td></td>
                    <td>{{ $category->name }}</td>
                    <td class="action-column">
                        @can('view_category')
                            <a href="{{ route('admin.category.show', $category->id) }}" title="View"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('update_category')
                            <a href="{{ route('admin.category.edit', $category->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('delete_category')
                            <a href="#" class="delete" title="Delete" data-id="{{ $category->id }}" title="Delete"><i class="fa fa-trash"></i></a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<!-- Include delete modal popup. -->
@include('admin.layouts.delete-modal', ['name' => 'category'])

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#category_table').DataTable({
            scrollX: true,
            columnDefs: [
                {"orderable": false, "targets": [0,2]},
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

        $("#category_table").on("click", ".delete", function() {
            var id = $(this).data('id');
            var url = "{{ route('admin.category.destroy', '') }}" + "/" + id;
            $("#delete_form").attr("action", url);
            $("#delete_modal").modal("show");
        });
    });
</script>
@endsection
