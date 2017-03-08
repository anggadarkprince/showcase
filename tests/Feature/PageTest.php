<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomePageAvailability()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPageNotFound()
    {
        $response = $this->call('get', '/not-found-uri')
            ->assertSee('Page Not Found');

        $response->assertStatus(404);
    }
}
