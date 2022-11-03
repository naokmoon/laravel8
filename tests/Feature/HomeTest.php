<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

//     public function testHomePageIsWorkingCorrectly()
//     {
//         $response = $this->actingAs($this->user())->get('/home');
//
//         $response->assertSeeText('Welcome to Laravel!');
//         $response->assertSeeText('This is the content of the main page!');
//     }

    public function testContactPageIsWorkingCorrectly()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact page');
        $response->assertSeeText('Hello this is contact!');
    }
}
