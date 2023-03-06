<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setup() : void {
        parent::setup();
        $this->withExceptionHandling();
        $this->fakeAuthUser();
     }


    public function test_when_user_create_blog_should_validated()
    {
        $this->get('/create');
        $resp = $this->post("/")->assertRedirect("/create");

        $resp->assertSessionHasErrors(['title', 'body', 'image']);
    }

    public function test_when_user_input_image_should_be_image_validated() {

        $this->get('/create');
        $resp = $this->post("/", ['image' => 12414])->assertRedirect("/create");

        $resp->assertSessionHasErrors('image');
    }
}
