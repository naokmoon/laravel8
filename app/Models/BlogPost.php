<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
// use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function scopeAbcLatest(Builder $query) // scopeLatest comes by default with Laravel now
    // {
    //     return $query->orderBy(static::CREATED_AT, 'desc');
    // }

    public function scopeMostCommented(Builder $query)
    {
        // comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        // static::addGlobalScope(new LatestScope);

        // Delete or restore child relations "Comments" when the blog post is deleted or restored
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });

        // Reset cache on update of a blog post to be able getting the fresh data right after when we consult it in show() method.
        // Otherwise, it would get data from OLD cache.
        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
        });
    }
}
