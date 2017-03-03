@extends('layouts.app')

@section('title', '- Create Portfolio')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <h1 class="page-title">Create a Portfolio</h1>

                @include('errors.common')

                <form action="{{ route('account.portfolio.store', [$user->username]) }}" method="post" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    {{ method_field('post') }}

                    <div class="form-title">
                        <h4>Project</h4>
                        <p>Showcase detail information</p>
                    </div>

                    <div class="field-group">
                        <div class="form-group @if($errors->has('title')) {{ 'has-error' }} @endif">
                            <label for="title" class="control-label">Title</label>

                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ old('title') }}" placeholder="Title of portfolio project">

                            @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('description')) {{ 'has-error' }} @endif">
                            <label for="description" class="control-label">About</label>

                            <textarea class="form-control" id="description" name="description"
                                      placeholder="About your work">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('category')) {{ 'has-error' }} @endif">
                            <label for="category" class="control-label">Category</label>

                            <select name="category" id="category" class="form-control">
                                <option value="">- Select Category -</option>
                                @foreach($categories as $key => $category)
                                    <option value="{{ $key }}" @if(old('category') == $key) {{ 'selected' }} @endif>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('tags')) {{ 'has-error' }} @endif">
                            <label for="tags" class="control-label">Tags</label>

                            <input type="text" class="form-control" id="tags" name="tags"
                                   value="{{ old('tags') }}" placeholder="Project tags and keywords">

                            @if ($errors->has('tags'))
                                <span class="help-block">{{ $errors->first('tags') }}</span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('company')) {{ 'has-error' }} @endif">
                                    <label for="company" class="control-label">Company</label>

                                    <input type="text" class="form-control" id="company" name="company"
                                           value="{{ old('company') }}" placeholder="Related company you're working project on">

                                    @if ($errors->has('company'))
                                        <span class="help-block">{{ $errors->first('company') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @if($errors->has('date')) {{ 'has-error' }} @endif">
                                    <label for="date" class="control-label">Date</label>

                                    <input type="date" class="form-control" id="date" name="date"
                                           value="{{ old('date') }}" placeholder="Date of your work">

                                    @if ($errors->has('date'))
                                        <span class="help-block">{{ $errors->first('date') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('reference')) {{ 'has-error' }} @endif">
                            <label for="title" class="control-label">URL reference</label>

                            <input type="url" class="form-control" id="reference" name="reference"
                                   value="{{ old('reference') }}" placeholder="Where website show your masterpiece is?">

                            @if ($errors->has('reference'))
                                <span class="help-block">{{ $errors->first('reference') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-title">
                        <h4>Screenshots</h4>
                        <p>Organize your showcase photos</p>

                        <div class="row screenshot-wrapper">
                            <div class="col-md-3 screenshot-item">
                                <div class="form-group">
                                    <label for="add-screenshot" class="control-label">Add Screenshot</label>
                                    <div class="file">
                                        <label for="add-screenshot" class="screenshot-preview">ADD IMAGE</label>
                                        <input type="file" name="screenshots[]" id="add-screenshot"
                                               class="inputfile screenshot-file" accept="image/png,image/gif,image/jpeg">
                                        <label for="add-screenshot" class="btn btn-default">Choose a file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Portfolio</button>
                </form>

            </div>
        </div>
    </div>
@endsection