<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function url()
    {
        return Storage::url($this->path);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Image $image) {
            Cache::forget("blog-post-{$image->blogPost->id}"); // Force cache to reset on attached blog post
        });
    }
}
