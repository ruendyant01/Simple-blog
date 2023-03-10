<?php

namespace Tests\Unit;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_upload_image_for_blog()
    {
        $blog = new Blog();
        $image = UploadedFile::fake()->image("photo.png", 50,50);

        $blog->uploadImage($image);

        Storage::disk("public")->assertExists($image->name);
    }

    public function test_user_and_blog_relationship() {
        $user = $this->createUser();
        $blog = $this->createBlog(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $blog->user);
    }

    public function test_while_deleting_blog_image_should_get_deleted() {
        $blog = new Blog();
        $image = UploadedFile::fake()->image("photo10.jpg");

        $blog->uploadImage($image);
        $blog->deleteImage($image->name);

        Storage::disk("public")->assertMissing($image->name);
    }
}
