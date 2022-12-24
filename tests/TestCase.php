<?php

namespace Tests;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user(): User
    {
        return User::factory()->create();
    }

    protected function blogPost()
    {
        return BlogPost::factory()->create([
            'user_id' => $this->user()->id
        ]);
    }
}
