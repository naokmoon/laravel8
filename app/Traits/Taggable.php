<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable
{
    protected static function bootTaggable()
    {
        static::updated(function ($model) {
            $model->tags()->sync(static::findTagsInContent($model->content));
        });

        static::created(function ($model) {
            $model->tags()->sync(static::findTagsInContent($model->content));
        });

    }

    public function tags()
    {
        // Used for ManyToMany Polymorphic Relation using a Pivot Table 'taggables')
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    private static function findTagsInContent($content)
    {
        preg_match_all('/@([^@]+)@/m', $content, $tags);

        return Tag::whereIn('name', $tags[1] ?? [])->get();
    }
}
