<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name', 'content_length', 'response_code', 'body', 'h1', 'description', 'keywords', 'state'];
    protected $hidden = ['body'];

    public function wait()
    {
        $this['state'] = 'waiting';
    }

    public function process()
    {
        $this['state'] = 'processing';
    }

    public function fail()
    {
        $this['state'] = 'failed';
    }

    public function success()
    {
        $this['state'] = 'successed';
    }

    public function getState()
    {
        return $this['state'];
    }
}
