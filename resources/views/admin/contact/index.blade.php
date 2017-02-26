@extends('layouts.admin')

@section('title', 'Admin Contact')

@section('content')
    @php
        $title = [
            trans('page.menu.dashboard'),
            trans('page.menu.contact')
        ];
    @endphp

    @include('partials._admin_title', ['title' => collect($title), 'isBreadcrumb' => true])

    <div class="section-title">
        <h3>@lang('page.title.contact')</h3>
        <p>@lang('page.subtitle.contact')</p>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <p>@lang('page.message.about')</p>
            @lang('page.message.contact') <a href="mailto:anggadarkprince@gmail.com">anggadarkprince@gmail.com</a>
            <p>Twitter <a href="https://twitter.com/anggadarkprince">@anggadarkprince</a></p>
            <p>Gresik, Indonesia</p>
        </div>
    </div>
@endsection