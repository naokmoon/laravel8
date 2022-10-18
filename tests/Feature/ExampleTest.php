<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        $response = $this->actingAs($this->user())->get('/');

        $response->assertStatus(200);
    }
}

// $object = new BlogPost();
// $object->save();
// $this->assertTrue($object->id !== null);
