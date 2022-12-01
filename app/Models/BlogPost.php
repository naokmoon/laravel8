<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
// use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes, Taggable;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        // Equivalent to hasMany (OneToMany Polymorphic Relation)
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function image()
    {
        // Equivalent to hasOne (OneToOne Polymorphic Relation)
        return $this->morphOne(Image::class, 'imageable');
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

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with('user', 'tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        // Moved all logic in BlogPostObserver instead
        //
        // // Delete or restore child relations "Comments" when the blog post is deleted or restored
        // static::deleting(function (BlogPost $blogPost) {
        //     $blogPost->comments()->delete();
        //     Cache::forget("blog-post-{$blogPost->id}"); // Force cache to reset on delete of a blog post
        // });
        // static::saving(function (BlogPost $blogPost) {
        //     Cache::forget("blog-post-{$blogPost->id}"); // Force cache to reset on update of a blog post
        // });
        // static::restoring(function (BlogPost $blogPost) {
        //     $blogPost->comments()->restore();
        // });
    }
}
