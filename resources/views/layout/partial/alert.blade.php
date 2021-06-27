@if (session()->has('alert_success'))
    <div class="alert alert-success mb-5 p-5  fade show" role="alert">
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><em class="ki ki-close"></em></span>
            </button>
        </div>
        <h4 class="alert-heading">OK!</h4>
        <p>{!! session('alert_success') !!}</p>
        <p>{{session('alert_success_message') }} </p>
    </div>
@endif
@if (session()->has('alert_error'))
    <div class="alert alert-danger mb-5 p-5 fade show" role="alert">
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><em class="ki ki-close"></em></span>
            </button>
        </div>
        <h4 class="alert-heading">Có lỗi xảy ra!</h4>
        <p>{{session('alert_error') }} </p>
        <p>{{session('alert_error_message') }} </p>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
