<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class DomainControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDomainsIndex()
    {
        factory(Domain::class, 10)->create();
        $response = $this->get(route('domains.index'));
        $response->assertStatus(200);
    }

    public function testDomainsShow()
    {
        $domain = factory(Domain::class)->create();
        $response = $this->get(route('domains.show', compact('domain')));
        $response->assertStatus(200);
    }

    public function testDomainsStore()
    {
        $headers = [];
        $body = "<body><h1>Hello!</h1></body>";

        $mock = new MockHandler([new Response(200, $headers, $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $client);

        $response = $this->post(route('domains.store', ['name' => 'https://testsite.com']));
        $response->assertStatus(302);
        $this->assertDatabaseHas("domains", ['h1' => 'Hello!', 'name' => 'https://testsite.com']);
    }
}
