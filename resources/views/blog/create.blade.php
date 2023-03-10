@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header row">
                    <h3 class="col">Create New Blog</h3>
                    <a href={{route("home")}} class="col btn btn-danger">Back</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('blog.create')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>

                            <div class="col-md-6">
                                <input id="text" type="title" class="form-control @error('title') is-invalid @enderror" name="title" autocomplete="title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="body" class="col-md-4 col-form-label text-md-end">Text Body</label>

                            <div class="col-md-6">
                                <textarea id="body" class="form-control @error('body') is-invalid @enderror" name="body" autocomplete="body"></textarea>

                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tag" class="col-md-4 col-form-label text-md-end">Tags</label>

                            <div class="col-md-6">
                                <select name="tag_ids[]" id="tag" multiple class="form-control multiple">
                                    @foreach ($tags as $tag)
                                        <option value={{$tag->id}}>{{$tag->name}}</option>
                                    @endforeach
                                </select>

                                @error('tag_ids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">Image</label>

                            <div class="col-md-6">
                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="published_at" class="col-md-4 col-form-label text-md-end">Publish</label>

                            <div class="col-md-6">
                                <input type="datetime-local" id="published_at" class="form-control @error('published_at') is-invalid @enderror" name="published_at" autocomplete="published_at">

                                @error('published_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection