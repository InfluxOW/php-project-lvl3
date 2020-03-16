@extends('layouts.app')

@section('content')
<div class="container-fullwidth">
    <table class="table table-bordered text-center">
        <thead class="thead-light">
            <tr class="d-flex">
                <th class="col-md-1">#</th>
                <th class="col-md-2">URL</th>
                <th class="col-md-1">Response Code</th>
                <th class="col-md-1">Content Length</th>
                <th class="col-md-1">Main header</th>
                <th class="col-md-3">Description</th>
                <th class="col-md-1">Keywords</th>
                <th class="col-md-2">Creation Date</th>
            </tr>
        </thead>
        <tbody class="section section-step">
            @if ($domain->getState() === 'failed')
            <tr class="table-danger d-flex align-items-center table-borderless">
            @else
            <tr class="table-success d-flex align-items-center table-borderless">
            @endif
            <td class="col-md-1">{{ $domain->id }}</td>
            <td class="col-md-2"><a href="{{ $domain->name }}" style="color: #0000CC; opacity: 0.5">{{ $domain->name }}</a></td>
            <td class="col-md-1">{{ $domain->response_code }}</td>
            <td class="col-md-1">{{ $domain->content_length ?? '---' }}</td>
            <td class="col-md-1">{{ strlen($domain->h1) > 2 ? $domain->h1 : '---' }}</td>
            <td class="col-md-3">{{ $domain->description ?? '---' }}</td>
            <td class="col-md-1">{{ $domain->keywords ?? '---' }}</td>
            <td class="col-md-2">{{ $domain->created_at }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
