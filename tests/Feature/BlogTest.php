<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{

    public function setup() : void {
        parent::setup();
        $this->fakeAuthUser();
    }

    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_get_all_blogs()
    {
        $blog = $this->createBlog(["published_at" => now()],2);
        $tag = $this->createTag([],2);
        $blog[0]->tags()->attach($tag->pluck("id"));

        $response = $this->get('/');

        $response->assertStatus(200);
        
        $response->assertSee($blog[0]->title);
        $response->assertSee($blog[1]->title);
        $response->assertSee($tag->first()->name);
        $response->assertSee($tag[1]->name);
    }

    public function test_user_get_published_single_blog() {
        $blog = $this->createBlog(["published_at" => now(), "user_id" => auth()->user()->id]);
        $resp = $this->get("/".$blog->slug);
        $resp->assertOk();
        $resp->assertSee($blog->title);
        $resp->assertSee(auth()->user()->id);
    }

    public function test_user_not_get_published_single_blog() {        
        $this->withExceptionHandling();
        $blog = $this->createBlog();

        $resp = $this->get("/".$blog->slug);
        $resp->assertNotFound();
    }

    public function test_user_delete_blog() {
        $blog = $this->createBlog();
        $tag = $this->createTag();
        $blog->tags()->attach($tag->id);

        $resp = $this->delete("/".$blog->slug);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseMissing("tags", ["name" => $tag->name]);
        $this->assertDatabaseMissing("blog_tag", ['tag_id' => $tag->id, "blog_id" => $blog->id]);
        $this->assertDatabaseMissing("blogs", ["title" => $blog->title, "body" => $blog->body, "user_id" => $blog->user_id]);
    }

    public function test_user_create_blog() {
        $data = Blog::factory()->raw();
        // $tag = Tag::factory()->raw();
        $tag = $this->createTag();
        $blog = array_merge(["user_id" => auth()->user()->id, "tag_ids" => [$tag->id]], $data);
        Storage::fake();

        $resp = $this->post("/", $blog);

        $resp->assertStatus(302);
        $resp->assertRedirect(route("home"));
        $this->assertDatabaseHas("blogs", ["title" => $blog['title'], "body" => $blog['body'], "image" => $blog['image']->name, "user_id" => auth()->user()->id, "slug" => Str::slug($blog['title'])]);
        $this->assertDatabaseHas("blog_tag", ['tag_id' => $tag->id]);
        // $this->assertDatabaseHas("blog_tag", ['tag_id' => $tag[1]->id]);
        Storage::disk("public")->assertExists($blog['image']->name);
    }

    public function test_user_update_blog() {
        $blog = $this->createBlog();
        $tag = $this->createTag([],2);
        $blog->tags()->attach($tag->pluck("id"));
        $title = "update Success";

        $resp = $this->patch("/".$blog->slug, ["title" => $title, "tag_ids" => $tag[0]->id]);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseHas("blogs", ["title" => $title]);
        $this->assertDatabaseMissing("blog_tag", [
            'blog_id' => $blog->id,
            'tag_id' => $tag[1]->id
        ]);
    }

    public function test_user_create_form_blog() {
        $resp = $this->get("/create");

        $resp->assertOk();
        $resp->assertSee("Create New Blog");
    }

    public function test_user_edit_form_blog() {
        $blog = $this->createBlog(['user_id' => auth()->user()->id]);

        $resp = $this->get("/".$blog->slug."/edit");

        $resp->assertOk();
        $resp->assertSee("Edit Blog");
        $resp->assertSee($blog->title);
        $resp->assertSee($blog->user->name);
    }
}
