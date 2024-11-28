<div class="row">
    <div class="col-md-12">
        @if (session()->has('success_message'))
            <div class="alert alert-success mt-1 mb-1">
                {{ session()->get('success_message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger mt-1 mb-1">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-danger mt-1 mb-1" id="ajax_error_message" style="display: none"></div>
        <div class="alert alert-success mt-1 mb-1" id="ajax_success_message" style="display: none"></div>
    </div>
</div>
