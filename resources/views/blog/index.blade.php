{{-- {{$blog[0]->title}}
{{$blog[1]->title}} --}}

@extends('layouts.app');



{{-- {{$blog}} --}}

{{-- @foreach ($blog[1]->tags as $tag)
    {{$tag->name}}
@endforeach --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Blogs</div>

                <div class="card-body">
                    @forelse ($blog as $blogs)
                        <div>
                            <img src={{"/storage/".$blogs->image}} alt="" height="300">
                            <div>
                                <h3>{{$blogs->title}}</h3>
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