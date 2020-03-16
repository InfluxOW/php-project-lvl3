<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SM\Factory\Factory as SMFactory;

class Domain extends Model
{
    protected $fillable = ['name', 'content_length', 'response_code', 'body', 'h1', 'description', 'keywords', 'state'];
    protected $hidden = ['body'];
    protected $attributes = [
        'state' => 'waiting'
    ];

    public function stateMachine()
    {
        $factory = new SMFactory(config('state-machine'));
        return $factory->get($this, 'domain');
    }
}
