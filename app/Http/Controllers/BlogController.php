<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogController extends Controller
{
    //
    public function index() {
        $blog = Blog::all();
        // dd($blog);
        // dd(compact($blog));
        return view("blog.index", ["blog" => $blog]);
    }

    public function show(Blog $id) {
        // dd($id);
        return view("blog.show", ["show" => $id]);
    }

    public function destroy(Blog $id) {
        $id->delete();
        return redirect("/");
    }

    public function store(Request $req) {
        $blog = Blog::create($req->all());
        // dd($blog);
        return response($blog, Response::HTTP_CREATED);
    }

    public function update(Request $req, Blog $id) {
        $id->update($req->all());
        return redirect("/");
    }
}
