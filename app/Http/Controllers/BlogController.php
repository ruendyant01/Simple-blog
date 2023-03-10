<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
        return view("blog.show", ["blog" => $id]);
    }

    public function destroy(Blog $id) {
        $id->tags->each->delete();
        $id->tags()->detach();
        $id->delete();
        return redirect("/");
    }

    public function create() {
        $tags = Tag::all();
        return view("blog.create", compact("tags"));
    }

    public function store(BlogRequest $req) 
    {
        extract($req->all());
        $blog = auth()->user()->blogs()->create(["title" => $title, "body" => $body, "image" => $image->getClientOriginalName()]);
        if(isset($image)) $blog->uploadImage($image);
        // $tag = Tag::firstOrCreate(["name" => $tag_ids],["name" => $tag_ids]);
        $blog->tags()->attach(array_map(fn($val) => +$val, $tag_ids));
        return redirect(route("home"));
    }

    public function update(Request $req, Blog $id) {
        if($req->has('image')) {
            $id->update(array_merge(['image' => $req->image->getCLientOriginalName()], $req->except("tag_ids", "image")));
            Storage::disk("public")->delete($id->image);
            $id->uploadImage($req->image);
        } else {
            $id->update($req->except("tag_ids"));
        }
        if($req->has("tag_ids")) {
            $id->tags()->sync($req->tag_ids);
        }
        return redirect("/");
    }

    public function edit(Blog $blog) {
        $tags = Tag::all();
        return view("blog.edit", compact("blog", "tags"));
    }
}
