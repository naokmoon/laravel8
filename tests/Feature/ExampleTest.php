<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

// $object = new BlogPost();
// $object->save();
// $this->assertTrue($object->id !== null);
