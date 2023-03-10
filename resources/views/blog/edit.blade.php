@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Blog</div>

                <div class="card-body">
                    <h3>{{$blog->user->name}}</h3>
                    <form method="POST" action="{{ route('blog.update', ['id' => $blog->slug])}}" enctype="multipart/form-data">
                        @csrf
                        @method("patch")

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>

                            <div class="col-md-6">
                                <input id="text" type="title" value="{{$blog->title}}" class="form-control @error('title') is-invalid @enderror" name="title" autocomplete="title">

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
                                <textarea id="body" class="form-control @error('body') is-invalid @enderror" name="body" autocomplete="body">{{$blog->body}}</textarea>

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
                                        <option value={{$tag->id}} {{$blog->tags->pluck("id")->contains(fn($val) => $val === $tag->id) ? "selected" : ''}}>{{$tag->name}}</option>
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
                                <img src={{"/storage/".$blog->image}} alt="" height="300">
                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit
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