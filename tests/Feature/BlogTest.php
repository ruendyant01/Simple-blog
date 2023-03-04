<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setup() : void {
        parent::setUp();
        $this->withoutExceptionHandling();
     }

    public function test_user_get_all_blogs()
    {
        $blog = $this->createBlog();

        $response = $this->get('/');
        // $response = $this->get('/'.$blog->id);

        $response->assertStatus(200);
        $response->assertSee($blog[0]);
    }

    public function test_user_get_single_blog() {
        $blog = $this->createBlog();

        $resp = $this->get("/".$blog->id);
        $resp->assertOk();
        $resp->assertSee($blog->title);
    }

    public function test_user_delete_blog() {
        $blog = $this->createBlog();

        $resp = $this->delete("/".$blog->id);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseMissing("blogs", ["title" => $blog->title, "body" => $blog->body]);
    }

    public function test_user_create_blog() {
        $title = "test1";
        $body = "testing2";
        $resp = $this->post("/", ["title" => $title, "body" => $body]);

        $resp->assertCreated();
        $this->assertDatabaseHas("blogs", ["title" => $title, "body" => $body]);
    }

    public function test_user_update_blog() {
        $blog = $this->createBlog();
        $title = "update Success";

        $resp = $this->patch("/".$blog->id, ["title" => $title]);

        $resp->assertStatus(302);
        $resp->assertRedirect("/");
        $this->assertDatabaseHas("blogs", ["title" => $title]);
    }

    protected function createBlog($data = []) {
        return Blog::factory()->create($data);
    }
}
