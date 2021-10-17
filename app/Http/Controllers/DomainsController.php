<?php

namespace App\Http\Controllers;

use App\Domain;
use App\Enums\DomainTransition;
use App\Http\Requests\DomainRequest;
use Illuminate\Http\RedirectResponse;
use App\Jobs\RequestJob;
use Illuminate\View\View;

class DomainsController extends Controller
{
    public function index(): View
    {
        $domains = Domain::orderBy('id', 'desc')->paginate(10);

        return view('domains.index', compact('domains'));
    }

    public function store(DomainRequest $request): RedirectResponse
    {
        if (Domain::where('name', $request->name)->exists()) {
            $domain = Domain::where('name', $request->name)->first();

            flash('URL is already in the database.')->info();

            return redirect()->route('domains.show', compact('domain'));
        }

        $domain = Domain::create($request->validated());

        if ($domain->stateMachine()->can(DomainTransition::PROCESS)) {
            dispatch(new RequestJob($domain));
        }

        flash('URL is processing! Update the page in a few seconds.')->info();

        return redirect()->route('domains.show', compact('domain'));
    }

    public function show(Domain $domain): View
    {
        return view('domains.show', compact('domain'));
    }
}
