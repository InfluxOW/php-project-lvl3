<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use DiDom\Document;
use App\Domain;

class RequestJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     * @param  Domain  $domain
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $client)
    {
        $this->domain->stateMachine()->apply('process');
        $this->domain->save();
        //Making request
        $response = $client->get($this->domain->name, ['http_errors' => false]);

        //Current site parsing
        $responseCode = $response->getStatusCode();
        if ($responseCode >= 400 && $responseCode < 500) {
            $this->domain->stateMachine()->apply('fail');
            $this->domain->update(['response_code' => $responseCode]);
            \Session::flash('danger', 'URL analyze has failed!');
            return;
        }
        $body = mb_convert_encoding($response->getBody(), 'UTF-8');
        $contentLength = $response->getHeader('content-length')[0] ?? mb_strlen($body);

        $data = [
            'body' => $body,
            'content_length' => $contentLength,
            'response_code' => $responseCode,
        ];

        //Creating new site for searching with the current site's body
        $document = new Document($body);

        //Looking for needed tags
        $data['h1'] = $document->has('h1') ? $document->first('h1')->text() : null;
        $data['keywords'] = $document->has('meta[name=keywords]') ?
            $document->first('meta[name=keywords]')->attr('content') : null;
        $data['description'] = $document->has('meta[name=description]') ?
            $document->first('meta[name=description]')->attr('content') : null;

        //Updating current domain's info in the DB using all parsed data
        $this->domain->stateMachine()->apply('success');
        \Session::flash('success', 'URL has been successfully analyzed!');
        $this->domain->update($data);
    }
}
