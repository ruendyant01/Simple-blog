<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            // var_dump($user);
            $blog->slug = Str::slug($blog->title);
        });
        static::updating(function (Blog $blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }
    use HasFactory;

    // protected $fillable = ["title", "body"];
    protected $guarded = [];

    public function scopePublished(Builder $query) : void {
        $query->whereNotNull("published_at", null);
    }

    public function uploadImage($image) {
        Storage::disk("public")->put($image->getClientOriginalName(), $image->get());
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
