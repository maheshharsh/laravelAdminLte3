{{-- <!-- If session has success message then show it. -->
@if (session()->has('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
        {{ session()->get('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
        <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
        {{ session()->get('error') }}
    </div>
@endif

<!-- If session has error message then show it. -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button class="close" data-dismiss="alert" aria-label="close">&times;</button>
        <div>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif --}}
