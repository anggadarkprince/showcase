@extends('layouts.admin')

@section('title', 'Tags')

@section('content')
    @php
        $title = [
            trans('page.menu.dashboard'),
            trans('page.menu.tag')
        ];
    @endphp

    @include('partials._admin_title', ['title' => implode(',', $title)])

    <div class="panel panel-default panel-table">
        <div class="panel-body">

            <div class="section-title">
                <h3>
                    @lang('page.title.tag')
                    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#create-modal">
                        <i class="glyphicon glyphicon-plus"></i>
                        {{ strtoupper(trans('page.action.create').' '.trans('page.menu.tag')) }}
                    </button>
                </h3>
                <p class="text-muted">@lang('page.subtitle.tag')</p>
            </div>

            @include('errors.common')

            <div id="alert-wrapper"></div>

            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>@lang('page.field.tag')</th>
                    <th>@lang('page.field.portfolio')</th>
                    <th width="120px">@lang('page.action.action')</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = ($tags->currentPage() - 1) * 10 ?>
                @forelse ($tags as $tag)
                    <?php $no = $no + 1 ?>
                    <tr>
                        <td>{{ $no }}</td>
                        <td><a href="{{ route('portfolio.search.tag', [str_slug($tag->tag)]) }}">{{ $tag->tag }}</a></td>
                        <td>{{ $tag->portfolios()->count() }}</td>
                        <td>
                            <form action="{{ route('admin.tag.destroy', [$tag->id]) }}" method="post"
                                  style="display: inline-block">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <button class="btn btn-danger" type="submit"
                                        onclick="return confirm('{{ trans('page.message.delete', ['item' => strtolower(trans('page.menu.tag'))]) }}')">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    {{ strtoupper(trans('page.action.delete')) }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">@lang('page.tag.empty')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @include('partials._admin_paging', ['data' => $tags])

        </div>
    </div>

    <!-- Create Category Modal -->
    <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.tag.store') }}" method="post" id="form-tag">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">@lang('page.action.create') @lang('page.menu.tag')</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('tag') ? 'has-error' : '' }}">
                            <label for="tag" class="control-label">@lang('page.menu.tag')</label>
                            <input type="text" name="tag" id="tag" placeholder="@lang('page.menu.tag')"
                                   class="form-control" maxlength="255" value="{{ old('tag') }}">
                            {!! $errors->first('tag', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            @lang('page.action.close')
                        </button>
                        <button type="submit" class="btn btn-primary"
                                data-loading-text="{{ trans('page.action.saving') }}...">
                            @lang('page.action.save') @lang('page.menu.tag')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script defer>
        window.onload = function () {
            var modalCreate = $('#create-modal');
            var formTag = $('#form-tag');
            var submitFormTag = $('#form-tag').find('button[type=submit]');
            var cancelFormTag = $('#form-tag').find('button[type=button]');
            var alertWrapper = $('#alert-wrapper');

            formTag.on('submit', function (e) {
                e.preventDefault();

                submitFormTag.button('loading');
                alertWrapper.html('');

                var tagInput = $(this).find('input[name=tag]');
                tagInput.attr('disabled', true);
                cancelFormTag.attr('disabled', true);

                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.tag.store') }}",
                    data: {
                        tag: tagInput.val()
                    },
                    success: function (data) {
                        console.log(JSON.stringify(data, null, 4));
                        submitFormTag.button('reset');
                        modalCreate.modal('hide');
                        var action = data.action;
                        var message = data.message;
                        setTimeout(function(){
                            window.location.reload(false);
                            alertWrapper.html("<div class='alert alert-" + action + "'>" + message + "</div>");
                        }, 300);
                        tagInput.val('');
                        tagInput.removeAttr('disabled');
                        cancelFormTag.removeAttr('disabled');
                    },
                    error: function (e) {
                        submitFormTag.button('reset');
                        cancelFormTag.removeAttr('disabled');
                        tagInput.removeAttr('disabled');
                        console.log(JSON.stringify(e, null, 4));
                    },
                    statusCode: {
                        401: function (xhr) {
                            alert("Unauthorized " + xhr.status);
                        },
                        404: function (xhr) {
                            alert("Data not found " + xhr.status);
                        },
                        422: function (xhr) {
                            submitFormTag.find('button[type=submit]').button('reset');
                            $.each(xhr.responseJSON, function (index, value) {
                                var field = formTag.find('[name=' + index + ']');
                                field.closest('.form-group').addClass('has-error');
                                for (var i = 0; i < value.length; i++) {
                                    field.after('<span class="help-block">' + value[i] + '</span>')
                                }
                            });
                        },
                    }
                })
            });
        }
    </script>
    @endpush
@endsection