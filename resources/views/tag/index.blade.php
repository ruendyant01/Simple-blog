@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header row">
                    <h3 class="col">Tags</h3>
                    <h5 class="col text-end"><a class="btn btn-success" href={{route("tag.create")}}>Create</a></h5>
                </div>

                <div class="card-body container text-center">
                    @forelse ($tags as $tag)
                        <div class="row">
                            <h4 class="col">{{$tag->name}}</h4>
                            <div class="col">
                                <a href={{route("tag.edit", $tag->slug)}} class="mx-4 btn btn-warning">Edit</a>
                                <form id={{"delete-form-".$tag->id}} action="{{ route('tag.destroy', $tag->slug) }}" method="POST" class="d-none">
                                    @csrf
                                    @method("delete")
                                </form>
                                <button class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('{{'delete-form-'.$tag->id}}').submit();">
                                    Delete
                                </button>
                            </div>
                        </div>                        
                    @empty
                        <h2>No Tags</h2>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection