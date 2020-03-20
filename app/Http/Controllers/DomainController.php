<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use App\Jobs\RequestJob;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::orderBy('id', 'desc')->paginate(10);
        return view('domains.index', compact('domains'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url_scheme = parse_url($request['name'], PHP_URL_SCHEME);
        if ($url_scheme === null) {
            $request['name'] = "http://" . $request['name'];
        }

        $validatedData = $request->validate([
            'name' => 'required|active_url|unique:domains'
        ]);
        $domain = Domain::create($validatedData);

        if ($domain->processingState()->can('process')) {
            dispatch(new RequestJob($domain));
        }

        //Looking for updated domain to add flash message
        $updatedDomain = Domain::find($domain->id);
        $updatedDomain->processingState()->getState() === 'successed' ?
        \Session::flash('success', 'URL has been successfully analyzed!') :
        \Session::flash('danger', 'URL analyze has failed!');

        return redirect()->route('domains.show', compact('domain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain)
    {
        return view('domains.show', compact('domain'));
    }
}
