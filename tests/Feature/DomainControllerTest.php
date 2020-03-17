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
            ->assertSessionHas('success');
        $this->assertDatabaseHas("domains", ['h1' => 'Hello!', 'name' => 'https://testsite.com']);
        $this->assertEquals(\Session::get('success'), "URL has been successfully analyzed!");
    }

    public function testDomainsStoreWithNonexistentUrl()
    {
        $this->createTestMockWithResponseCode404();

        $this->post(route('domains.store', ['name' => 'https://nonexistenturl.com']))
            ->assertStatus(302)
            ->assertSessionHas('danger');
        $this->assertDatabaseHas("domains", ['response_code' => '404', 'name' => 'https://nonexistenturl.com']);
        $this->assertEquals(\Session::get('danger'), "URL analyze has failed!");
    }

    public function testDomainsStoreFail()
    {
        $this->createTestMockWithResponseCode200();

        $this->post(route('domains.store', ['name' => 'blabla']))
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $errorMessages = \Session::get('errors')->all();
        $this->assertTrue(in_array('The name is not a valid URL.', $errorMessages));
        $this->assertDatabaseMissing("domains", ['h1' => 'Hello!', 'name' => 'blabla']);
    }

    private function createTestMockWithResponseCode200()
    {
        $headers = [];
        $body = "<body><h1>Hello!</h1></body>";

        $mock = new MockHandler([new Response(200, $headers, $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        return $this->app->instance(Client::class, $client);
    }

    private function createTestMockWithResponseCode404()
    {
        $headers = [];
        $body = "";

        $mock = new MockHandler([new Response(404, $headers, $body)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        return $this->app->instance(Client::class, $client);
    }
}
