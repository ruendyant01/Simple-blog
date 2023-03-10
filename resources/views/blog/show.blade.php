@extends('layouts.app');

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{$blog->title}}
                </div>

                <div class="card-body">
                    <img src={{"/storage/".$blog->image}} alt="" height="300">
                    <h3>{{$blog->title}}</h3>
                    <p>{{$blog->published_at}}</p>
                    <p>{{$blog->tags->pluck("name")->join(",")}}</p>
                    <a href={{"/".$blog->slug."/edit"}}>Edit</a>
                    <br><br>
                    <p>{{$blog->user->name}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection