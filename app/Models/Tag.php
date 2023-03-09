<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function booted() : void {
        static::creating(function(Tag $tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function blogs() {
        return $this->belongsToMany(Blog::class);
    }
}
