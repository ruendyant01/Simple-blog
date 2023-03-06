<?php

namespace Tests\Unit;

use App\Models\Blog;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_have_many_blogs()
    {
        $user = $this->createUser();
        $blog = $this->createBlog(["user_id" => $user->id]);

        $this->assertInstanceOf(Blog::class, $user->blogs[0]);
    }
}
