<div class="clearfix">
    <h1 class="page-title pull-left">
        <button type="button" class="navbar-toggle" id="menu-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        @php
            $title = explode(',', $title);
            $isFirst = true;
        @endphp
        @foreach($title as $section)
            @if($isFirst)
                {!! $section !!}
                @php $isFirst = false; @endphp
            @else
                <small class="hidden-xs text-primary">
                    <span class="page-arrow">></span>{!! $section or '' !!}
                </small>
            @endif
        @endforeach
    </h1>
    <select class="pull-right locale" style="margin-top: 10px">
        @foreach(config('app.locales') as $id => $lang)
            <option value="{{ $id }}" @if(Request::segment(1) == $id) {{ "selected=true" }} @endif>
                {{ $lang }}
            </option>
        @endforeach
    </select>
</div>