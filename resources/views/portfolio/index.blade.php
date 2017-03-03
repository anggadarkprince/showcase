@extends('layouts.app')

@section('title', '- My Portfolio')

@section('content')
    <div class="container">
        <h1 class="page-title">My Portfolio
            @include('partials._stats_showing', ['data' => $portfolios])
        </h1>

        @include('errors.common')

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="thumbnail portfolio-item-create">
                    <a href="{{ route('account.portfolio.create', [$user->username]) }}">
                        CREATE PORTFOLIO
                    </a>
                </div>
            </div>
            @include('partials._portfolio_card', [
                'editable' => true,
                'columns' => 'col-sm-6 col-md-4 col-lg-3'
            ])
            <script>
                function deletePortfolio(event, url){
                    event.preventDefault();
                    var answer = confirm('Are you sure want to delete?');
                    if(answer){
                        var form = document.getElementById('delete-form');
                        form.setAttribute('action', url);
                        form.submit();
                    }
                }
            </script>
            <form id="delete-form" action="#" method="POST" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('delete') }}
            </form>

        </div>

        <div class="center-block">
            {{ $portfolios->links() }}
        </div>
    </div>
@endsection