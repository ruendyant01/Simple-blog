<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_get_all_blogs()
    {
        $blog = $this->createBlog(["published_at" => now()],2);

        $response = $this->get('/');

        $response->assertStatus(200);
        
        $response->assertSee($blog[0]->title);
        $response->assertSee($blog[1]->title);
    }

    public function test_user_get_published_single_blog() {
        $user = $this->fakeAuthUser();
        // $user = $this->createUser();
        $blog = $this->createBlog(["published_at" => now(), "user_id" => $user->id]);
        $resp = $this->get("/".$blog->id);
        $resp->assertOk();
        $resp->assertSee($blog->title);
        $resp->assertSee($blog->user->id);
    }

    public function test_user_not_get_published_single_blog() {        
        $user = $this->fakeAuthUser();
        $this->withExceptionHandling();
        $blog = $this->createBlog();

        $resp = $this->get("/".$blog->id);
        $resp->assertNotFound();
    }

    public function test_user_delete_blog() {
        $this->fakeAuthUser();
        $blog = $this->createBlog();

        $resp = $this->delete("/".$blog->id);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseMissing("blogs", ["title" => $blog->title, "body" => $blog->body]);
    }

    public function test_user_create_blog() {
        $user = $this->fakeAuthUser();
        // $user = $this->createUser();
        $data = Blog::factory()->raw();
        $blog = array_merge(["user_id" => $user->id], $data);
        Storage::fake();

        $resp = $this->post("/", ["title" => $blog['title'], "body" => $blog['body'], "image" => $blog["image"], "user_id" => $user->id]);

        $resp->assertCreated();
        $this->assertDatabaseHas("blogs", ["title" => $blog['title'], "body" => $blog['body'], "image" => $blog['image']->name, "user_id" => $user->id]);
        Storage::assertExists($blog['image']->name);
    }

    public function test_user_update_blog() {
        $this->fakeAuthUser();
        $blog = $this->createBlog();
        $title = "update Success";

        $resp = $this->patch("/".$blog->id, ["title" => $title]);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseHas("blogs", ["title" => $title]);
    }

    public function test_user_create_form_blog() {
        $this->fakeAuthUser();
        $resp = $this->get("/create");

        $resp->assertOk();
        $resp->assertSee("Create New Blog");
    }

    public function test_user_edit_form_blog() {
        $user = $this->fakeAuthUser();
        // $user = $this->createUser();
        $blog = $this->createBlog(['user_id' => $user->id]);

        $resp = $this->get("/".$blog->id."/edit");

        $resp->assertOk();
        $resp->assertSee("Edit Blog");
        $resp->assertSee($blog->title);
        $resp->assertSee($blog->user->id);
    }
}
