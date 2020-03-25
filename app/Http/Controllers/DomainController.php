<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use App\Jobs\RequestJob;
use Validator;

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

        //Making uniqueness validation of the URL
        $uniquenessValidator = Validator::make($request->all(), [
            'name' => 'unique:domains',
        ]);
        //If the specified site is already in the DB we're redirecting to its page
        if ($uniquenessValidator->fails()) {
            $domain = Domain::where('name', $request['name'])->first();
            flash('URL is already in the database.')->info();
            return redirect()->route('domains.show', $domain);
        };
        ////Making other validations of the URL
        $validatedData = $request->validate([
            'name' => 'required|active_url'
        ]);
        $domain = Domain::create($validatedData);

        if ($domain->processingState()->can('process')) {
            dispatch(new RequestJob($domain));
        }

        flash('URL is processing! Update the page in a few seconds.')->info();

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
