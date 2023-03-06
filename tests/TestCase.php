<?php

namespace Tests;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,RefreshDatabase;

    public function setup() : void {
        parent::setUp();
        $this->withoutExceptionHandling();
     }

     protected function createBlog($data = [], $num = null) {
        return Blog::factory($num)->create($data);
    }
     protected function createUser($data = [], $num = null) {
        return User::factory($num)->create($data);
    }

    protected function fakeAuthUser() {
        $user = $this->createUser();
        $this->actingAs($user);
    }
}
