@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    @php
        $title = [
            trans('page.menu.dashboard'),
            trans('page.menu.category')
        ];
    @endphp

    @include('partials._admin_title', ['title' => implode(',', $title)])

    <div class="panel panel-default panel-table">
        <div class="panel-body">

            <div class="section-title">
                <h3>
                    @lang('page.title.category')
                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#create-modal">
                        <i class="glyphicon glyphicon-plus"></i>
                        {{ strtoupper(trans('page.action.create').' '.trans('page.menu.category')) }}
                    </button>
                </h3>
                <p class="text-muted">@lang('page.subtitle.category')</p>
            </div>

            @include('errors.common')

            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>@lang('page.field.category')</th>
                    <th>@lang('page.field.detail')</th>
                    <th>@lang('page.field.portfolio')</th>
                    @can('delete', \App\Category::class)
                        <th width="120px">@lang('page.action.action')</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                <?php $no = ($categories->currentPage() - 1) * 10 ?>
                @forelse ($categories as $category)
                    <?php $no = $no + 1 ?>
                    <tr>
                        <td>{{ $no }}</td>
                        <td><a href="{{ route('portfolio.search.category', [str_slug($category->category).'-'.$category->id]) }}">{{ $category->category }}</a></td>
                        <td>{{ $category->detail }}</td>
                        <td>{{ $category->portfolios()->count() }}</td>

                        @can('delete', \App\Category::class)

                            <td>
                                <form action="{{ route('admin.category.destroy', [$category->id]) }}" method="post"
                                      style="display: inline-block">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger" type="submit"
                                            onclick="return confirm('{{ trans('page.message.delete', ['item' => strtolower(trans('page.menu.category'))]) }}')">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        {{ strtoupper(trans('page.action.delete')) }}
                                    </button>
                                </form>
                            </td>

                        @endcan

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">@lang('page.category.empty')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @include('partials._admin_paging', ['data' => $categories])

        </div>
    </div>



    <!-- Create Category Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.category.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">@lang('page.action.create') @lang('page.menu.category')</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label for="category" class="control-label">@lang('page.field.category')</label>
                            <input type="text" name="category" id="category" placeholder="@lang('page.field.category')"
                                   class="form-control" maxlength="255" value="{{ old('category') }}">
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                            <label for="detail" class="control-label">@lang('page.field.detail')</label>
                            <textarea name="detail" id="detail" placeholder="@lang('page.field.detail')"
                                      class="form-control" maxlength="500">{{ old('detail') }}</textarea>
                            {!! $errors->first('detail', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            @lang('page.action.close')
                        </button>
                        <button type="submit" class="btn btn-primary">
                            @lang('page.action.save') @lang('page.menu.category')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->has('category') || $errors->has('detail'))
        @push('scripts')
            <script defer>
                window.onload = function(){
                    setTimeout(function(){
                        $('#create-modal').modal('show');
                    }, 500);
                }
            </script>
        @endpush
    @endif
@endsection