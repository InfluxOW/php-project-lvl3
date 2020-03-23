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

    public function testDomainsStoreWithValidUrl()
    {
        $this->createTestMockWithResponseCode200();

        $this->post(route('domains.store', ['name' => 'https://testsite.com']))
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("domains", [
            'h1' => 'Hello!',
            'response_code' => '200',
            'name' => 'https://testsite.com',
            'state' => 'successed'
            ]);
    }

    public function testDomainsStoreWithNonexistentUrl()
    {
        $this->createTestMockWithResponseCode404();

        $this->post(route('domains.store', ['name' => 'https://nonexistenturl.com']))
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("domains", [
            'h1' => null,
            'response_code' => '404',
            'name' => 'https://nonexistenturl.com',
            'state' => 'failed'
            ]);
    }

    public function testDomainsStoreValidationFail()
    {
        $this->createTestMockWithResponseCode200();

        $this->post(route('domains.store', ['name' => 'blabla']))
            ->assertStatus(302)
            ->assertSessionHasErrors();

        $this->assertDatabaseMissing("domains", ['h1' => 'Hello!', 'name' => 'blabla']);
    }

    private function createTestMockWithResponseCode200()
    {
        $headers = [];
        $body = "<body><h1>Hello!</h1></body>";

        $mock = new MockHandler([new Response(200, $headers, $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $client);
    }

    private function createTestMockWithResponseCode404()
    {
        $headers = [];
        $body = "";

        $mock = new MockHandler([new Response(404, $headers, $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $client);
    }
}
