<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
} 