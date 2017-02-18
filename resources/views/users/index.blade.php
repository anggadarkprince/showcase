@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
    <div class="section-title">
        <h3>Manage Users
            <button class="btn btn-primary pull-right"
                    onclick="window.location.href='{{ route('admin.user.create') }}'">Create New User</button>
        </h3>
        <p>Create and modify new user</p>
    </div>

    @include('errors.common')

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Portfolio</th>
            <th>Galleries</th>
            <th width="160px">Action</th>
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
                <td>{{ $user->portfolios()->count() }} Showcases</td>
                <td>{{ $user->screenshots()->count() }} Images</td>
                <td>
                    <button class="btn btn-warning" type="button"
                            onclick="window.location.href='{{ route('admin.user.edit', [$user->username]) }}'">EDIT
                    </button>
                    <form action="{{ route('admin.user.destroy', [$user->username]) }}" method="post"
                          style="display: inline-block">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit"
                                onclick="return confirm('Are you sure want to delete this user?')">DELETE
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No users</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="clearfix">
        <?php
        $shownItems = (($users->currentPage() - 1) * $users->perPage()) + $users->count();
        $totalItems = $users->total();
        ?>
        <div class="pagination pull-left">
            Shown data {{ $shownItems }} of {{ $totalItems }}
        </div>
        <div class="pull-right">
            {{ $users->links() }}
        </div>
    </div>
@endsection