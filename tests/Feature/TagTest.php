<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setup() : void {
        parent::setup();
        $this->fakeAuthUser();
     }

    public function test_user_can_create_tag()
    {
        $tag = Tag::factory()->raw();
        $res = $this->post("/tag", ["name" => $tag['name']]);

        $res->assertStatus(302);
        $res->assertRedirect(route("tag.index"));
        $this->assertDatabaseHas("tags", ['name' => $tag['name']]);
    }

    public function test_user_can_get_all_tag() {
        $tag = $this->createTag([],2);
        
        $res = $this->get('/tag');

        $res->assertOk();
        $res->assertSee($tag[0]->name);
        $res->assertSee($tag[1]->name);
    }

    public function test_user_can_delete_tag() {
        $blog = $this->createBlog();
        $tag = $this->createTag();
        $tag->blogs()->attach($blog->id);

        $res = $this->delete("/tag/".$tag->slug);

        $res->assertStatus(302);
        $res->assertRedirect(route("tag.index"));
        $this->assertDatabaseMissing("tags",["name" => $tag->name]);
        $this->assertDatabaseMissing("blogs",["title" => $blog->title]);
        $this->assertDatabaseMissing("blog_tag",["tag_id" => $tag->id, "blog_id" => $blog->id]);
    }

    public function test_user_create_from_tag() {
        $res = $this->get(route("tag.create"));

        $res->assertOk();
        $res->assertSee("Create New Tag");
    }

    public function test_user_edit_from_tag() {
        $tag = $this->createTag();
        $res = $this->get(route("tag.edit", ['tag' => $tag->slug]));

        $res->assertOk();
        $res->assertSee("Edit Blog");
        $res->assertSee($tag->name);
    }
}
