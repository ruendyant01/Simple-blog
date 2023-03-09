<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;

class BlogTagTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_relations_between_blogs_and_tags()
    {
        $blog = $this->createBlog();
        $tag = $this->createTag();
        $blog->tags()->attach($tag->id);

        $this->assertInstanceOf(Tag::class, $blog->tags[0]);
    }
}
