<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }

    public function testAbout()
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }
}
