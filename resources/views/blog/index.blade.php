@extends('layouts.app');

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header row">
                    <h3 class="col">My Blogs</h3>
                    <a href={{route("blog.create.form")}} class="col btn btn-success">Create</a>
                </div>

                <div class="card-body">
                    @forelse ($blog as $blogs)
                        <div>
                            <img src={{"/storage/".$blogs->image}} alt="" height="300">
                            <div>
                                <a href={{"/".$blogs->slug}}><h3>{{$blogs->title}}</h3></a>
                                <p>{{$blogs->published_at ?: ""}}</p>
                                <p>{{$blogs->tags->pluck("name")->join(",")}}</p>
                            </div>
                        </div>
                    @empty
                        <h2>No Blogs</h2>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection