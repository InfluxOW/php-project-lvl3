<?php

namespace App\Jobs;

use App\Enums\DomainTransition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use DiDom\Document;
use App\Domain;
use Illuminate\Support\Arr;

class RequestJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $domain;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    public function handle(Client $client): void
    {
        $this->domain->stateMachine()->apply(DomainTransition::PROCESS);
        $this->domain->save();

        $response = $client->get($this->domain->name, ['http_errors' => false]);

        $responseCode = $response->getStatusCode();
        if ($responseCode >= 400 && $responseCode < 600) {
            $this->domain->stateMachine()->apply(DomainTransition::FAIL);
            $this->domain->update(['response_code' => $responseCode]);

            return;
        }

        $body = mb_convert_encoding($response->getBody(), 'UTF-8');
        $contentLength = Arr::first($response->getHeader('content-length')) ?? mb_strlen($body);

        $data = [
            'body' => $body,
            'content_length' => $contentLength,
            'response_code' => $responseCode,
        ];

        $html = new Document($body);

        $data['h1'] = $html->has('h1') ? $html->first('h1')->text() : null;
        $data['keywords'] = $html->has('meta[name=keywords]') ?
            $html->first('meta[name=keywords]')->attr('content') : null;
        $data['description'] = $html->has('meta[name=description]') ?
            $html->first('meta[name=description]')->attr('content') : null;

        $this->domain->stateMachine()->apply(DomainTransition::SUCCESS);
        $this->domain->update($data);
    }
}
