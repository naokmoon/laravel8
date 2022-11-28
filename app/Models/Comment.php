<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes, Taggable;

    protected $fillable = ['user_id', 'content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function scopeAbcLatest(Builder $query) // scopeLatest comes by default with Laravel now
    // {
    //     return $query->orderBy(static::CREATED_AT, 'desc');
    // }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            // Force cache to reset on creation of new comment for a blog post
            if ($comment->commentable_type === BlogPost::class) {
                Cache::forget("blog-post-{$comment->commentable_id}");
                Cache::forget("mostCommented");
            }
        });

        // static::addGlobalScope(new LatestScope);
    }
}
