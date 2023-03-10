@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Blog</div>

                <div class="card-body">
                    <h3>{{$tag->name}}</h3>
                    <form method="POST" action={{ route('tag.update', $tag->slug)}}>
                        @csrf
                        @method("patch")

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">name</label>

                            <div class="col-md-6">
                                <input id="text" type="name" value={{$tag->name}} class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name">

                                @error('name')
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