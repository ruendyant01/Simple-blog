<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth")->only("store", "destroy", "update", "create","edit", "show");
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
        $id->delete();
        return redirect("/");
    }

    public function store(Request $req) 
    {
        extract($req->all());
        $blog = Blog::create(["title" => $title, "body" => $body, "image" => $image->name, "user_id"=>$user_id]);
        $blog->uploadImage($req->image);
        return response($blog, Response::HTTP_CREATED);
    }

    public function update(Request $req, Blog $id) {
        $id->update($req->all());
        return redirect("/");
    }

    public function edit(Blog $blog) {
        return view("blog.edit", compact("blog"));
    }
}
