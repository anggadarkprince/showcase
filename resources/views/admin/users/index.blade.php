@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    @php
        $title = [
            trans('page.menu.dashboard'),
            trans('page.menu.user')
        ];
    @endphp

    @include('partials._admin_title', ['title' => collect($title), 'isBreadcrumb' => true])

    <div class="panel panel-default panel-table">
        <div class="panel-body">

            <div class="section-title">
                <h3>
                    @lang('page.title.user')
                    <button class="btn btn-primary pull-right"
                            onclick="window.location.href='{{ route('admin.user.create') }}'">
                        <i class="glyphicon glyphicon-plus"></i>
                        {{ strtoupper(trans('page.action.create') .' '.trans('page.menu.user')) }}
                    </button>
                </h3>
                <p class="text-muted">@lang('page.subtitle.user')</p>
            </div>

            @include('errors.common')

            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>@lang('page.field.name')</th>
                    <th>@lang('page.field.email')</th>
                    <th>@lang('page.field.portfolio')</th>
                    <th>@lang('page.field.screenshot')</th>
                    <th width="@if(App::isLocale('en')) 130px @else 155px @endif">@lang('page.action.action')</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = ($users->currentPage() - 1) * 10 ?>
                @forelse ($users as $user)
                    <?php $no = $no + 1 ?>
                    <tr>
                        <td>{{ $no }}</td>
                        <td><a href="{{ route('profile.show', ['user' => $user->username]) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->portfolios()->count() }}</td>
                        <td>{{ $user->screenshots()->count() }}</td>
                        <td>
                            <button class="btn btn-default" type="button"
                                    onclick="window.location.href='{{ route('admin.user.edit', [$user->username]) }}'">
                                {{ strtoupper(trans('page.action.edit')) }}
                            </button>
                            <form action="{{ route('admin.user.destroy', [$user->username]) }}" method="post"
                                  style="display: inline-block">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger" type="submit"
                                        onclick="return confirm('Are you sure want to delete this user?')">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">@lang('page.user.empty')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @include('partials._admin_paging', ['data' => $users])

        </div>
    </div>

@endsection