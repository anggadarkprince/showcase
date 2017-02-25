@if(Session::has('action') && Session::has('message'))
    <div class="alert alert-{{ Session::get('action') }}">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>{{ Session::get('message') }}</p>
    </div>
@elseif (count($errors) > 0)
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><strong>@lang('page.message.error')</strong></p>
        <ul style="padding-left: 15px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif