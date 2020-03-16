<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }
}
