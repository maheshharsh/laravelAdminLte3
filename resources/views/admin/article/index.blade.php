@extends('admin.layouts.app')

@section('page_title', __('Articles'))

@section('contentheader_title', __('Articles'))

@section('contentheader_btn')
    <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-add-new">
        <i class="fa fa-plus-circle"></i>&nbsp; <span>{{ __('Add New') }}</span>
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="article_table" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Sub Content') }}</th>
                        <th>{{ __('Published At') }}</th>
                        <th>{{ __('Is Featured') }}</th>
                        <th>{{ __('Is Published') }}</th>
                        <th>{{ __('Is Carousel') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Title') }}" data-index="1" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Slug') }}" data-index="2" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Sub Content') }}" data-index="3" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Published At') }}" data-index="4" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Is Featured') }}" data-index="5" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Is Published') }}" data-index="6" /></th>
                        <th><input type="text" class="form-control" placeholder="{{ __('Search Is Carousel') }}" data-index="7" /></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    {{-- Delete confirmation modal --}}
    @include('admin.layouts.delete-modal', ['name' => 'Article'])
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        const baseUrl = "{{ url('admin/articles') }}";

        const table = $('#article_table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            ajax: {
                url: "{{ route('admin.articles.index') }}",
                error: function (xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    }
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'slug', name: 'slug' },
                { data: 'sub_content', name: 'sub_content' },
                { data: 'published_at', name: 'published_at' },
                { data: 'is_featured', name: 'is_featured' },
                { data: 'is_published', name: 'is_published' },
                { data: 'is_carousel', name: 'is_carousel' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[1, 'asc']],
            columnDefs: [
                { className: 'serial-no', targets: [0] },
            ],
            initComplete: function () {
                const api = this.api();
                $('#article_table thead input').on('keyup', function () {
                    api.column($(this).data('index')).search(this.value).draw();
                });
            }
        });

        // Reorder serial number column dynamically
        table.on('order.dt search.dt', function () {
            let i = 1;
            table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell) {
                cell.innerHTML = i++;
            });
        }).draw();

        // Delete action
        $('#article_table').on('click', '.delete', function () {
            const id = $(this).data('id');
            const deleteUrl = `${baseUrl}/${id}`;
            $('#delete_form').attr('action', deleteUrl);
            $('#delete_modal').modal('show');
        });
    });
</script>
@endsection
