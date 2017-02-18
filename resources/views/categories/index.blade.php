@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="section-title">
        <h3>Manage Users
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#create-modal">Create New
                Category
            </button>
        </h3>
        <p>Create and modify showcase's topic</p>
    </div>

    @include('errors.common')

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Category</th>
            <th>Detail</th>
            <th>Portfolios</th>
            <th width="120px">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = ($categories->currentPage() - 1) * 10 ?>
        @forelse ($categories as $category)
            <?php $no = $no + 1 ?>
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $category->category }}</td>
                <td>{{ $category->detail }}</td>
                <td>{{ $category->portfolios()->count() }}</td>
                <td>
                    <form action="{{ route('admin.category.destroy', [$category->id]) }}" method="post"
                          style="display: inline-block">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit"
                                onclick="return confirm('Are you sure want to delete this category?')">DELETE
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No categories</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="clearfix">
        <?php
        $shownItems = (($categories->currentPage() - 1) * $categories->perPage()) + $categories->count();
        $totalItems = $categories->total();
        ?>
        <div class="pagination pull-left">
            Shown data {{ $shownItems }} of {{ $totalItems }}
        </div>
        <div class="pull-right">
            {{ $categories->links() }}
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
                        <h4 class="modal-title">Create New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label for="category" class="control-label">Category</label>
                            <input type="text" name="category" id="category" placeholder="Category"
                                   class="form-control" maxlength="255" value="{{ old('category') }}">
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('detail') ? 'has-error' : '' }}">
                            <label for="detail" class="control-label">Detail</label>
                            <textarea name="detail" id="detail" placeholder="Detail"
                                      class="form-control" maxlength="500">{{ old('detail') }}</textarea>
                            {!! $errors->first('detail', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->has('category') || $errors->has('detail'))
    <script defer>
        window.onload = function(){
            setTimeout(function(){
                $('#create-modal').modal('show');
            }, 500);
        }
    </script>
    @endif
@endsection