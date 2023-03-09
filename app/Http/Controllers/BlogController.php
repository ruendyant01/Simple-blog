<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth")->except("index");
    }
    //
    public function index() {
        $blog = Blog::published()->get();
        return view("blog.index", ["blog" => $blog]);
    }

    public function show(Blog $id) {
        if(is_null($id->published_at)) return response("", Response::HTTP_NOT_FOUND);
        return view("blog.show", ["show" => $id]);
    }

    public function destroy(Blog $id) {
        $id->tags->each->delete();
        $id->tags()->detach();
        $id->delete();
        return redirect("/");
    }

    public function store(BlogRequest $req) 
    {
        extract($req->all());
        $blog = auth()->user()->blogs()->create(["title" => $title, "body" => $body, "image" => $image->name]);
        $blog->uploadImage($req->image);
        $blog->tags()->attach($req->tag_ids);
        return response($blog, Response::HTTP_CREATED);
    }

    public function update(Request $req, Blog $id) {
        $id->update($req->except("tag_ids"));
        $id->tags()->sync($req->tag_ids);
        return redirect("/");
    }

    public function edit(Blog $blog) {
        return view("blog.edit", compact("blog"));
    }
}
