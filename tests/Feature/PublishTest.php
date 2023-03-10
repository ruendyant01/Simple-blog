<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublishTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_publish_blog()
    {
        $user = $this->fakeAuthUser();
        $blog = $this->createBlog();

        $resp = $this->patch("/".$blog->slug, ["published_at" => now()]);

        $resp->assertStatus(302);
        $this->assertNotNull($blog->fresh()->published_at);
    }

    public function test_can_unpublish_blog() {
        $user = $this->fakeAuthUser();
        $blog = $this->createBlog(["published_at" => now()]);

        $resp = $this->patch("/".$blog->slug, ["published_at" => null]);

        $resp->assertStatus(302);
        $this->assertNull($blog->fresh()->published_at);
    }
}
